<?php
declare(strict_types=1);

use craft\helpers\App;

return [
    'dsn' => 'mysql:host=craft_twig_linter_test_db;port=3306;dbname=craft-twig-linter_testing',
    'user' => 'homestead',
    'password' => 'secret',
    'schema' => '',
    'tablePrefix' => '',
    'charset' => App::env('DB_CHARSET') ?? 'utf8',
    'collation' => App::env('DB_COLLATION'),
];
