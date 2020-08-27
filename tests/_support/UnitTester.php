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

use Codeception\Actor;
use Codeception\Lib\Friend;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 *
 */
class UnitTester extends Actor
{
    use _generated\UnitTesterActions;

}
