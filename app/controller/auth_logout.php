<?php
if (!defined('_INCODE')) die('Access denied...');

// Destroy current session and redirect to login page
if (isLogin()) {
    destroySession();
    redirect('?module=auth&action=login');
}
