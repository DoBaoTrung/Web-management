<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <h3 class="text-center text-uppercase" style="margin-bottom: 50px;"> Sửa môn học </h3>

    <form action="" method="post" enctype="multipart/form-data">
        <!-- name field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Tên môn học </label>
            </div>
            <div class="col-sm-8">
                <input readonly type="text" class="form-control" name="name" value="<?php echo getOldFormData('name', $subjectEditData); ?>">
            </div>
        </div>

        <!-- school_year field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Khóa học </label>
            </div>
            <?php
            $schoolYear = getOldFormData('school_year', $subjectEditData);
            if (defined('_SCHOOL_YEARS')) {
                foreach (_SCHOOL_YEARS as $key => $value) {
                    if ($key == $schoolYear) {
                        $schoolYear = $value;
                        break;
                    }
                }
            }
            ?>
            <div class="col-sm-8">
                <input readonly type="text" class="form-control" name="school_year" value="<?php echo $schoolYear; ?>">
            </div>
        </div>

        <!-- description field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Mô tả chi tiết </label>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <textarea readonly class="form-control" rows="5" name="description"><?php echo getOldFormData('description', $subjectEditData); ?></textarea>
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
                    <img src="<?php echo getOldFormData('uploadPath', $subjectEditData); ?>" alt="Ảnh đại diện" class="img-fluid img-thumbnail">
                </div>
            </div>
        </div>
    </form>

    <div class=" row mx-auto text-center" style="width: 50%; margin: 20px auto;">
        <div class="col-sm-6">
            <a href="<?php echo '?module=subject&action=edit&id=' . $subjectEditData['id']; ?>" class="btn btn-primary"> Sửa lại </a>
        </div>
        <div class="col-sm-6">
            <a href="<?php echo '?module=subject&action=edit&screen=complete&token=' . $subjectEditData['token']; ?>" class="btn btn-primary"> Sửa </a>
        </div>
    </div>
</div>