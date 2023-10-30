<?php
session_start();
include './functions.php';

if(isset($_SESSION['user'])){
    header("Location: ./index.php");
}


$emailError = $authFailed = "";


if($_SERVER['REQUEST_METHOD']=='POST'){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(!is_email_valid($email)){
        $emailError=" Your mail is not valid!";
    }

    $user = authenticateUser($email, $password);
    if($user){
        $_SESSION['user'] = $user;
        header("Location: ./index.php");
    } else {
        $authFailed = "Email or Password are Invalid";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <style>

        .container {
            margin-top: 100px;
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
        <div class="login-container">
            <h2 class="text-center mb-4">Login</h2>
            <form method="POST" >
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label> <?php echo "<label for='email' class='text-danger'>$emailError</label>";?>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <label class="text-danger"><?php echo $authFailed;?></label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>

                <p class="mt-2">Don't have any account? <a href="./signup.php">Signup</a></p>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
