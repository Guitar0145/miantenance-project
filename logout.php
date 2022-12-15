<?php
    session_start();
    unset(
        $_SESSION['u_id'],
        $_SESSION['username'],
        $_SESSION['level'],
        $_SESSION['u_name'],
        $_SESSION["timeLasetdActive"]
    );
    header("Location: index.php");
?>