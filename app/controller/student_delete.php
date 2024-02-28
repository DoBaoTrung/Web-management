<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Xóa sinh viên');
requireLayout('header.php', $data);

require_once 'app/model/students.php';


if (isGet()) {
    $bodyArr = getBody();
    $studentKW = getFlashData('studentKW');
    if (!empty($bodyArr['id'])) {
        $studentId = $bodyArr['id'];
        $deleteStatus = deleteStudent($studentId);
        if ($deleteStatus) {
            redirect('?module=student&action=search&keyword=' . $studentKW);
        } else {
            require_once 'app/view/error_db.php';
        }
    } else {
        redirect('?module=student&action=search');
    }
}

requireLayout('footer.php');
