<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Tìm kiếm sinh viên');
requireLayout('header.php', $data);

require_once 'app/model/students.php';

// Filter data
$filter = '';
if (isGet()) {
    $bodyArr = getBody();


    if (!isset($bodyArr['keyword'])) {
        require_once 'app/view/student_search_input.php';
    } else {
        setFlashData('studentKW', $bodyArr['keyword']);

        if (!empty($bodyArr['keyword'])) {
            $keyword = $bodyArr['keyword'];
            $filter = filterByStudentKW($keyword, $filter);
        }

        $allStudentsQuery = getAllStudents($filter);
        if (is_array($allStudentsQuery)) {
            $numberOfRows = count($allStudentsQuery);
        } else {
            $numberOfRows = 0;
        }
        require_once 'app/view/student_search_view.php';
    }
}

requireLayout('footer.php');
