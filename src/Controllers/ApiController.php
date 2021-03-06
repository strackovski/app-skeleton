<?php
/**
 * This file belongs to PROJECT_NAME
 *
 * @copyright 2014 Vladimir Stračkovski
 * @license   The MIT License (MIT) <http://choosealicense.com/licenses/mit/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or visit the link above.
 */
namespace nv\PROJECT_NAME\Controllers;

require LIBPATH . 'REST_Controller.php';

/**
 * API Controller
 *
 * Extends the REST Controller class providing a clean interface for
 * creating a RESTful API service.
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Uri $uri
 * @property NV_Lang $lang
 * @property \Doctrine\ORM\EntityManager $em
 *
 * @author Vladimir Stračkovski <vlado@nv3.org>
 */
class ApiController extends REST_Controller
{
    /**
     * GET Item
     */
    public function itemGet()
    {


    }

    /**
     * GET Items
     */
    public function itemsGet()
    {

    }
}
