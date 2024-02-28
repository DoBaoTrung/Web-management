<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">
    <div class="content">
        <h3 class="text-center text-uppercase" style="margin-bottom: 50px; text-align: center;"> Sửa Thông Tin Sinh Viên </h3>

        <form action="" method="post" enctype="multipart/form-data" style="margin-right: 10%;">
            <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
                <div class="col">
                    <?php echo "" ?>
                </div>
            </div>

            <!-- name field -->
            <div class="row mx-auto" style="width: 90%; margin: 50px auto;">
                <div class=" col-sm-4 text-center">
                    <label> Họ và Tên </label>
                </div>
                <div class="col-sm-8">
                    <input readonly type="text" class="form-control" name="name" value="<?php echo getOldFormData('name', $studentEditData);  ?>" style="border: 1px solid #366fa5; width: 400px;">
                </div>
            </div>

            <!-- avatar field -->
            <div class="row mx-auto" style="width: 90%; margin: 50px auto;">
                <div class=" col-sm-4 text-center">
                    <label> Avatar </label>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <img src="<?php echo getOldFormData('uploadPath', $studentEditData); ?>" alt="Ảnh đại diện" class="img-fluid img-thumbnail" style="width: 250px; height: 250px; border: none;">
                    </div>
                </div>
            </div>

            <!-- description field -->
            <div class="row mx-auto" style="width: 90%; margin: 50px auto;">
                <div class=" col-sm-4 text-center">
                    <label> Mô tả chi tiết </label>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <textarea readonly class="form-control" rows="5" name="description" style="border: 1px solid #366fa5; width: 400px;"> <?php echo getOldFormData('description', $studentEditData); ?> </textarea>
                    </div>
                </div>
            </div>
        </form>
        <div class=" row mx-auto text-center" style="width: 90%; margin: 50px auto;">
            <div class="col-sm-6">
                <a href="<?php echo '?module=student&action=edit&id=' . $studentEditData['id']; ?>" class="btn btn-primary" style="width: 100px;"> Sửa lại </a>
            </div>
            <div class="col-sm-6">
                <a href="<?php echo '?module=student&action=edit&step=complete&token=' . $studentEditData['token']; ?>" class="btn btn-primary" style="width: 100px;"> Sửa </a>
            </div>
        </div>
    </div>
</div>