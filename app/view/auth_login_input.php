<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="container">
    <div class="row">
        <div class="col-5" style="margin: 100px auto;">
            <h3 class="text-center text-uppercase"> Đăng nhập hệ thống </h3>

            <?php echo getFormMessage($msg, $msgType); ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="login_id"> Người dùng </label>
                    <input type="text" name="login_id" id="login_id" class="form-control" placeholder="Nhập login_id..." value="<?php echo getOldFormData('login_id', $oldBodyArr); ?>">
                    <!-- Display error -->
                    <?php echo getFormError('login_id', $errorArr); ?>
                </div>

                <div class="form-group">
                    <label for="password"> Mật khẩu </label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu..." value="<?php echo getOldFormData('password', $oldBodyArr); ?>">
                    <!-- Display error -->
                    <?php echo getFormError('password', $errorArr); ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block"> Đăng nhập </button>
                <hr>

                <p class="text-center">
                    <a href="?module=auth&action=forgot"> Quên mật khẩu </a>
                </p>

            </form>
        </div>
    </div>
</div>