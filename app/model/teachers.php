<?php
if (!defined('_INCODE')) die('Access denied...');

// Lọc dữ liệu theo chuyên ngành
function filterBySpecialized($specialized, $filter)
{
    if (!empty($filter) && strpos($filter, 'WHERE') !== false) {
        $operator = 'AND';
    } else {
        $operator = 'WHERE';
    }
    $filter .= " $operator specialized='$specialized'";
    return $filter;
}

// Lọc dữ liệu theo từ khóa
function filterByTeacherKW($keyword, $filter)
{
    if (!empty($filter) && strpos($filter, 'WHERE') !== false) {
        $operator = 'AND';
    } else {
        $operator = 'WHERE';
    }
    $filter .= " $operator name LIKE '%$keyword%' OR description LIKE '%$keyword%' OR degree LIKE '%$keyword%'";
    return $filter;
}

// Lấy tất cả giáo viên theo bộ lọc
function getAllTeachers($filter = '')
{
    $sql = "SELECT * FROM teachers $filter ORDER BY id DESC";
    $allTeachersQuery = getAllRows($sql);
    return $allTeachersQuery;
}

// Số lượng giáo viên tìm thấy theo bộ lọc
function getNumberOfTeachers($filter)
{
    $sql = "SELECT * FROM teachers $filter";
    $numberOfTeachers = getNumberOfRows($sql);
    return $numberOfTeachers;
}

// Lấy thông tin một giáo viên theo Id
function getTeacherByID($teacherId)
{
    $sql = "SELECT * FROM teachers WHERE id=$teacherId";
    $teacherQuery = getFirstRow($sql);
    return $teacherQuery;
}

// Thêm giáo viên vào db
function insertTeacher($dataInsert)
{
    $lastInsertID = insert('teachers', $dataInsert);
    return $lastInsertID;
}

// Cập nhật giáo viên
function updateTeacher($dataUpdate, $teacherId)
{
    $condition = "id=$teacherId";
    $updateStatus = update('teachers', $dataUpdate, $condition);
    return $updateStatus;
}

// Xóa một giáo viên theo Id
function deleteTeacher($teacherId)
{
    $sql = "DELETE FROM teachers WHERE id=$teacherId";
    $deleteStatus = query($sql);
    return $deleteStatus;
}
