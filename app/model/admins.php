<?php
if (!defined('_INCODE')) die('Access denied...');

function existAdmin($loginId)
{
    $sql = "SELECT password FROM admins WHERE login_id='$loginId'";
    $adminQuery = getFirstRow($sql);
    return $adminQuery;
}
