<?php
require_once('functions.php');

if(!isset($_POST['submitted'])){
    echo "GET OUT!";
}
else{
    $userNameOrEmail = $_POST['userName'];
    $userPass = $_POST['userPassword'];

    $hash = getUserHash($userNameOrEmail);

    $passwordMatch = password_verify($userPass, $hash);
    if($passwordMatch){
        $userData = getUserData($userNameOrEmail);
        $token = array(
            "user_id" => $userData['user_id'],
            "permissions" => $userData['group_id'],
            "iat" => time(),
            "exp" => time() + (14 * 24 * 60 * 60), //2 week from now
            "iss" => BASE_URL,
            "uip" => $_SERVER['REMOTE_ADDR']
        );
        $key = getSessionKey();
        $jwt = JWT::encode($token, $key, 'HS256');
        setUserToken($userData['user_id'], $jwt);
        $userData['session_token'] = $jwt;
        $_SESSION['userData'] = $userData;
        header("Location: .");
    }
    else{
        header("Location: ./login?err=invalid");
    }
}
?>