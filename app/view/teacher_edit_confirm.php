<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <h3 class="text-center text-uppercase" style="margin-bottom: 50px;"> Sửa giáo viên </h3>

    <form action="" method="post" enctype="multipart/form-data">
        <!-- name field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Họ và tên </label>
            </div>
            <div class="col-sm-8">
                <input readonly type="text" class="form-control" name="name" value="<?php echo getOldFormData('name', $teacherEditData); ?>">
            </div>
        </div>

        <!-- specialized field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Khoa </label>
            </div>
            <?php
            $specialized = getOldFormData('specialized', $teacherEditData);
            if (defined('_SPECIALIZED') && $teacherEditData) {
                foreach (_SPECIALIZED as $key => $value) {
                    if ($key == $specialized) {
                        $specialized = $value;
                        break;
                    }
                }
            }
            ?>
            <div class="col-sm-8">
                <input readonly type="text" class="form-control" name="specialized" value="<?php echo $specialized; ?>">
            </div>
        </div>

        <!-- degree field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Học vị </label>
            </div>
            <?php
            $degree = getOldFormData('degree', $teacherEditData);
            if (defined('_DEGREES')) {
                foreach (_DEGREES as $key => $value) {
                    if ($key == $degree) {
                        $degree = $value;
                        break;
                    }
                }
            }
            ?>
            <div class="col-sm-8">
                <input readonly type="text" class="form-control" name="degree" value="<?php echo $degree; ?>">
            </div>
        </div>

        <!-- description field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Mô tả chi tiết </label>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <textarea readonly class="form-control" rows="5" name="description"><?php echo getOldFormData('description', $teacherEditData); ?></textarea>
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
                    <img src="<?php echo getOldFormData('uploadPath', $teacherEditData); ?>" alt="Ảnh đại diện" class="img-fluid img-thumbnail">
                </div>
            </div>
        </div>
    </form>

    <div class=" row mx-auto text-center" style="width: 50%; margin: 20px auto;">
        <div class="col-sm-6">
            <a href="<?php echo '?module=teacher&action=edit&id=' . $teacherEditData['id']; ?>" class="btn btn-primary"> Sửa lại </a>
        </div>
        <div class="col-sm-6">
            <a href="<?php echo '?module=teacher&action=edit&screen=complete&token=' . $teacherEditData['token']; ?>" class="btn btn-primary"> Sửa </a>
        </div>
    </div>

</div>