<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416
-->
<?php
    // Alert messages
    if(isset($_SESSION['success'])) {
        echo '<div class="alert alert-success" role="alert" id="alert">' . $_SESSION['success'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
        unset($_SESSION['success']);
    } else if(isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger" role="alert" id="alert">' . $_SESSION['error'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
        unset($_SESSION['error']);
    }
?>