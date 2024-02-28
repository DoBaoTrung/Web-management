<?php
if (!defined('_INCODE')) die('Access denied...');
?>

<div class="" style="width: 600px; padding: 20px 30px; text-align: center; margin: 0 auto;">
    <h2 style="text-transform: uppercase;"> Lỗi liên quan đến cơ sở dữ liệu </h2>
    <hr>
    <p> Error: <?php echo $exception->getMessage(); ?> </p>
    <p> Line: <?php echo $exception->getFile(); ?> </p>
    <p> File: <?php echo $exception->getLine(); ?> </p>
</div>