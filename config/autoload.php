<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Define which CI libraries to autoload
|--------------------------------------------------------------------------
*/
$autoload['packages']   = array();
$autoload['libraries']  = array('database', 'form_validation', 'twig', 'doctrine');
$autoload['helper']     = array('url', 'file', 'language');
$autoload['config']     = array();
$autoload['language']   = array();
$autoload['model']      = array();