<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <form action="" method="get">
        <input type="hidden" name="module" value="subject">
        <input type="hidden" name="action" value="search">

        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Khóa học </label>
            </div>
            <div class="col-sm-8">
                <select class="form-control" name="school_year">
                    <option value=""> --Chọn khóa học-- </option>
                    <?php
                    if (defined('_SCHOOL_YEARS')) {
                        foreach (_SCHOOL_YEARS as $key => $value) {
                            echo '<option value="' . $key  . '"> ' . $value . ' </option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Từ khóa </label>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="keyword">
            </div>
        </div>
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary "> Tìm kiếm </button>
            </div>
        </div>
    </form>

</div>