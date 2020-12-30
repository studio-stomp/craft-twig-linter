<?php
declare(strict_types=1);

use tests\modules\general\GeneralModule;

return [
    'modules' => [
        'general' => GeneralModule::class,
    ],
    'bootstrap' => [
        'general',
    ],
];
