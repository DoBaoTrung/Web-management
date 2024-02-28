<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Xóa điểm');
requireLayout('header.php', $data);

require_once 'app/model/scores.php';

$bodyArr = getBody();

if (isset($bodyArr['id'])) {
    $scoreId = $bodyArr['id'];
    $deleteStatus = deleteScore($scoreId);

    if ($deleteStatus) {
        $scoreSearchKW = getFlashData('scoreSearchKW');
        $location = '?module=score&action=search&studentKW=' . $scoreSearchKW['studentKW'] . '&subjectKW=' . $scoreSearchKW['subjectKW'] . '&teacherKW=' . $scoreSearchKW['teacherKW'];
        redirect($location);
    } else {
        require_once 'app/view/error_db.php';
    }
} else {
    redirect('?module=score&action=search');
}

requireLayout('footer.php');
