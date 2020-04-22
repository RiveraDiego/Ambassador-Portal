<?php

spl_autoload_register(function ($clase) {
    require_once ('../model/' . $clase . '.php');
});

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    iniciarSesion($_POST['email'], $_POST['password']);
}

function iniciarSesion($email, $password) {
    session_start();
    $user = new User();

    $user->setEmail($email);
    $user->setPassword($password);
    $data = $user->log_in();

    // If result matched $myusername and $password, table row must be 1 row

    if ($data > 1) {
        $_SESSION['root'] = 'http://' . $_SERVER["SERVER_NAME"] . '/';
        $_SESSION['user_id'] = $data["id"];
        $_SESSION['user_name'] = "{$data['name']} {$data['last_name']}";
        $_SESSION['user_email'] = $data["email"];
        $_SESSION['id_rol'] = $data["id_rol"];
        $_SESSION['user_status'] = $data['status'];

        checkIdentifyBy($_SESSION['user_id'],$data['name'],$data['last_name']);

        header("location: " . $_SESSION['root']);
    } else {
        //$error = "Your Login Name or Password is invalid";
        header("location: ../view/pages/login.php?status=0");
    }
}

function checkIdentifyBy($user_id, $name, $last_name) {
    $user2 = new User();
    
    $user2->setId($user_id);
    $user_info = $user2->get();
    $get_identify_by = $user_info['identify_by'];
    
    if($get_identify_by == ""){
        $identify_by = strtolower($name)."".strtolower($last_name);
        $identify_by .= date("HisdmY");
        
        $user3 = new User();
        $user3->setId($user_id);
        $user3->setIdentifyBy($identify_by);
        if($user3->assignIdentifyBy()){
            return True;
        }else{
            return False;
        }
    }    
    
    return True;
}

?>
