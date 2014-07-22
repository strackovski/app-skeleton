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

/**
 * Class SetupAbstract
 *
 * Provides a base class for concrete setup implementations
 *
 * @package nv\PROJECT_NAME
 */
abstract class SetupAbstract
{
    /** @var string Application name */
    protected $applicationName;

    /** @var string App root path */
    protected $dir;

    /** @var bool Whether to use a database for this project */
    protected $useDB;

    /**
     * Constructor
     *
     * @param string $applicationName The name of the project w/o vendor prefix
     */
    public function __construct($applicationName)
    {
        $this->applicationName = $applicationName;
        $this->dir = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/';
        $this->useDB = false;
    }

    /**
     * Custom application configuration
     *
     * Implement this function in concrete setup class to encapsulate the
     * specifics of project configuration.
     *
     * @return mixed
     */
    abstract public function configure();

    /**
     * Custom application verification
     *
     * Implement this function in concrete setup class to encapsulate the
     * specifics of project verification.
     *
     * @return mixed
     */
    abstract public function verify();

    /**
     * Prompt the user and return user's input
     *
     * @param string $message Prompt message
     * @return string
     */
    protected function promptUser($message)
    {
        print $message;
        $handle = fopen("php://stdin", "r");

        return trim(fgets($handle));
    }

    /**
     * Set a constant in front controller
     *
     * @param string $sourceFile The file to write
     * @param string $key        Constant name
     * @param        $value
     * @param string $value      Constant value
     */
    protected function setConstant($sourceFile, $key, $value)
    {
        if (!file_exists($this->dir . $sourceFile . ".php")) {
            trigger_error("Invalid constants file.");
        }
        $file = file_get_contents($this->dir . $sourceFile . ".php");
        $pattern = '/define\(\''.strtoupper($key).'\', \'.*\'\);/';
        if (preg_match($pattern, $file) !== 1) {
            trigger_error("Invalid parameter {$key}.");
        }
        $replacement = "define('".strtoupper($key)."', '{$value}');";
        file_put_contents(
            $this->dir . $sourceFile . ".php",
            trim(preg_replace($pattern, $replacement, $file)).PHP_EOL
        );
    }

    /**
     * Write changes to configuration files
     *
     * @param string $configFile The name of the configuration file
     * @param string $key        The configuration parameter name
     * @param string $value      The configuration parameter value
     * @param bool   $group      Multiple configuration array key name
     */
    protected function setConfigItem($configFile, $key, $value, $group = false)
    {
        if (!file_exists($this->dir . "config/{$configFile}.php")) {
            trigger_error("Invalid configuration file {$configFile}.");
        }

        $file = file_get_contents($this->dir . "config/{$configFile}.php");
        $fileKey = $configFile === 'database' ? 'db' : $configFile;
        $pattern = $group ?
            '/'.$fileKey.'\[\''.$group.'\'\]\[\''.$key.'\'\] = \'.*\';/' :
            '/'.$fileKey.'\[\''.$key.'\'\] = \'.*\';/';

        if (preg_match($pattern, $file) !== 1) {
            trigger_error("Invalid configuration parameter {$key}.");
        }

        $replacement = $group ?
            "{$fileKey}['{$group}']['{$key}'] = '{$value}';" :
            "{$fileKey}['{$key}'] = '{$value}';";

        $newConfig = preg_replace($pattern, $replacement, $file);
        file_put_contents($this->dir . "config/{$configFile}.php", trim($newConfig).PHP_EOL);
    }

    /**
     * Creates a Doctrine 2 ORM EntityManager instance
     *
     * @param array $databaseParameters Database connection parameters
     *
     * @return EntityManager
     */
    protected function createEntityManager(array $databaseParameters)
    {
        print "Configuring entity manager...";
        $connection_options = array(
            'driver'        => $databaseParameters['default']['dbdriver'],
            'user'          => $databaseParameters['default']['username'],
            'password'      => $databaseParameters['default']['password'],
            'host'          => $databaseParameters['default']['hostname'],
            'dbname'        => $databaseParameters['default']['database']
        );
        // @todo [fix] Verify that proxies_dir is set correctly !!!
        $proxies_dir      =  dirname(dirname(__FILE__)) . '/var/cache/orm/proxy';
        $metadata_paths   = array($this->dir.'/src/nv/'.$this->applicationName.'/Model/Entity');
        $config =
            \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($metadata_paths, false, $proxies_dir);

        print "OK\n";
        return \Doctrine\ORM\EntityManager::create($connection_options, $config);
    }

    /**
     * Verifies settings defined in config/database.php
     *
     * @return array Array of database connection parameters
     */
    protected function verifyDatabaseConfiguration()
    {
        if (!file_exists($this->dir . "config/database.php")) {
            trigger_error("Required configuration file database.php not found.");
        }

        require $this->dir . "config/database.php";
        if (isset($db) != false and is_array($db)) {
            // Check if db parameters are set
            if (!array_key_exists('default', $db)) {
                trigger_error("Invalid database configuration file.\n");
            }
            foreach (array('dbdriver', 'hostname', 'username', 'password', 'database') as $key) {
                if (!array_key_exists($key, $db['default'])) {
                    trigger_error("Invalid database configuration file.\n");
                }
            }
            print "OK\nTrying to connect to database...";

            // @todo [fix] Error-catching for each driver separately: mysqli throws exception, pg ...
            try {
                switch ($db['default']['dbdriver']) {
                    case 'mysqli':
                        if (class_exists('mysqli')) {
                            $connection = new \mysqli(
                                $db['default']['hostname'],
                                $db['default']['username'],
                                $db['default']['password'],
                                $db['default']['database']
                            );
                        }
                        break;
                    case 'postgresql':
                        if (function_exists("pg_connect")) {
                            $connection = pg_connect(
                                "host={$db['default']['hostname']} ".
                                "dbname={$db['default']['database']} ".
                                "user={$db['default']['username']} ".
                                "password={$db['default']['password']}"
                            )
                            or die("\nCan't connect to database ".pg_last_error());
                        }
                        break;
                    case 'mssql':
                        if (function_exists("mssql_connect")) {
                            $server = "{$db['default']['hostname']}{$db['default']['database']}";
                            $connection = mssql_connect(
                                $server,
                                $db['default']['username'],
                                $db['default']['password']
                            );
                            if (!$connection) {
                                die("\nSomething went wrong while connecting to MSSQL");
                            } else {
                                $selected = mssql_select_db(
                                    $db['default']['database'],
                                    $connection
                                )
                                or die("\nCant't open database {$db['default']['database']}");
                            }
                        }
                        break;
                }
                print "OK\n";
                return $db;
            } catch (\ErrorException $e) {
                trigger_error("Database connection failed: " . $e->getMessage());
            }
        }
        trigger_error(
            "Failed retrieving database connection parameters.\n".
            "Make sure parameters are set in config/database.php"
        );
        return 0;
    }

    /**
     * Ensures directory permissions are set correctly
     *
     * @return bool
     */
    protected function verifyDirectoryPermissions()
    {
        $dirs = array('var', 'var/logs', 'var/cache', 'web', 'web/assets');
        $error = 0;
        foreach ($dirs as $dir) {
            $d = $this->dir . $dir;
            if (!is_writable($d)) {
                print "ERROR: {$dir} not writable.\n";
                $error++;
            }
        }
        return $error > 0 ? false : true;
    }

    /**
     * Clean up after setup is complete
     */
    protected function cleanUp()
    {
        $dirs = array( $this->dir . 'temp');

        foreach ($dirs as $dir) {
            try {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::CHILD_FIRST
                );

                foreach ($files as $fileinfo) {
                    $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                    $todo($fileinfo->getRealPath());
                }
                rmdir($dir);
            } catch (\Exception $e) {
                print "Removal of temporary items failed: {$e->getMessage()}";
            }
        }

        return;
    }
}
