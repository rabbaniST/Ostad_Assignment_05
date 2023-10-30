<?php
session_start();
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];

    if($user['role'] === 'user'){
        header("Location: ./user_dashboard.php");
    }
    else if($user['role'] === 'manager'){
        header("Location: ./manager_dashboard.php");
    }
    else if($user['role'] === 'admin'){
        header("Location: ./admin_dashboard.php");
    }
}
else{
    header("Location: ./login.php");
}
?>



