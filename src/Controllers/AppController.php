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

/**
 * Main Application Controller
 *
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Uri $uri
 * @property MY_Lang $lang
 * @property CI_Session $session
 * @property \Doctrine\ORM\EntityManager $em
 * @property Doctrine $doctrine
 * @property Twig $twig
 *
 * @author Vladimir Stračkovski <vlado@nv3.org>
 */
class AppController extends NV_Controller
{
    /** @var array Response data */
    private $data = array();

    /**
     * Index for this controller
     */
    public function index()
    {
        $data['lang'] = $this->lang->lang();
        try {
            $this->twig->display('master.html.twig', $data);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            show_error($e->getMessage(), 500);
        }
    }

    /**
     * Render static pages
     *
     * @param bool $name Page name
     */
    public function page($name = false)
    {
        if (! $name) {
            $this->index();
        }

        try {
            $data = $this->get_content('page', $name);
        } catch (Exception $e) {
            $data['errors'] = $e->getMessage();
        }

        $data['lang'] = $this->lang->lang();
        $this->twig->display('page.html.twig', $data);
    }
}
