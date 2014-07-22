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
namespace nv\PROJECT_NAME\Setup;

use nv\PROJECT_NAME\Setup\SetupAbstract;

/**
 * Class ProjectSetup
 *
 * Enables project configuration from command line
 *
 * @package nv\PROJECT_NAME\Setup
 */
class ProjectSetup extends SetupAbstract
{
    /**
     * Configure project
     *
     * Specify basic configuration parameters
     */
    public function configure()
    {
        $this->setConstant('index', 'APPNAME', $this->applicationName);
        if ($this->verify() == false) {
            trigger_error("Verification failed\n");
        }
        print "Please provide the following configuration options: \n";

        $useDb = $this->promptUser("Does this application use a database? [Y/n]");
        if (strtolower($useDb) === 'y' or $useDb === '') {
            $this->useDB = true;
            $dbOptions = array('dbdriver', 'hostname', 'username', 'password', 'database');
            print "Please provide the following database server parameters: \n";
            foreach ($dbOptions as $parameter) {
                $value = $this->promptUser(ucfirst($parameter).": ");
                $this->setConfigItem('database', $parameter, $value, 'default');
            }
            print "Database configuration saved, verifying...";
            $dbParams = $this->verifyDatabaseConfiguration();
            $useOrm = $this->promptUser("Enable Doctrine ORM? [Y/n]");
            if (strtolower($useOrm) === 'y' or $useOrm === '') {
                $this->createEntityManager($dbParams);
            }
        }
        $this->cleanUp();
        return;
    }

    /**
     * Verify project configuration
     *
     * @return bool
     */
    public function verify()
    {
        if ($this->useDB) {
            if( ! $this->verifyDatabaseConfiguration()) {
                return false;
            }
        }

        if ( ! $this->verifyDirectoryPermissions()) {
            print "Fix the permission errors printed above.\n";
            return false;
        }

        return true;
    }
}
