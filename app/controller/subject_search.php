<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Tìm kiếm môn học');
requireLayout('header.php', $data);

require_once 'app/model/subjects.php';

// Filter data
$filter = '';
if (isGet()) {
    $bodyArr = getBody();

    if (!isset($bodyArr['school_year']) && !isset($bodyArr['keyword'])) {
        require_once 'app/view/subject_search_input.php';
    } else {
        setFlashData('subjectSearchKW', $bodyArr);
        if (!empty($bodyArr['school_year'])) {
            $schoolYear = $bodyArr['school_year'];
            $filter = filterBySchoolYear($schoolYear, $filter);
        }

        if (!empty($bodyArr['keyword'])) {
            $keyword = $bodyArr['keyword'];
            $filter = filterBySubjectKW($keyword, $filter);
        }

        $allSubjectsQuery = getAllSubjects($filter);

        if (is_array($allSubjectsQuery)) {
            $numberOfRows = count($allSubjectsQuery);
        } else {
            $numberOfRows = 0;
        }

        require_once 'app/view/subject_search_view.php';
    }
}

requireLayout('footer.php');
