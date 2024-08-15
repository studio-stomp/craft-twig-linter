<?php
declare(strict_types=1);

use studiostomp\crafttwiglinter\CraftTwigLinter;
use tests\modules\general\ChecksIsConsoleRequestModule;
use tests\modules\general\GeneralModule;

return [
    'modules' => [
        'checksIsConsoleRequest' => ChecksIsConsoleRequestModule::class,
        'craft-twig-linter' => CraftTwigLinter::class,
        'general' => GeneralModule::class,
    ],
    'bootstrap' => [
        'checksIsConsoleRequest',
        'craft-twig-linter',
        'general',
    ],
];
