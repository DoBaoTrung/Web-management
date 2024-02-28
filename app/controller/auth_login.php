<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Đăng nhập');
requireLayout('header_login.php', $data);

require_once 'app/model/admins.php';

// Check if user is logged in
if (isLogin()) {
    redirect('?module=home&action=dashboard');
}

// Handle Login
if (isPost()) {
    $bodyArr = getBody();

    $errorArr = array();

    // Validate login_id
    if (empty(trim($bodyArr['login_id']))) {
        $errorArr['login_id']['required'] = "Hãy nhập login_id!";
    } else {
        if (strlen($bodyArr['login_id']) < 4) {
            $errorArr['login_id']['minlength'] = "Hãy nhập login_id tối thiểu 4 ký tự!";
        }
    }

    // Validate password
    if (empty($bodyArr['password'])) {
        $errorArr['password']['required'] = "Hãy nhập password!";
    } else {
        if (strlen($bodyArr['password']) < 6) {
            $errorArr['password']['minlength'] = "Hãy nhập password tối thiểu 6 ký tự!";
        }
    }


    if (empty($errorArr)) {
        $loginId = $bodyArr['login_id'];
        $password = $bodyArr['password'];

        $adminQuery = existAdmin($loginId);

        if (!empty($adminQuery)) {
            $hashPassword = $adminQuery['password'];

            if (password_verify($password, $hashPassword)) {
                $loginToken = sha1(uniqid() . time());
                // Save admin info in $_SESSION
                setSession('login_id', $loginId);
                setSession('login_time', date('Y-m-d H:i'));
                redirect('?module=home&action=dashboard');
            }
        }
        setFlashData('msg', 'login_id và password không đúng!');
        setFlashData('msg_type', 'danger');
    }
    setFlashData('errorArr', $errorArr);
    setFlashData('oldBodyArr', $bodyArr);

    redirect('?module=auth&action=login');
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errorArr = getFlashData('errorArr');
$oldBodyArr = getFlashData('oldBodyArr');

require_once 'app/view/auth_login_input.php';


requireLayout('footer_login.php');
