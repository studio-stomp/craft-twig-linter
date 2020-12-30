<?php
declare(strict_types=1);

namespace tests\modules\general;

use Craft;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use yii\base\Module;

final class GeneralModule extends Module
{
    public function init()
    {
        parent::init();

        Craft::$app->view->registerTwigExtension(
            new class extends AbstractExtension {
                public function getName(): string
                {
                    return 'General Twig Extension';
                }

                public function getFunctions(): array
                {
                    return [
                        new TwigFunction('general', static function () {
                            return 'Result from `general()`';
                        }),
                    ];
                }
            }
        );
    }
}
