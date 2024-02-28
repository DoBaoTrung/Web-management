<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Tìm kiếm giáo viên');
requireLayout('header.php', $data);

require_once 'app/model/teachers.php';

// Filter data
$filter = '';
if (isGet()) {
    $bodyArr = getBody();

    if (!empty($bodyArr['specialized'])) {
        $specialized = $bodyArr['specialized'];
        $filter = filterBySpecialized($specialized, $filter);
    }

    if (!empty($bodyArr['keyword'])) {
        $keyword = $bodyArr['keyword'];
        $filter = filterByTeacherKW($keyword, $filter);
    }

    $allTeachersQuery = getAllTeachers($filter);
    $numberOfTeachers = getNumberOfTeachers($filter);
    require_once 'app/view/teacher_search_view.php';
}

requireLayout('footer.php');
