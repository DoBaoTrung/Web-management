<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container" style="margin: 50px auto;">
    Tên đăng nhập: <?php echo $_SESSION['login_id']; ?>
    <br>
    Thời gian đăng nhập: <?php echo $_SESSION['login_time']; ?>

    <div class="col-10" style="margin: 50px auto;">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th scope="col">Giáo viên</th>
                    <th scope="col">Môn học</th>
                    <th scope="col">Sinh viên</th>
                    <th scope="col">Điểm</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="?module=teacher&action=search"> Tìm kiếm </a></td>
                    <td><a href="?module=subject&action=search"> Tìm kiếm </a></td>
                    <td><a href="?module=student&action=search"> Tìm kiếm </a></td>
                    <td><a href="?module=score&action=search"> Tìm kiếm </a></td>
                </tr>

                <tr>
                    <td><a href="?module=teacher&action=add"> Thêm mới </a></td>
                    <td><a href="?module=subject&action=add"> Thêm mới </a></td>
                    <td><a href="?module=student&action=add"> Thêm mới </a></td>
                    <td><a href="?module=score&action=add"> Thêm mới </a></td>
                </tr>

            </tbody>
        </table>
    </div>
</div>