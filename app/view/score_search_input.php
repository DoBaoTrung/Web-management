<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<form action="" method="get">
    <input type="hidden" name="module" value="score">
    <input type="hidden" name="action" value="search">

    <div class="row mx-auto" style="width: 29%; margin: 20px auto;">
        <div class=" col-sm-4 text-center">
            <label> Sinh viên </label>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="studentKW">
        </div>
    </div>
    <div class="row mx-auto" style="width: 29%; margin: 20px auto;">
        <div class=" col-sm-4 text-center">
            <label> Môn học </label>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="subjectKW">
        </div>
    </div>
    <div class="row mx-auto" style="width: 29%; margin: 20px auto;">
        <div class=" col-sm-4 text-center">
            <label> Giáo viên </label>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="teacherKW">
        </div>
    </div>
    <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
        <div class="col text-center">
            <button type="submit" class="btn btn-primary"> Tìm kiếm </button>
        </div>
    </div>
</form>