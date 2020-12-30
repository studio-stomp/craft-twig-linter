<?php
declare(strict_types=1);

namespace studiostomp\crafttwiglinter;

use Craft;
use yii\base\Module;

final class CraftTwigLinter extends Module
{
    public $controllerNamespace = __NAMESPACE__ . '\\console\\controllers';

    public function init(): void
    {
        parent::init();

        Craft::setAlias(
            '@studiostomp/crafttwiglinter',
            $this->getBasePath()
        );
    }
}
