<?php
// Default module and default action
const _MODULE_DEFAULT = 'auth';
const _ACTION_DEFAULT = 'login';

// Prevent direct access to a php file
const _INCODE = true;

// Define web root url
define('_WEB_HOST_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/final-project');

define('_WEB_HOST_TEMPLATE', _WEB_HOST_ROOT . '/web');

// The absolute path
define('_WEB_PATH_ROOT', __DIR__);

// Setting MySQL database parameters for PDO connection
const _HOST = 'localhost';
const _USER = 'root';
const _PASS = '';
const _DB = 'final_project';
const _DRIVER = 'mysql';
