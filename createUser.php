<?php
session_start();
include './functions.php';

$usernameError = $emailError = "";

if (isset($_SESSION['user'])) {

    $user = $_SESSION['user'];
    $users = get_users();


    if (isset($_POST['add_user'])) {
        $role = trim($_POST['role']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (is_username_exists($username)) {
            $usernameError = "* username is already exists!";
        }
        if (!is_email_valid($email)) {
            $emailError = "* email is not valid!";
        }
        if (is_email_exists($email)) {
            $emailError = "* email is already exists!";
        }


        if ($usernameError == "" && $emailError == "") {
            addUser($role, $username, $email, $password);

            header("Location: ./admin_dashboard.php");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">

    <style>
        .container {
            margin-top: 80px;
            width: 500px;
            height: auto;
            background-color: #F5F7F8;
            box-shadow: 1px 2px 8px 0.5px;
            padding: 25px;
            border-radius: 10px;

        }
    </style>
</head>



<body>
    <div class="container">
        <h5 class="">Add User</h5>
        <form method="POST" action="admin_dashboard.php">
            <div class="mb-3">
                <label for="updateUser" class="form-label">Role</label>
                <select class="form-select" id="updateUser" name="role" required>
                    <option value="user">User</option>
                    <option value="manager">Manager</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label> <?php echo "<label for='username' class='text-danger'>$usernameError</label>"; ?>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label> <?php echo "<label for='username' class='text-danger'>$emailError</label>"; ?>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_user">Add User</button>
            <button type="submit" class="btn btn-primary" name="add_user"><a class="text-white" href="admin_dashboard.php">Cancel</a></button>
        </form>
    </div>
</body>

</html>