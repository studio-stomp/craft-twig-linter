<?php
declare(strict_types=1);

/**
 * Craft Twig Linter plugin for Craft CMS 3.x
 *
 * A plugin for Craft CMS bringing sserbin/twig-linter to Craft CMS projects
 *
 * @link      https://studiostomp.nl
 * @copyright Copyright (c) 2020 Studio Stomp
 */

namespace studiostomp\crafttwiglinter;

use Craft;
use craft\base\Plugin;
use craft\console\Application as ConsoleApplication;

/**
 * @author    Studio Stomp
 * @package   CraftTwigLinter
 * @since     0.1.0
 *
 */
final class CraftTwigLinter extends Plugin
{
    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * CraftTwigLinter::$plugin
     *
     * @var CraftTwigLinter
     */
    public static CraftTwigLinter $plugin;

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '0.1.0';

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * CraftTwigLinter::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        // Add in our console commands
        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'studiostomp\crafttwiglinter\console\controllers';
        }

        Craft::info(
            Craft::t(
                'craft-twig-linter',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }
}
