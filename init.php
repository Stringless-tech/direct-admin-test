<?php
require_once 'vendor/autoload.php';
ini_set('display_errors',true);
ini_set('error_reporting',E_ALL & ~E_NOTICE);
ini_set('max_execution_time', 300);
define('INSTALL_DIR', __DIR__);
function my_autoloader($class) {
    include 'classes/' . $class . '.php';
}
spl_autoload_register(function($class){ include 'classes/' . $class . '.php'; });
require 'lib.php';
set_error_handler(function($errno,$errstr,$errfile,$errline,$errcontext){
        echo H('Error: ' .$errstr);
        echo '<br>--<br>';
        debug_render_html_backtrace();
        echo '<br>--<br>';
        die('stop on error.');
});
set_exception_handler(function(Throwable $E)
{
        echo get_class($E).': ' .H($E->getMessage()) .'<br/>';
        echo '<br>--<br>';
        debug_render_html_exception_backtrace($E);
        echo '<br>--<br>';
        die('stop on exception');
});

$validator = new Validator();
$user = new User($validator);