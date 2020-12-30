<?php
declare(strict_types=1);

use tests\modules\web\WebModule;

return [
    'modules' => [
        'web' => WebModule::class,
    ],
    'bootstrap' => [
        'web',
    ],
];
