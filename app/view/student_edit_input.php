<?php
if (!defined('_INCODE')) die('Access denied...');
if (isset($_SESSION['errorArray'])) extract(getSession('errorArray'))
?>

<div class="container">
    <div class="content">
        <h3 class="text-center text-uppercase" style="margin-bottom: 50px; text-align: center;"> Sửa Thông Tin Sinh Viên </h3>
        <form action="" method="post" enctype="multipart/form-data" style="margin-right: 10%;">
            <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
                <div class="col">
                    <?php echo getFormMessage($msg, $msgType); ?>
                </div>
            </div>
            <!-- name field -->
            <div class="row mx-auto" style="width: 90%; margin: 50px auto;">
                <div class=" col-sm-4 text-center ">
                    <label> Họ và Tên </label>
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="name" value="<?php echo getOldFormData('name', $oldBodyArr); ?>" style="border: 1px solid #366fa5; width: 400px;">
                    <!-- Display error -->
                    <?php if (isset($errName)) echo  '<span class="error">' . $errName . '</span>' ?>
                </div>
            </div>

            <!-- Display old avatar field -->
            <div class="row mx-auto" style="width: 90%; margin: 20px auto;">
                <div class="col-sm-4 text-center">
                    <label> Avatar </label>
                </div>
                <div class="col-sm-8">
                    <!-- Display avatar -->
                    <div class="form-group">
                        <img style="width: 250px; height: 250px; border: none;" src="<?php echo getOldFormData('oldUploadPath', $oldBodyArr); ?>" alt="Ảnh đại diện" class="img-fluid img-thumbnail">
                    </div>
                </div>
            </div>

            <!-- Update avatar field -->
            <div class="row mx-auto" style="width: 90%; margin: 20px auto;">
                <div class="col-sm-4 text-center">
                </div>
                <div class="col-sm-8">
                    <!-- Browse file -->
                    <div class="custom-file form-group" style="width: 400px;">
                        <input type="file" class="custom-file-input" id="customFile" name="avatar">
                        <label style="border: 1px solid #366fa5;" class="custom-file-label" for="customFile"><?php echo getOldFormData('avatar', $oldBodyArr, "Chọn ảnh đại diện"); ?></label>
                    </div>
                    <!-- Display error -->
                    <?php if (isset($errAvatar)) echo  '<span class="error">' . $errAvatar . '</span>' ?>
                </div>
            </div>

            <!-- description field -->
            <div class="row mx-auto" style="width: 90%; margin: 20px auto;">
                <div class="col-sm-4 text-center">
                    <label> Mô tả thêm </label>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" name="description" style="border: 1px solid #366fa5; width: 400px;"><?php echo getOldFormData('description', $oldBodyArr); ?></textarea>
                    </div>
                    <!-- Display error -->
                    <?php if (isset($errDescription)) echo  '<span class="error">' . $errDescription . '</span>' ?>
                </div>
            </div>

            <input type="hidden" name="id" value="<?php echo getOldFormData('id', $oldBodyArr); ?>">
            <input type="hidden" name="oldUploadPath" value="<?php echo getOldFormData('oldUploadPath', $oldBodyArr); ?>">
            <input type="hidden" name="uploadPath" value="<?php echo getOldFormData('uploadPath', $oldBodyArr); ?>">

            <div class=" row mx-auto" style="width: 50%; margin: 20px auto;text-align: center;">
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary " style="width: 100px;"> Xác nhận </button>
                </div>
            </div>
        </form>
    </div>
</div>