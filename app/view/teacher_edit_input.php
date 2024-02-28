<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <h3 class="text-center text-uppercase" style="margin-bottom: 50px;"> Sửa giáo viên </h3>

    <form action="" method="post" enctype="multipart/form-data">
        <!-- Display message -->
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
        <!-- specialized field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Chuyên ngành </label>
            </div>
            <div class="col-sm-8">
                <select class="form-control" name="specialized">
                    <option value=""> --Chọn chuyên ngành-- </option>
                    <?php
                    if (defined('_SPECIALIZED')) {
                        foreach (_SPECIALIZED as $key => $value) {
                            $specialized = getOldFormData('specialized', $oldBodyArr);
                            $selected = (!empty($specialized) && $specialized == $key) ? "selected" : null;
                            echo '<option ' . $selected . ' value="' . $key  . '">' . $value . ' </option>';
                        }
                    }
                    ?>
                </select>
                <!-- Display error -->
                <?php echo getFormError('specialized', $errorArr); ?>
            </div>
        </div>

        <!-- degree field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Học vị </label>
            </div>
            <div class="col-sm-8">
                <select class="form-control" name="degree">
                    <option value=""> --Chọn học vị-- </option>
                    <?php
                    if (defined('_DEGREES')) {
                        foreach (_DEGREES as $key => $value) {
                            $degree = getOldFormData('degree', $oldBodyArr);
                            $selected = (!empty($degree) && $degree == $key) ? "selected" : null;
                            echo '<option ' . $selected . ' value="' . $key  . '">' . $value . ' </option>';
                        }
                    }
                    ?>
                </select>
                <!-- Display error -->
                <?php echo getFormError('degree', $errorArr); ?>
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

        <!-- Display old avatar field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Avatar cũ</label>
            </div>
            <div class="col-sm-8">
                <!-- Display avatar -->
                <div class="form-group">
                    <img src="<?php echo getOldFormData('oldUploadPath', $oldBodyArr); ?>" alt="Ảnh đại diện" class="img-fluid img-thumbnail">
                </div>
            </div>
        </div>

        <!-- Update avatar field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Cập nhật avatar </label>
            </div>
            <div class="col-sm-8">
                <!-- Browse file -->
                <div class="custom-file form-group">
                    <input type="file" class="custom-file-input" id="customFile" name="avatar">
                    <label class="custom-file-label" for="customFile"><?php echo getOldFormData('avatar', $oldBodyArr, "Chọn ảnh đại diện"); ?></label>
                </div>
                <!-- Display error -->
                <?php echo getFormError('avatar', $errorArr); ?>
            </div>
        </div>

        <input type="hidden" name="id" value="<?php echo getOldFormData('id', $oldBodyArr); ?>">
        <input type="hidden" name="oldUploadPath" value="<?php echo getOldFormData('oldUploadPath', $oldBodyArr); ?>">
        <input type="hidden" name="uploadPath" value="<?php echo getOldFormData('uploadPath', $oldBodyArr); ?>">

        <div class=" row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary "> Xác nhận </button>
            </div>
        </div>
    </form>

</div>