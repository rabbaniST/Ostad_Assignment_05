<?php
session_start();
include './functions.php';
$usernameError = $emailError = "";

if (isset($_SESSION['user'])) {

    $user = $_SESSION['user'];
    if (!($user['role'] === 'admin')) {
        header("Location: ./index.php");
    }


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


        if ($usernameError == "" && $emailError == "" && $passwordError == "") {
            addUser($role, $username, $email, $password);

            header("Location: ./admin_dashboard.php");
        }
    }


    if (isset($_POST['editRole'])) {
        $userId = $_POST['userId'];
        $newRole = $_POST['role'];
        updateUserRole($userId, $newRole);
        header("Location: ./admin_dashboard.php");
    }

    if (isset($_POST['updateChanges'])) {
        $userId = $_POST['userId'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        echo $userId . " " . $username . " " . $email . " " . $role;
        updateUser($userId, $username, $email, $role);
        header("Location: ./admin_dashboard.php");
    }

    if (isset($_POST['deleteuser'])) {
        $userId = $_POST['userId'];
        deleteUser($userId);
        header("Location: ./admin_dashboard.php");
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
    <title>Role Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="text-center">Admin Dashboard</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <h2 class=" text-center">User Details</h2>
        <div class="d-flex justify-content-between">
            <button class="btn btn-primary mb-3"><a class="text-white" href="/createUser.php">Create User</a></button>
            <button class="btn btn-danger mb-3"><a class="text-white" href="./logout.php">Logout</a></button>
        </div>
        <table class="table table-striped">
            <thead class="">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php
                $roles = ['User', 'Manager', 'Admin'];

                foreach ($users as $singleUser) {

                    if (!($singleUser['username'] === $user['username'])) {
                        $str = json_encode($singleUser);
                        echo "<tr>
                        <td>{$singleUser['username']}</td>
                        <td>{$singleUser['email']}</td>
                        <td>{$singleUser['role']}</td>
                        <td>
                        <form method='post' action=''>
                        <button onclick='return passValue(JSON.parse(\"" . addslashes($str) . "\"))' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editRoleModal'><a class='text-white' href='/update.php'>Update</a></button>

                        <input type='hidden' id='userID' name='userId' value='{$singleUser['id']}'></input>
                        <button type='submit' onclick='return deleteRow()' class='btn btn-danger btn-sm' name='deleteuser'>Delete</button>
                    </form>
                        </td>
                        </tr>";
                    } else {
                        echo "<tr>
                        <td>{$singleUser['username']}</td>
                        <td>{$singleUser['email']}</td>
                        <td>{$singleUser['role']}</td>
                        <td>
                            
                        </td>
                        </tr>";
                    }
                }

                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Update User details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateUserForm" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                        <div class="mb-3">
                            <label for="updateRole" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="user">User</option>
                                <option value="manager">Manager</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="userName" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <input type="hidden" id="updateUserId" name="userId">
                        <button type="submit" class="btn btn-primary" name="updateChanges">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function deleteRow() {
            return confirm("Are you sure delete this user?");
        }

        function passValue(object) {
            document.getElementById('role').value = object['role'];
            document.getElementById('userName').value = object['username'];
            document.getElementById('email').value = object['email'];
            document.getElementById('updateUserId').value = object['id'];
            console.log(object['id']);

            return false;
        }
    </script>
</body>

</html>