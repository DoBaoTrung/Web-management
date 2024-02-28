<?php
if (!defined('_INCODE')) die('Access denied...');

function getAllScores($filter = '')
{
    $sql = "SELECT * FROM scores $filter ORDER BY id DESC";
    $allScoresQuery = getAllRows($sql);
    return $allScoresQuery;
}

function getScoreByID($scoreId)
{
    $sql = "SELECT * FROM scores WHERE id=$scoreId";
    $scoreQuery = getFirstRow($sql);
    return $scoreQuery;
}

function insertScore($dataInsert)
{
    $lastInsertID = insert('scores', $dataInsert);
    return $lastInsertID;
}

function updateScore($dataUpdate, $scoreId)
{
    $condition = "id=$scoreId";
    $updateStatus = update('scores', $dataUpdate, $condition);
    return $updateStatus;
}

function searchScore($studentKW, $subjectKW, $teacherKW)
{
    $scoreData = array();
    $sql = "SELECT 
            scores.id as 'id', 
            students.name as 'student_name', 
            subjects.name as 'subject_name' , 
            teachers.name as 'teacher_name', 
            scores.score as 'score' 
            FROM scores, students, subjects, teachers 
            WHERE scores.student_id = students.id 
            and scores.subject_id = subjects.id 
            and scores.teacher_id = teachers.id 
            and students.name LIKE '%$studentKW%' 
            and subjects.name LIKE '%$subjectKW%' 
            and teachers.name LIKE '%$teacherKW%' 
            ORDER BY scores.id DESC";

    $statement = query($sql, array(), true);

    if (is_object($statement)) {
        $dataFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
        $numberOfRows = $statement->rowCount();

        $scoreData['dataFetch'] = $dataFetch;
        $scoreData['numberOfRows'] = $numberOfRows;
        return $scoreData;
    }
    return false;
}

function deleteScore($scoreId)
{
    $sql = "DELETE FROM scores WHERE scores.id = $scoreId";
    $deleteStatus = query($sql);
    return $deleteStatus;
}
