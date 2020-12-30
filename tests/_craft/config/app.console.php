<?php
declare(strict_types=1);

use tests\modules\console\ConsoleModule;

return [
    'modules' => [
        'console' => ConsoleModule::class,
    ],
    'bootstrap' => [
        'console',
    ],
];
