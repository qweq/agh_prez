<?php
include('include/init.php');
?>
<html>
<head>
    <title>AGH - PREZENTACJE</title>
    <?=$base::GetHeader()?>
</head>
<body>
<style>
    #main-container {
        background-image: url("https://upload.wikimedia.org/wikipedia/commons/6/6d/Krakow_AGH_A-0_hol_1.jpg");
        background-size: cover;
        background-color: rgba(255, 255, 255, 0.6);
        background-blend-mode: overlay;
    }
</style>
<div id="main-container" style="width: 100%; height: 100%">
    <?php if (!isset($_SESSION['user'])) {
        include('login.php');
    }
    else {
        include('dashboard.php');
    }
    ?>
</div>
</body>
</html>

