<?php

/**
 * This file belongs to PROJECT_NAME project
 *
 * @copyright 2014 Vladimir Stračkovski <vlado@nv3.org>
 * @license   The MIT License (MIT) <http://choosealicense.com/licenses/mit/>
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code or visit the link above.
 */

namespace nv\PROJECT_NAME\Common;

/**
 * Interface AccessorInterface
 *
 * Provides generic access methods to objects
 *
 * @package nv\PROJECT_NAME\Common
 * @author Vladimir Stračkovski <vlado@nv3.org>
 */
interface AccessorInterface{

    /**
     * Get instance property by column name (key)
     *
     * @param $key string Column name
     *
     * @return mixed
     */
    public function getProperty($key);

    /**
     * Set instance property by column name (key)
     *
     * @param $key string Column name
     * @param $value string|array Property value
     *
     * @return mixed
     */
    public function setProperty($key, $value);

}