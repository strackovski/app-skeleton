<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
*/
$config['base_url'] = '';
if(array_key_exists('HTTP_HOST', $_SERVER)){
    $config['base_url'] = "http://".$_SERVER['HTTP_HOST'];
    $config['base_url'] .= preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])).'/';
}

/*
|--------------------------------------------------------------------------
| Index File (leave empty if using mod_rewrite)
|--------------------------------------------------------------------------
*/
$config['index_page'] = '';

/*
|--------------------------------------------------------------------------
| General settings
|--------------------------------------------------------------------------
|
| * Database use
| * Use Doctrine ORM
|
*/
$config['enable_db'] = true;
$config['enable_orm'] = true;
$config['application_name'] = APPNAME;
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'NV_';

/*
|--------------------------------------------------------------------------
| Language settings
|--------------------------------------------------------------------------
*/
$config['multilingual_ui'] = true;
$config['language']	= 'english';
$config['charset'] = 'UTF-8';

/*
|--------------------------------------------------------------------------
| Controller settings
|--------------------------------------------------------------------------
|
| * Controller lookup paths (controllers_search_dir)
| * Controller class name suffix (controller_suffix)
|
*/
$config['controllers_search_dir'] = FCPATH . SRCPATH . 'Controllers/';
$config['controller_suffix'] = 'Controller';

/*
|--------------------------------------------------------------------------
| URI protocol
|--------------------------------------------------------------------------
|
| 'AUTO'			Default - auto detects
| 'PATH_INFO'		Uses the PATH_INFO
| 'QUERY_STRING'	Uses the QUERY_STRING
| 'REQUEST_URI'		Uses the REQUEST_URI
| 'ORIG_PATH_INFO'	Uses the ORIG_PATH_INFO
|
*/
$config['uri_protocol']	= 'AUTO';

/*
|--------------------------------------------------------------------------
| URL
|--------------------------------------------------------------------------
*/
$config['url_suffix'] = '';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = TRUE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd'; // Experimental, not currently in use
$config['log_threshold'] = 0;

/*
|--------------------------------------------------------------------------
| Error reporting by environment type
|--------------------------------------------------------------------------
*/
if (defined('ENVIRONMENT')){
    switch (ENVIRONMENT){
        case 'development':
            $config['log_threshold'] = 4;
            break;

        case 'testing':
            $config['log_threshold'] = 2;
            break;

        case 'production':
            $config['log_threshold'] = 0;
            break;
    }
}

/*
|--------------------------------------------------------------------------
| Logging and cacheing
|--------------------------------------------------------------------------
*/
$config['log_path'] = FCPATH.'var/logs/';
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['cache_path'] = FCPATH.'var/cache/';

/*
|--------------------------------------------------------------------------
| Session and cookie settings
|--------------------------------------------------------------------------
*/
$config['encryption_key'] = '@P{l4Ht&A9B0tR5P9nL/4vejto:093';
$config['sess_cookie_name']		= 'nv_session';
$config['sess_expiration']		= 7200;
$config['sess_expire_on_close']	= FALSE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= FALSE;
$config['sess_table_name']		= 'nv_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= 300;
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
$config['cookie_secure']	= TRUE;

/*
|--------------------------------------------------------------------------
| Security
|--------------------------------------------------------------------------
*/
$config['global_xss_filtering'] = TRUE;
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'nv_csrf_token';
$config['csrf_cookie_name'] = 'nv_csrf_cookie';
$config['csrf_expire'] = 7200;
