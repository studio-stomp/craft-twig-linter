<?php
declare(strict_types=1);

namespace tests\modules\console;

use Craft;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use yii\base\Module;

final class ConsoleModule extends Module
{
    public function init()
    {
        parent::init();

        Craft::$app->view->registerTwigExtension(
            new class extends AbstractExtension {
                public function getName(): string
                {
                    return 'Console Twig Extension';
                }

                public function getFunctions(): array
                {
                    return [
                        new TwigFunction('console', static function () {
                            return 'Result from `console()`';
                        }),
                    ];
                }
            }
        );
    }
}
