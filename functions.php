<?php
function is_email_valid($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function is_email_exists($email){
    $users = get_users();

    foreach($users as &$user){
        if($user['email'] === $email){
            return true;
        }
    }
    return false;
}


function is_username_exists($username){
    $users = get_users();

    foreach($users as &$user){
        if($user['username'] === $username){
            return true;
        }
    }
    return false;
}

function signupUser($username, $email, $password){
    $user = [
        'id' => uniqid(),
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'role' => 'user'
    ];

    $users = get_users();
    $users[] = $user;
    file_put_contents("./users.json", json_encode($users));
}

function get_users(){
    if(file_exists("./users.json")){
        $users = file_get_contents("./users.json");
        if(strlen($users)>0){
        return json_decode($users,true);
        }
        else{
            return [];
        }
    }
    return [];
}

function authenticateUser($email, $password){
    $users = get_users();
    foreach($users as $user){
        if($user['email'] === $email && $user['password'] === $password){
            return $user;
        }
    }
    return null;
}

function updateUserRole($userId, $newRole){
    $users = get_users();
    foreach($users as &$user){
        if($user['id'] === $userId){
            $user['role'] = $newRole;
            break;
        }
    }
    file_put_contents("./users.json", json_encode($users));
}

function updateUser($userId, $username, $email, $role){
    $users = get_users();
    foreach($users as &$user){
        if($user['id'] === $userId){
            $user['username']=$username;
            $user['email']=$email;
            $user['role'] = $role;
            break;
        }
    }
    file_put_contents("./users.json", json_encode($users));
}

function deleteUser($userId){
    $users = get_users();
    foreach($users as $key => $user){
        if($user['id'] === $userId){
            unset($users[$key]);
            break;
        }
    }
    file_put_contents("./users.json", json_encode($users));
}

function addUser($role,$username, $email, $password){
    $user = [
        'id' => uniqid(),
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'role' => $role
    ];

    $users = get_users();
    $users[] = $user;
    file_put_contents("./users.json", json_encode($users));
}
?>
