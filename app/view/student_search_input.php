<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <form action="" method="get">
        <input type="hidden" name="module" value="student">
        <input type="hidden" name="action" value="search">

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