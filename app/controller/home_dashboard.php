<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Trang chủ');
requireLayout('header.php', $data);

// Reset session (save login_id and login_time)
$loginId = getSession('login_id');
$loginTime = getSession('login_time');
unsetSession();
setSession('login_id', $loginId);
setSession('login_time', $loginTime);


require_once 'app/view/home_dashboard_view.php';

requireLayout('footer.php');
