<?php
/**
 * Doctrine CLI Configuration File
 */

define('APPPATH', dirname(dirname(__FILE__)) . '/vendor/nv/codeigniter/application/');
define('BASEPATH', dirname(dirname(__FILE__)) . '/vendor/nv/codeigniter/system/');
define('FCPATH', dirname(dirname(__FILE__)) . '/');
define('SRCPATH', dirname(dirname(__FILE__)) . '/src/');
define('ENVIRONMENT', 'development');

chdir(APPPATH);
require APPPATH . 'libraries/Doctrine.php';

foreach ($GLOBALS as $helperSetCandidate) {
    if ($helperSetCandidate instanceof Symfony\Component\Console\Helper\HelperSet) {
        $helperSet = $helperSetCandidate;
        break;
    }
}
$doctrine = new Doctrine;
$em = $doctrine->em;

$helperSet = new Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);