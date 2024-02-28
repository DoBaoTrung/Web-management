<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">
    <form action="" method="get">
        <input type="hidden" name="module" value="score">
        <input type="hidden" name="action" value="search">

        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Sinh viên </label>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="studentKW" value="<?php echo (!empty($studentKW)) ? $studentKW : null; ?>" onfocus="this.value=''">
            </div>
        </div>
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Môn học </label>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="subjectKW" value="<?php echo (!empty($subjectKW)) ? $subjectKW : null; ?>" onfocus="this.value=''">
            </div>
        </div>
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Giáo viên </label>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="teacherKW" value="<?php echo (!empty($teacherKW)) ? $teacherKW : null; ?>" onfocus="this.value=''">
            </div>
        </div>
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary"> Tìm kiếm </button>
            </div>
        </div>
    </form>

    <div class="container">
        <div class="found" style="font-size: 20px;">
            <label> Số bản ghi tìm thấy: <?php echo (!empty($numberOfRows)) ? $numberOfRows : 0; ?> </label>
        </div>
        <table class="table table-bordered" style="margin-top: 50px;">
            <thead class="text-center">
                <tr>
                    <th scope="col" width="5%">No</th>
                    <th scope="col" width="25%">Tên sinh viên</th>
                    <th scope="col" width="25%">Môn học</th>
                    <th scope="col" width="25%">Giáo viên</th>
                    <th scope="col" width="5%">Điểm</th>
                    <th scope="col" width="15%" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($dataFetch)) {
                    $count = 1;
                    foreach ($dataFetch as $item) {
                ?>

                        <tr>
                            <td> <?php echo $count++ ?></td>
                            <td> <?php echo $item['student_name'] ?></td>
                            <td> <?php echo $item['subject_name'] ?></td>
                            <td> <?php echo $item['teacher_name'] ?></td>
                            <td> <?php echo $item['score'] ?></td>
                            <td>
                                <a href='<?php echo '?module=score&action=delete&id=' . $item['id']; ?>' class="btn btn-primary btn-sm" onclick="return confirm('Bạn có muốn xóa điểm của sinh viên <?php echo $item['student_name']; ?> ?')">Xóa</a>
                            </td>
                            <td>
                                <a href='<?php echo '?module=score&action=edit&id=' . $item['id']; ?>' class="btn btn-primary btn-sm">Sửa</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-danger text-center"> Không tìm thấy kết quả! </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
    </div>

</div>