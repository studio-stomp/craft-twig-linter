<?php
declare(strict_types=1);

use craft\test\TestSetup;

ini_set('date.timezone', 'UTC');

// Use the current installation of Craft
define('CRAFT_TESTS_PATH', __DIR__);
define('CRAFT_STORAGE_PATH', __DIR__ . '/_craft/storage');
define('CRAFT_TEMPLATES_PATH', __DIR__ . '/_craft/templates');
define('CRAFT_CONFIG_PATH', __DIR__ . '/_craft/config');
define('CRAFT_MIGRATIONS_PATH', __DIR__ . '/_craft/migrations');
define('CRAFT_TRANSLATIONS_PATH', __DIR__ . '/_craft/translations');
define('CRAFT_VENDOR_PATH', dirname(__DIR__) . '/vendor');

TestSetup::configureCraft();

// If @webroot does not get set, and it seems it doesn't get set by any of the
// Craft CMS testing bootstrapping, then it resolves to current directory,
// which in turn means for instance the `cpresources` directory gets created in
// the project root as testing is usually started in the project root.
// Define a hard location for webroot for all functional tests.
Craft::setAlias('@webroot', CRAFT_TESTS_PATH . DIRECTORY_SEPARATOR . '_output' . DIRECTORY_SEPARATOR . 'web');
