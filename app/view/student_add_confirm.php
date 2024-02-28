<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <h3 class="text-center text-uppercase" style="margin-bottom: 50px;"> Đăng ký sinh viên </h3>

    <form action="" method="post" enctype="multipart/form-data">
        <!-- name field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Họ và tên </label>
            </div>
            <div class="col-sm-8">
                <input readonly type="text" class="form-control" name="name" value="<?php echo getOldFormData('name', $studentAddData); ?>">
            </div>
        </div>

        <!-- description field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Mô tả chi tiết </label>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <textarea readonly class="form-control" rows="5" name="description"><?php echo getOldFormData('description', $studentAddData); ?></textarea>
                </div>
            </div>
        </div>

        <!-- avatar field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Avatar </label>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <img src="<?php echo getOldFormData('uploadPath', $studentAddData); ?>" alt="Ảnh đại diện" class="img-fluid img-thumbnail">
                </div>
            </div>
        </div>
    </form>

    <div class=" row mx-auto text-center" style="width: 50%; margin: 20px auto;">
        <div class="col-sm-6">
            <a href="?module=student&action=add" class="btn btn-primary"> Sửa lại </a>
        </div>
        <div class="col-sm-6">
            <a href="<?php echo '?module=student&action=add&screen=complete&token=' . $studentAddData['token']; ?>" class="btn btn-primary"> Đăng ký </a>
        </div>
    </div>
</div>