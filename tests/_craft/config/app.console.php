<?php
declare(strict_types=1);

use studiostomp\crafttwiglinter\CraftTwigLinter;
use tests\modules\console\ConsoleModule;

return [
    'modules' => [
        'console' => ConsoleModule::class,
        'craft-twig-linter' => CraftTwigLinter::class,
    ],
    'bootstrap' => [
        'console',
        'craft-twig-linter',
    ],
];
