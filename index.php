<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

require_once 'config.php';
require_once 'app/common/connect.php';
require_once 'app/common/define.php';
require_once 'app/model/database.php';
require_once 'app/controller/common.php';


// Routes

$module = _MODULE_DEFAULT;
$action = _ACTION_DEFAULT;

if (!empty($_GET['module'])) {
    if (is_string($_GET['module'])) {
        $module = trim($_GET['module']);
    }
}

if (!empty($_GET['action'])) {
    if (is_string($_GET['action'])) {
        $action = trim($_GET['action']);
    }
}

$path = 'app/controller/' . $module . '_' . $action . '.php';

if (file_exists($path)) {
    require_once $path;
} else {
    require_once 'app/view/error_404.php';
}
