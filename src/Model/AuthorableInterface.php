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
 * Class AuthorableInterface
 * @package nv\PROJECT_NAME\Model
 */
interface AuthorableInterface
{
    /**
     * Get author of the record
     *
     * @return mixed
     */
    public function getAuthor();

    /**
     * Set author of the record
     *
     * @return mixed
     */
    public function setAuthor();
}
