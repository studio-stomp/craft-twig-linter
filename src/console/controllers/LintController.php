<?php
declare(strict_types=1);
/**
 * Craft Twig Linter for Craft CMS 3.x
 *
 * A module for Craft CMS bringing sserbin/twig-linter to Craft CMS projects
 *
 * @link      https://studiostomp.nl
 * @copyright Copyright (c) 2020 Studio Stomp
 */

namespace studiostomp\crafttwiglinter\console\controllers;

use craft\helpers\ArrayHelper;
use craft\helpers\Console;
use craft\web\Request;
use craft\web\View;
use Exception;
use PackageVersions\Versions;
use ReflectionProperty;
use Sserbin\TwigLinter\Command\LintCommand;

use Craft;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Twig\Extension\ExtensionInterface;
use yii\console\Controller;
use yii\console\widgets\Table;

/**
 * Lint Command
 *
 * The first line of this class docblock is displayed as the description
 * of the Console Command in ./craft help
 *
 * Craft can be invoked via commandline console by using the `./craft` command
 * from the project root.
 *
 * Console Commands are just controllers that are invoked to handle console
 * actions. The segment routing is plugin-name/controller-name/action-name
 *
 * The actionIndex() method is what is executed if no sub-commands are supplied, e.g.:
 *
 * ./craft craft-twig-linter/lint
 *
 * Actions must be in 'kebab-case' so actionDoSomething() maps to 'do-something',
 * and would be invoked via:
 *
 * ./craft craft-twig-linter/lint/do-something
 *
 * @author    Studio Stomp
 * @package   CraftTwigLinter
 * @since     0.1.0
 */
final class LintController extends Controller
{
    /**
     * Handle craft-twig-linter/lint console commands
     *
     * The first line of this method docblock is displayed as the description
     * of the Console Command in ./craft help
     *
     * @param string ...$paths
     *
     * @return int
     * @throws Exception
     */
    public function actionIndex(string ...$paths): int
    {
        // Get current app as it's a properly registered console app
        $consoleApp = Craft::$app;
        $consoleView = $consoleApp->getView();

        // Also create a Web Application to get all template paths for web-only modules and plugins
        $web_app_config = $this->retrieveWebAppConfig($consoleApp->getVendorPath());

        /** @var \craft\web\Application $webApp */
        $webApp = Craft::createObject($web_app_config);
        $webView = $webApp->getView();

        $reflected_property = new ReflectionProperty(View::class, '_twigExtensions');
        $reflected_property->setAccessible(true);
        /** @var array<ExtensionInterface> $console_twig_extensions */
        $console_twig_extensions = $reflected_property->getValue($consoleView);
        /** @var array<ExtensionInterface> $web_twig_extensions */
        $web_twig_extensions   = $reflected_property->getValue($webView);
        $registered_extensions = ArrayHelper::merge(
            $console_twig_extensions,
            $web_twig_extensions
        );
        $reflected_property->setValue($webView, $registered_extensions);

        // Restore current app (which should be console, but for restoring doesn't matter)
        Craft::$app = $consoleApp;

        $command = new LintCommand($webView->createTwig());

        $app = new Application('twig-linter', Versions::getVersion('sserbin/twig-linter'));
        $app->setAutoExit(false);
        $app->add($command);
        $app->setDefaultCommand('lint');

        $input = new ArrayInput([
            'command' => 'lint',
            'filename' => $paths,
            '--format' => 'json',
        ]);

        $capturing_output = new BufferedOutput();

        try {
            $exit_code = $app->run($input, $capturing_output);
        } catch (Exception $e) {
            Console::error($e->getMessage());

            throw $e;
        }

        // Gather the results
        $results = json_decode(
            $capturing_output->fetch() ?: '[]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        // Filter out only the files with errors
        $errors = array_filter($results, static function (array $result) {
            return false === $result['valid'];
        });

        $count_results = count($results);
        $count_errors = count($errors);

        if ($count_errors) {
            $result_message = "ERRORS (total {$count_results} files, {$count_errors} errors)" ;
            $ansi = [
                Console::FG_RED,
            ];
        } else {
            $result_message = "OK  (total {$count_results} files checked)";
            $ansi = [
                Console::FG_GREEN,
            ];
        }

        echo $this->ansiFormat($result_message, ...$ansi) . PHP_EOL;

        if ($count_errors) {
            // Output an overview of the errors
            $error_table = new Table();
            echo $error_table->setHeaders(['Error', 'Line', 'File'])
                             ->setRows(
                                 array_map(
                                     static function ($error_info) {
                                         return [
                                             $error_info['message'],
                                             $error_info['line'],
                                             $error_info['file'],
                                         ];
                                     },
                                     $errors
                                 )
                             )
                             ->run();
        }

        return $exit_code;
    }

    /**
     * @return array{'components':array,'class':class-string}
     */
    private function retrieveWebAppConfig(string $vendor_path): array
    {
        return ArrayHelper::merge(
            require Craft::$app->getBasePath() . '/config/app.php',
            require Craft::$app->getBasePath() . '/config/app.web.php',
            Craft::$app->getConfig()->getConfigFromFile('app'),
            Craft::$app->getConfig()->getConfigFromFile('app.web'),
            [
                'components' => [
                    'config' => Craft::$app->getConfig(),
                    'request' => static function() {
                        // Set a request uri to allow instantiation of Request class; it depends on a URI, looked for in also REQUEST_URI
                        $_SERVER['REQUEST_URI'] = 'https://example.com';

                        // Let Craft build the object
                        /** @var craft\web\Request $request */
                        $request = Craft::createObject([
                            'class' => Request::class,
                        ]);

                        // Force the request to be a web request, otherwise this will be determined from current runtime environment
                        $request->setIsConsoleRequest(false);

                        return $request;
                    },
                ],
                'isInstalled' => true,
                'vendorPath' => $vendor_path,
            ]
        );
    }
}
