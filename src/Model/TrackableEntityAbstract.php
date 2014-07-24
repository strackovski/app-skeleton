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
 * Class TrackableEntityAbstract (Entity Superclass)
 *
 * @MappedSuperclass
 *
 * Extend this class in concrete entity classes to get access to timestampable
 * and authorable capabilities. Timestampable records the date/time of item
 * creation and modification, Authorable records the author of the item.
 *
 * @package nv\PROJECT_NAME\Model
 * @author  Vladimir Stračkovski <vlado@nv3.org>
 */
abstract class TrackableEntityAbstract implements TimestampableInterface, AuthorableInterface
{
    /** @var \DateTime Time record was created */
    protected $timeCreated;

    /** @var \DateTime Time record was modified */
    protected $timeModified;

    /** @var mixed Author of the record */
    protected $author;

    /**
     * Get time modified
     *
     * @return \DateTime
     */
    public function getTimeModified()
    {

    }

    /**
     * Set time modified
     */
    public function setTimeModified()
    {

    }

    /**
     * Get time created
     *
     * @return \DateTime
     */
    public function getTimeCreated()
    {

    }

    /**
     * Set time created
     *
     * @return \DateTime
     */
    public function setTimeCreated()
    {

    }

    /**
     * Get author
     */
    public function getAuthor()
    {

    }

    /**
     * Set author
     */
    public function setAuthor()
    {

    }
}
