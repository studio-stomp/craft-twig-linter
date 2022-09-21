<?php
declare(strict_types=1);

use tests\modules\general\ChecksIsConsoleRequestModule;
use tests\modules\general\GeneralModule;

return [
    'modules' => [
        'checksIsConsoleRequest' => ChecksIsConsoleRequestModule::class,
        'general' => GeneralModule::class,
    ],
    'bootstrap' => [
        'checksIsConsoleRequest',
        'general',
    ],
];
