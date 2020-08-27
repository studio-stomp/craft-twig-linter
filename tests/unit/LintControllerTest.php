<?php
declare(strict_types=1);

namespace studiostomp\crafttwiglintertests\unit;

use Craft;
use craft\test\console\ConsoleTest;
use Exception;
use Generator;
use studiostomp\crafttwiglinter\console\controllers\LintController;
use studiostomp\crafttwiglinter\CraftTwigLinter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use yii\console\ExitCode;

final class LintControllerTest extends ConsoleTest
{
    /**
     * @dataProvider providesPaths
     *
     * @param array $paths
     *
     * @throws Exception
     */
    public function testLinter(array $paths): void
    {
        // Register custom function
        Craft::$app->view->registerTwigExtension(
            new class extends AbstractExtension {
                public function getFunctions(): array
                {
                    return [
                        new TwigFunction('do_foo_bar', static function () {
                            return 'foo bar';
                        }),
                    ];
                }
            }
        );

        $sut = new LintController(
            'craft-twig-linter',
            CraftTwigLinter::getInstance(),
            []
        );

        if (!$sut) {
            self::fail('Could not instantiate Subject under Test');
        }

        $actual = $sut->actionIndex(...$paths);

        self::assertEquals(ExitCode::OK, $actual);
    }

    public function providesPaths(): Generator
    {
        yield 'single file' => [
            'paths' => [
                './tests/_craft/templates/standard_functionality.twig',
            ],
        ];

        yield 'single directory, multiple files' => [
            'paths' =>  [
                './tests/_craft/templates/dir_1',
            ],
        ];

        yield 'multiple directories' => [
            'paths' => [
                './tests/_craft/templates/dir_1',
                './tests/_craft/templates/dir_2',
            ],
        ];

        yield 'custom registered function' => [
            'paths' => [
                './tests/_craft/templates/craft_registered_functionality.twig',
            ],
        ];
    }
}
