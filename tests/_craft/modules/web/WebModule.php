<?php
declare(strict_types=1);

namespace tests\modules\web;

use Craft;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use yii\base\Module;

final class WebModule extends Module
{
    public function init()
    {
        parent::init();

        Craft::$app->view->registerTwigExtension(
            new class extends AbstractExtension {
                public function getName(): string
                {
                    return 'Web Twig Extension';
                }

                public function getFunctions(): array
                {
                    return [
                        new TwigFunction('web', static function () {
                            return 'Result from `web()`';
                        }),
                    ];
                }
            }
        );
    }
}
