<?php
/**
 * This file belongs to PROJECT_NAME project
 *
 * @copyright Copyright (c) 2014 Vladimir Stračkovski <vlado@nv3.org>
 * @license   The MIT License (MIT) <http://choosealicense.com/licenses/mit/>
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code or visit the link above.
 */
namespace nv\PROJECT_NAME\Setup;

require 'vendor/autoload.php';

/**
 * Class SetupRunner
 *
 * @author Vladimir Stračkovski <vlado@nv3.org>
 */
final class SetupRunner
{
    /**
     * Run project setup scripts
     *
     * @param \Composer\Script\Event $event Composer post-install event
     * @return bool|int
     */
    public static function run(\Composer\Script\Event $event)
    {
        $composer = $event->getComposer();
        $package = explode('/', $composer->getPackage()->getName());
        if (count($package) !== 2) {
            return trigger_error(
                'Mis-configured package name: the name should be in '.
                'vendor/package format. Correct this in composer.json and try again.'
            );
        }
        $appSetup = "nv\\{$package[1]}\\Setup\\ProjectSetup";
        $setup = new $appSetup($package[1]);
        if (is_object($setup) and method_exists($setup, 'configure')) {
            return $setup->configure();
        }
        return trigger_error("Can't find Setup in {$appSetup}");
    }
}
