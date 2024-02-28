<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Xóa giáo viên');
requireLayout('header.php', $data);

require_once 'app/model/teachers.php';


if (isGet()) {
    $bodyArr = getBody();
    $teacherSearchKW = getFlashData('teacherSearchKW');

    if (!empty($bodyArr['id'])) {
        $teacherId = $bodyArr['id'];
        $deleteStatus = deleteTeacher($teacherId);
        if ($deleteStatus) {
            redirect('?module=teacher&action=search&specialized=' . $teacherSearchKW['specialized'] . '&keyword=' . $teacherSearchKW['keyword']);
        } else {
            require_once 'app/view/error_db.php';
        }
    } else {
        redirect('?module=teacher&action=search');
    }
}

requireLayout('footer.php');
