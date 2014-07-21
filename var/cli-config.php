<?php
/**
 * Doctrine CLI Configuration File
 *
 * This file enables Doctrine Command Line Tools
 */

define('APPPATH', dirname(__FILE__) . '/app/');
define('BASEPATH', dirname(__FILE__) . '/system/');
define('FCPATH', str_replace(pathinfo(__FILE__, PATHINFO_BASENAME), '', __FILE__));
define('SRCPATH', 'src/nv/PROJECT_NAME/');
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