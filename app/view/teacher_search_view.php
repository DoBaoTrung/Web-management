<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <form action="" method="get">
        <input type="hidden" name="module" value="teacher">
        <input type="hidden" name="action" value="search">

        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Bộ môn </label>
            </div>
            <div class="col-sm-8">
                <select class="form-control" name="specialized">
                    <option value=""> --Chọn bộ môn-- </option>
                    <?php
                    if (defined('_SPECIALIZED')) {
                        foreach (_SPECIALIZED as $key => $value) {
                            $selected = (!empty($specialized) && $specialized == $key) ? "selected" : null;
                            echo '<option ' . $selected . ' value="' . $key  . '">' . $value . ' </option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class=" col-sm-4 text-center">
                <label> Từ khóa </label>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="keyword" value="<?php echo (!empty($keyword)) ? $keyword : null; ?>">
            </div>
        </div>
        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary "> Tìm kiếm </button>
            </div>
        </div>
    </form>

    <?php
    if (isset($bodyArr['specialized']) || isset($bodyArr['keyword'])) :
        setFlashData('teacherSearchKW', $bodyArr);
    ?>
        <h5>Số giáo viên tìm thấy: <?php echo (!empty($numberOfTeachers)) ? $numberOfTeachers : 0; ?></h5>
        <table class="table table-bordered" style="margin-top: 50px;">
            <thead class="text-center">
                <tr>
                    <th scope="col" width="5%"> No </th>
                    <th scope="col" width="30%"> Tên giáo viên </th>
                    <th scope="col" width="20%"> Khoa </th>
                    <th scope="col" width="30%"> Mô tả chi tiết </th>
                    <th scope="col" width="15%" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($allTeachersQuery)) :
                    $count = 0;
                    foreach ($allTeachersQuery as $item) :
                        $count++;
                ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $item['name']; ?></td>
                            <td>
                                <?php
                                if (defined('_SPECIALIZED')) {
                                    foreach (_SPECIALIZED as $key => $value) {
                                        if ($key == $item['specialized']) {
                                            echo $value;
                                            break;
                                        }
                                    }
                                }
                                ?>
                            </td>
                            <td><?php echo $item['description']; ?></td>
                            <td><a href="<?php echo '?module=teacher&action=delete&id=' . $item['id']; ?>" onclick="return confirm('Bạn có muốn xóa giáo viên: <?php echo $item['name']; ?>')" class="btn btn-primary btn-sm"> Xóa </a></td>
                            <td><a href="<?php echo '?module=teacher&action=edit&id=' . $item['id']; ?>" class="btn btn-primary btn-sm"> Sửa </a></td>
                        </tr>
                    <?php
                    endforeach;
                else :
                    ?>
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-danger text-center"> Không tìm thấy kết quả! </div>
                        </td>
                    </tr>
                <?php
                endif;
                ?>

            </tbody>
        </table>
    <?php endif; ?>
</div>