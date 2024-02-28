<?php
if (!defined('_INCODE')) die('Access denied...');

function filterBySchoolYear($schoolYear, $filter)
{
    if (!empty($filter) && strpos($filter, 'WHERE') !== false) {
        $operator = 'AND';
    } else {
        $operator = 'WHERE';
    }
    $filter .= " $operator school_year='$schoolYear'";
    return $filter;
}

function filterBySubjectKW($keyword, $filter)
{
    if (!empty($filter) && strpos($filter, 'WHERE') !== false) {
        $operator = 'AND';
    } else {
        $operator = 'WHERE';
    }
    $filter .= " $operator name LIKE '%$keyword%' OR description LIKE '%$keyword%'";
    return $filter;
}

function getAllSubjects($filter = '')
{
    $sql = "SELECT * FROM subjects $filter ORDER BY id DESC";
    $allSubjectsQuery = getAllRows($sql);
    return $allSubjectsQuery;
}

function getSubjectByID($subjectId)
{
    $sql = "SELECT * FROM subjects WHERE id=$subjectId";
    $subjectQuery = getFirstRow($sql);
    return $subjectQuery;
}

function insertSubject($dataInsert)
{
    $lastInsertID = insert('subjects', $dataInsert);
    return $lastInsertID;
}

function updateSubject($dataUpdate, $subjectId)
{
    $condition = "id=$subjectId";
    $updateStatus = update('subjects', $dataUpdate, $condition);
    return $updateStatus;
}

function deleteSubject($subjectId)
{
    $condition = "id=$subjectId";
    $deleteStatus = delete('subjects', $condition);
    return $deleteStatus;
}
