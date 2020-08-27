<?php
declare(strict_types=1);
/**
 * Craft Twig Linter plugin for Craft CMS 3.x
 *
 * A plugin for Craft CMS bringing sserbin/twig-linter to Craft CMS projects
 *
 * @link      https://studiostomp.nl
 * @copyright Copyright (c) 2020 Studio Stomp
 */

namespace studiostomp\crafttwiglinter\console\controllers;

use craft\helpers\Console;
use Exception;
use PackageVersions\Versions;
use Sserbin\TwigLinter\Command\LintCommand;

use Craft;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use yii\console\Controller;

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
        $command = new LintCommand(Craft::$app->getView()->getTwig());

        $app = new Application('twig-linter', Versions::getVersion('sserbin/twig-linter'));
        $app->setAutoExit(false);
        $app->add($command);
        $app->setDefaultCommand('lint');

        $input = new ArrayInput([
            'command' => 'lint',
            'filename' => $paths,
            '--format' => 'json',
        ]);

        try {
            return $app->run($input);
        } catch (Exception $e) {
            Console::error($e->getMessage());

            throw $e;
        }
    }
}
