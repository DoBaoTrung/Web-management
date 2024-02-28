<?php
if (!defined('_INCODE')) die('Access denied...');

/**
 * This function executes a query with $data or none
 */
function query($sql, $data = array(), $statementStatus = false)
{
    global $connect;
    $query = false;
    try {
        $statement = $connect->prepare($sql);
        if (empty($data)) {
            $query = $statement->execute();
        } else {
            $query = $statement->execute($data);
        }
    } catch (Exception $exception) {
        require_once 'app/view/error_db.php';
        die();
    }

    if ($statementStatus) {
        return $statement;
    }

    return $query;
}


/**
 * This function gets all matched rows (returns two-dimensional array)
 */
function getAllRows($sql)
{
    $statement = query($sql, array(), true);
    if (is_object($statement)) {
        $dataFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $dataFetch;
    }
    return false;
}

/**
 * This function gets the first matched row (returns one-dimensional array)
 */
function getFirstRow($sql)
{
    $statement = query($sql, array(), true);
    if (is_object($statement)) {
        $dataFetch = $statement->fetch(PDO::FETCH_ASSOC);
        return $dataFetch;
    }
    return false;
}

/**
 * This function gets the number of rows affected by the last SQL statement
 */
function getNumberOfRows($sql)
{
    $statement = query($sql, array(), true);
    if (is_object($statement)) {
        return $statement->rowCount();
    }
    return false;
}

/**
 * This function inserts a new row and returns the ID of the last inserted row
 */
function insert($table, $dataInsert)
{
    global $connect;
    $keyArr = array_keys($dataInsert);
    $fieldStr = implode(', ', $keyArr);
    $valueStr = ':' . implode(', :', $keyArr);

    $sql = "INSERT INTO $table($fieldStr) VALUES ($valueStr)";
    query($sql, $dataInsert);
    return $connect->lastInsertId();
}

/**
 * This function updates data in a table, allows to change the values in one or more columns of a single row or multiple rows
 */
function update($table, $dataUpdate, $condition = '')
{
    $updateStr = '';
    foreach ($dataUpdate as $key => $value) {
        $updateStr .= $key . '=:' . $key . ', ';
    }
    $updateStr = rtrim($updateStr, ', ');
    if (!empty($condition)) {
        $sql = "UPDATE $table SET $updateStr WHERE $condition";
    } else {
        $sql = "UPDATE $table SET $updateStr";
    }
    return query($sql, $dataUpdate);
}

/**
 * This function delete existing records in a table
 */
function delete($table, $condition = '')
{
    if (!empty($condition)) {
        $sql = "DELETE FROM $table WHERE $condition";
    } else {
        $sql = "DELETE FROM $table";
    }
    return query($sql);
}
