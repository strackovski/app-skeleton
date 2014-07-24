<?php

/**
 * This file belongs to PROJECT_NAME project
 *
 * @copyright 2014 Vladimir Stračkovski <vlado@nv3.org>
 * @license   The MIT License (MIT) <http://choosealicense.com/licenses/mit/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or visit the link above.
 */

namespace nv\PROJECT_NAME\Common;

use nv\PROJECT_NAME\Common\AccessorInterface;

/**
 * AccessorAbstract
 *
 * @package nv\worldly\Common
 * @author Vladimir Stračkovski <vlado@nv3.org>
 */
abstract class AccessorAbstract implements AccessorInterface
{
    /**
     * Get property
     *
     * @param $key string Name of property.
     *
     * @return string|null
     */
    public function getProperty($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
        return null;
    }

    /**
     * Set property
     *
     * @param $key string Name of property
     * @param $value string Value of property
     *
     * @return $this|null
     */
    public function setProperty($key, $value)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
            return $this;
        }
        return null;
    }
}
