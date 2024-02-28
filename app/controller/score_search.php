<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Tìm kiếm điểm');
requireLayout('header.php', $data);

require_once 'app/model/scores.php';

$bodyArr = getBody(); // Lấy dữ liệu từ $_GET an toàn

if (isGet()) {
    if (!isset($bodyArr['studentKW']) && !isset($bodyArr['subjectKW']) && !isset($bodyArr['teacherKW'])) {
        require_once 'app/view/score_search_input.php';
    } else {
        $studentKW = $bodyArr['studentKW'];
        $subjectKW = $bodyArr['subjectKW'];
        $teacherKW = $bodyArr['teacherKW'];

        $scoreSearchKW = array(
            'studentKW' => $studentKW,
            'subjectKW' => $subjectKW,
            'teacherKW' => $teacherKW
        );
        setFlashData('scoreSearchKW', $scoreSearchKW);

        $scoreData = searchScore($studentKW, $subjectKW, $teacherKW);
        if (!empty($scoreData)) {
            $dataFetch = $scoreData['dataFetch'];
            $numberOfRows = $scoreData['numberOfRows'];
        }
        require_once 'app/view/score_search_view.php';
    }
}

requireLayout('footer.php');
