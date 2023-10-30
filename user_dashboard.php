<?php
session_start();

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    if (!($user['role'] === 'user')) {
        header("Location: ./index.php");
    }
} else {
    header("Location: ./login.php");
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>

<body>
    <div class="container mt-5">
        <div>
            <h1 class="mb-5">User Dashboard</h1>
            <h2>User Details</h2>
            <div class="d-flex justify-content-between">
                <div>
                    <p class="card-text"><strong>Username:</strong> <span id="username"><?php echo $user['username']; ?></span></p>
                    <p class="card-text"><strong>User Email:</strong> <span id="userEmail"><?php echo $user['email']; ?></span></p>
                    <p class="card-text"><strong>User Role:</strong> <span id="userRole"><?php echo $user['role']; ?></span></p>
                </div>
                <div>
                    <p>Welcome to User Dashboard</p>
                    <a href="./logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>


        </div>
    </div>
</body>

</html>