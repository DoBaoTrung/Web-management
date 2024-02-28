<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">

    <form action="" method="get">
        <input type="hidden" name="module" value="subject">
        <input type="hidden" name="action" value="search">

        <div class="row mx-auto" style="width: 50%; margin: 20px auto;">
            <div class="col-sm-4 text-center">
                <label> Khóa học </label>
            </div>
            <div class="col-sm-8">
                <select class="form-control" name="school_year">
                    <option value=""> --Chọn khóa học-- </option>
                    <?php
                    if (defined('_SCHOOL_YEARS')) {
                        foreach (_SCHOOL_YEARS as $key => $value) {
                            $selected = (!empty($schoolYear) && $schoolYear == $key) ? "selected" : null;
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


    <h5>Số môn học tìm thấy: <?php echo $numberOfRows; ?></h5>

    <table class="table table-bordered" style="margin-top: 50px;">
        <thead class="text-center">
            <tr>
                <th scope="col" width="5%"> No </th>
                <th scope="col" width="30%"> Tên môn học </th>
                <th scope="col" width="20%"> Khóa học </th>
                <th scope="col" width="30%"> Mô tả chi tiết </th>
                <th scope="col" width="15%" colspan="2"> Action </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($allSubjectsQuery)) :
                $count = 0;
                foreach ($allSubjectsQuery as $item) :
                    $count++;
            ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td>
                            <?php
                            if (defined('_SCHOOL_YEARS')) {
                                foreach (_SCHOOL_YEARS as $key => $value) {
                                    if ($key == $item['school_year']) {
                                        echo $value;
                                        break;
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo $item['description']; ?></td>
                        <td><a href="<?php echo '?module=subject&action=delete&id=' . $item['id']; ?>" onclick="return confirm('Bạn có muốn xóa môn học: <?php echo $item['name']; ?>')" class="btn btn-primary btn-sm"> Xóa </a></td>
                        <td><a href="<?php echo '?module=subject&action=edit&id=' . $item['id']; ?>" class="btn btn-primary btn-sm"> Sửa </a></td>
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
</div>