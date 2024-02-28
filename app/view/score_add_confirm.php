<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <h3 class="text-center text-uppercase" style="margin-bottom: 50px;"> Nhập điểm </h3>

    <form action="" method="post" enctype="multipart/form-data">

        <!-- Student field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Sinh viên </label>
            </div>
            <div class="col-sm-8">
                <input readonly type="text" class="form-control" name="specialized" value="<?php echo getOldFormData('student_name', $scoreAddData); ?>">
            </div>
        </div>

        <!-- Subject field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Môn học </label>
            </div>
            <div class="col-sm-8">
                <input readonly type="text" class="form-control" name="specialized" value="<?php echo getOldFormData('subject_name', $scoreAddData); ?>">
            </div>
        </div>

        <!-- Teacher field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Giáo viên </label>
            </div>
            <div class="col-sm-8">
                <input readonly type="text" class="form-control" name="specialized" value="<?php echo getOldFormData('teacher_name', $scoreAddData); ?>">
            </div>
        </div>

        <!-- Score field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Điểm </label>
            </div>
            <div class="col-sm-4">
                <input readonly type="text" class="form-control" name="degree" value="<?php echo getOldFormData('score', $scoreAddData); ?>">
            </div>
        </div>

        <!-- description field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Nhận xét chi tiết </label>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <textarea readonly class="form-control" rows="5" name="description"><?php echo getOldFormData('description', $scoreAddData); ?></textarea>
                </div>
            </div>
        </div>

    </form>

    <div class=" row mx-auto text-center" style="width: 50%; margin: 20px auto;">
        <div class="col-sm-6">
            <a href="?module=score&action=add" class="btn btn-primary"> Sửa lại </a>
        </div>
        <div class="col-sm-6">
            <a href="<?php echo '?module=score&action=add&screen=complete&token=' . $scoreAddData['token']; ?>" class="btn btn-primary"> Nhập điểm </a>
        </div>
    </div>

</div>