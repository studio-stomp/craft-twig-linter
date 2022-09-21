<?php
declare(strict_types=1);

namespace tests\modules\general;

use Craft;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use yii\base\Module;

final class ChecksIsConsoleRequestModule extends Module
{
    public function init()
    {
        parent::init();

        if (Craft::$app->getRequest()->getIsConsoleRequest()) {
            return;
        }

        Craft::$app->view->registerTwigExtension(
            new class extends AbstractExtension {
                public function getName(): string
                {
                    return 'Checks is ConsoleRequest Twig Extension';
                }

                public function getFunctions(): array
                {
                    return [
                        new TwigFunction('checksIsConsoleRequest', static function () {
                            return 'Result from `checksIsConsoleRequest()`';
                        }),
                    ];
                }
            }
        );
    }
}
