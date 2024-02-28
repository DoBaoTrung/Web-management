<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Xóa môn học');
requireLayout('header.php', $data);

require_once 'app/model/subjects.php';


if (isGet()) {
    $bodyArr = getBody();
    $subjectSearchKW = getFlashData('subjectSearchKW');

    if (!empty($bodyArr['id'])) {
        $subjectId = $bodyArr['id'];
        $deleteStatus = deleteSubject($subjectId);
        if ($deleteStatus) {
            redirect('?module=subject&action=search&school_year=' . $subjectSearchKW['school_year'] . '&keyword=' . $subjectSearchKW['keyword']);
        } else {
            require_once 'app/view/error_db.php';
        }
    } else {
        redirect('?module=subject&action=search');
    }
}

requireLayout('footer.php');
