<?php
session_start();
include './functions.php';


if(isset($_SESSION['user'])){
    header("Location: ./index.php");
}

$usernameError = $emailError = $passwordError = "";
$role = "user";


if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if(is_username_exists($username)){
        $usernameError = " Username is already exists!";
    }
    if(!is_email_valid($email)){
        $emailError = " Email is not valid!";
    }
    if(is_email_exists($email)){
        $emailError = " Email is already exists!";
    }
    if($usernameError == "" && $emailError=="" && $passwordError==""){
        signupUser($username,$email,$password);
        header("Location: ./login.php");
        exit();
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    
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
            <h2 class="text-center mb-4">Create An Account</h2>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
            <div class="mb-3">
                    <label for="username" class="form-label">Username </label> <?php echo "<label for='username' class='text-danger'>$usernameError</label>";?>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label> <?php echo "<label for='username' class='text-danger'>$emailError</label>";?>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Signup</button>
                <p class="mt-2">Already have an account? <a href="./login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
