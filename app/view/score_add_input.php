<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <h3 class="text-center text-uppercase" style="margin-bottom: 50px;"> Nhập điểm </h3>

    <form action="" method="post" enctype="multipart/form-data">
        <!-- Display message -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col">
                <?php echo getFormMessage($msg, $msgType); ?>
            </div>
        </div>

        <!-- Student field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Sinh viên </label>
            </div>
            <div class="col-sm-8">
                <select class="selectpicker form-control" data-live-search="true" name="student_id">
                    <option value=""> --Chọn sinh viên-- </option>
                    <?php
                    if (!empty($allStudentsQuery)) {
                        foreach ($allStudentsQuery as $item) {
                            $studentId = getOldFormData('student_id', $oldBodyArr);
                            $selected = (!empty($studentId) && $studentId == $item['id']) ? "selected" : null;
                            echo '<option ' . $selected . ' value="' . $item['id']  . '">' . $item['name'] . ' </option>';
                        }
                    }
                    ?>
                </select>
                <!-- Display error -->
                <?php echo getFormError('student_id', $errorArr); ?>
            </div>
        </div>

        <!-- Subject field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Môn học </label>
            </div>
            <div class="col-sm-8">
                <select class="selectpicker form-control" data-live-search="true" name="subject_id">
                    <option value=""> --Chọn môn học-- </option>
                    <?php
                    if (!empty($allSubjectsQuery)) {
                        foreach ($allSubjectsQuery as $item) {
                            $subjectId = getOldFormData('subject_id', $oldBodyArr);
                            $selected = (!empty($subjectId) && $subjectId == $item['id']) ? "selected" : null;
                            echo '<option ' . $selected . ' value="' . $item['id']  . '">' . $item['name'] . ' </option>';
                        }
                    }
                    ?>
                </select>
                <!-- Display error -->
                <?php echo getFormError('subject_id', $errorArr); ?>
            </div>
        </div>

        <!-- Teacher field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Giáo viên </label>
            </div>
            <div class="col-sm-8">
                <select class="selectpicker form-control" data-live-search="true" name="teacher_id">
                    <option value=""> --Chọn giáo viên-- </option>
                    <?php
                    if (!empty($allTeachersQuery)) {
                        foreach ($allTeachersQuery as $item) {
                            $studentId = getOldFormData('teacher_id', $oldBodyArr);
                            $selected = (!empty($studentId) && $studentId == $item['id']) ? "selected" : null;
                            echo '<option ' . $selected . ' value="' . $item['id']  . '">' . $item['name'] . ' </option>';
                        }
                    }
                    ?>
                </select>
                <!-- Display error -->
                <?php echo getFormError('teacher_id', $errorArr); ?>
            </div>
        </div>

        <!-- score field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Điểm </label>
            </div>
            <div class="col-sm-4">
                <select class="form-control" name="score">
                    <option value=""> --Chọn điểm-- </option>
                    <?php
                    if (defined('_SCORES')) {
                        foreach (_SCORES as $value) {
                            $score = getOldFormData('score', $oldBodyArr);
                            $selected = (!empty($score) && $score == $value) ? "selected" : null;
                            echo '<option ' . $selected . ' value="' . $value  . '">' . $value . ' </option>';
                        }
                    }
                    ?>
                </select>
                <!-- Display error -->
                <?php echo getFormError('score', $errorArr); ?>
            </div>
        </div>


        <!-- description field -->
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Nhận xét chi tiết </label>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <textarea class="form-control" rows="5" name="description"><?php echo getOldFormData('description', $oldBodyArr); ?></textarea>
                </div>
                <!-- Display error -->
                <?php echo getFormError('description', $errorArr); ?>
            </div>
        </div>

        <div class=" row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary "> Xác nhận </button>
            </div>
        </div>
    </form>

</div>