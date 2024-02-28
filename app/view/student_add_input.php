<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <h3 class="text-center text-uppercase" style="margin-bottom: 50px;"> Đăng ký sinh viên </h3>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col">
                <?php echo getFormMessage($msg, $msgType); ?>
            </div>
        </div>

        <!-- name field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Họ và tên </label>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="name" value="<?php echo getOldFormData('name', $oldBodyArr); ?>">
                <!-- Display error -->
                <?php echo getFormError('name', $errorArr); ?>
            </div>
        </div>

        <!-- description field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Mô tả chi tiết </label>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <textarea class="form-control" rows="5" name="description"><?php echo getOldFormData('description', $oldBodyArr); ?></textarea>
                </div>
                <!-- Display error -->
                <?php echo getFormError('description', $errorArr); ?>
            </div>
        </div>

        <!-- avatar field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Avatar </label>
            </div>
            <div class="col-sm-8">
                <div class="custom-file form-group">
                    <input type="file" class="custom-file-input" id="customFile" name="avatar">
                    <label class="custom-file-label" for="customFile"><?php echo getOldFormData('avatar', $oldBodyArr, "Chọn ảnh đại diện"); ?></label>
                </div>
                <!-- Display error -->
                <?php echo getFormError('avatar', $errorArr); ?>
            </div>
        </div>

        <div class=" row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary "> Xác nhận </button>
            </div>
        </div>
    </form>

</div>