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
     */
    public function testLinter(array $paths): void
    {
        Craft::$app->getView()->registerTwigExtension(
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

        try {
            $actual = $sut->actionIndex(...$paths);
        } catch (Exception $e) {
            self::fail($e->getMessage());
        }

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

    /**
     * @dataProvider providesFaultyPaths
     *
     * @param array $paths
     * @param string $expected
     */
    public function testLinterOnFaultyTemplates(array $paths, string $expected): void {
        $this->expectOutputRegex($expected);

        $sut = new LintController(
            'craft-twig-linter',
            CraftTwigLinter::getInstance(),
            []
        );

        if (!$sut) {
            self::fail('Could not instantiate Subject under Test');
        }

        try {
            $actual = $sut->actionIndex(...$paths);
        } catch (Exception $e) {
            self::fail($e->getMessage());
        }

        self::assertNotEquals(ExitCode::OK, $actual);
    }

    public function providesFaultyPaths(): Generator
    {
        yield 'Do not use `===`' => [
            'paths' => [
                './tests/_craft/templates/faulty/comparison_strictly.twig',
            ],
            'expected' => '~Did you try to use "===" or "!==" for strict comparison\?~',
        ];

        yield 'Undefined filter' => [
            'paths' => [
                './tests/_craft/templates/faulty/filter.twig',
            ],
            'expected' => '~Unknown "idonotexist" filter~',
        ];

        yield 'Undefined function' => [
            'paths' => [
                './tests/_craft/templates/faulty/function.twig',
            ],
            'expected' => '~Unknown "idonotexist" function~',
        ];

        yield 'Undefined tag' => [
            'paths' => [
                './tests/_craft/templates/faulty/tag.twig',
            ],
            'expected' => '~Unknown "idonotexist" tag~',
        ];

        yield 'Undefined test' => [
            'paths' => [
                './tests/_craft/templates/faulty/test.twig',
            ],
            'expected' => '~Unknown "idonotexist" test~',
        ];
    }
}
