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
namespace nv\PROJECT_NAME\Model;

/**
 * Class TimestampableInterface
 * @package nv\PROJECT_NAME\Model
 */
interface TimestampableInterface
{
    /**
     * Returns the time the record was last modified.
     *
     * @return \DateTime
     */
    public function getTimeModified();

    /**
     * Sets the time the record was last modified
     *
     * @return mixed
     */
    public function setTimeModified();

    /**
     * Gets the time the record was created
     *
     * @return \DateTime
     */
    public function getTimeCreated();

    /**
     * Sets the time the record was created
     *
     * @return mixed
     */
    public function setTimeCreated();
}
