<?php
if (!defined('_INCODE')) die('Access denied...');

// Define schoolYear array
define("_SCHOOL_YEARS", serialize(array(
    '1' => 'Năm 1',
    '2' => 'Năm 2',
    '3' => 'Năm 3',
    '4' => 'Năm 4'
)));

// Define specialized array
define("_SPECIALIZED", serialize(array(
    'MAT' => 'Toán-Tin',
    'PHY' => 'Vật lý',
    'BIO' => 'Sinh học',
    'FLF' => 'Tiếng Anh',
    'HIS' => 'Lịch sử',
    'GEO' => 'Địa lý'
)));

// Define degree array
define("_DEGREES", serialize(array(
    'BAC' => 'Cử nhân',
    'MAS' => 'Thạc sĩ',
    'DOC' => 'Tiến sĩ'
)));

// Define score array
define("_SCORES", serialize(array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)));
