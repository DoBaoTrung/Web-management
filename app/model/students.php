<?php
if (!defined('_INCODE')) die('Access denied...');

function getAllStudents($filter = '')
{
    $sql = "SELECT * FROM students $filter ORDER BY id DESC";
    $allStudentsQuery = getAllRows($sql);
    return $allStudentsQuery;
}

function filterByStudentKW($keyword, $filter)
{
    if (!empty($filter) && strpos($filter, 'WHERE') !== false) {
        $operator = 'AND';
    } else {
        $operator = 'WHERE';
    }
    $filter .= " $operator name LIKE '%$keyword%' OR description LIKE '%$keyword%'";
    return $filter;
}

function getStudentByID($studentId)
{
    $sql = "SELECT * FROM students WHERE id=$studentId";
    $studentQuery = getFirstRow($sql);
    return $studentQuery;
}

function insertStudent($dataInsert)
{
    $lastInsertID = insert('students', $dataInsert);
    return $lastInsertID;
}

function updateStudent($dataUpdate, $studentId)
{
    $condition = "id=$studentId";
    $updateStatus = update('students', $dataUpdate, $condition);
    return $updateStatus;
}

function deleteStudent($studentId)
{
    $sql = "DELETE FROM students WHERE id=$studentId";
    $deleteStatus = query($sql);
    return $deleteStatus;
}
