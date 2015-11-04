<?php

require_once('collectr_config.php');
require_once('vendor/autoload.php');
session_start();
define('INSTALL_FOLDER', '/collectr/');

if(empty($_SERVER['HTTPS'])) {
    define('BASE_URL', "HTTP://" . $_SERVER['HTTP_HOST'] . INSTALL_FOLDER);
}
else{
    define('BASE_URL', "HTTPS://" . $_SERVER['HTTP_HOST'] . INSTALL_FOLDER);
}



function getCurrentUri() {
    $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
    $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
    if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
    $uri = '/' . trim($uri, '/');
    return $uri;
}

function getPathRoute() {
    $base_url = getCurrentUri();
    $rarr = explode('/', $base_url);
    $routes = array();
    foreach($rarr as $route)
    {
        if(trim($route) != '')
            array_push($routes, $route);
    }
    return $routes;
}

function connectDB(){
    $db = new PDO('mysql:host=localhost:8889;dbname=collectr;charset=utf8', DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

function getUserData($email_name){
    $db = connectDB();
    $stmt = $db->prepare("SELECT user_id, user_email, user_name, group_id, pronoun_id FROM cr_user
                          WHERE user_email=:user_input OR user_name=:user_input;");
    $stmt->bindValue(':user_input', $email_name, PDO::PARAM_STR);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $user_data = $rows[0];

    $stmt = $db->prepare("SELECT  subj, obj, poss_det, poss_pro, reflexive FROM cr_pronouns WHERE pronoun_id=:pronoun_id;");
    $stmt->bindValue(':pronoun_id', $user_data['pronoun_id'], PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $user_data['pronouns'] = $rows[0];

    $stmt = $db->prepare("SELECT gender_id FROM cr_user_gender WHERE user_id=:user_id;");
    $stmt->bindValue(':user_id', $user_data['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $gender_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $user_data['gender'] = array();
    foreach($gender_ids as $gender_id){
        $gender_id = $gender_id['gender_id'];
        $stmt = $db->prepare("SELECT gender_name FROM cr_gender WHERE gender_id=:gender_id;");
        $stmt->bindValue(":gender_id", $gender_id, PDO::PARAM_INT);
        $stmt->execute();
        $gender_name = $stmt->fetchAll((PDO::FETCH_ASSOC));
        $user_data['gender'][] = $gender_name[0]['gender_name'];
    }
    return $user_data;
}

/**
 * Creates a md5 hash for uniquely identifying sets of pronouns
 *
 * @param $subject_pronoun
 * @param $object_pronoun
 * @param $possessive_determiner_pronoun
 * @param $possessive_pronoun
 * @param $reflexive_pronoun
 * @return string The MD5 hash of the combined pronouns
 */
function hashPronouns($subject_pronoun, $object_pronoun, $possessive_determiner_pronoun, $possessive_pronoun,
                       $reflexive_pronoun){
    $combined = array($subject_pronoun, $object_pronoun, $possessive_determiner_pronoun, $possessive_pronoun,
        $reflexive_pronoun);
    $combinedStr = implode($combined);
    return md5($combinedStr);
}

function getSessionKey(){
    $db = connectDB();
    $stmt = $db->prepare("SELECT option_value FROM cr_options WHERE option_name=:option_value;");
    $stmt->bindValue(':option_value', 'session_key', PDO::PARAM_STR);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows[0]['option_value'];
}

function getUserHash($email_name){
    $db = connectDB();
    $stmt = $db->prepare("SELECT user_pass FROM cr_user WHERE user_email=:user_input OR user_name=:user_input;");
    $stmt->bindValue(':user_input', $email_name, PDO::PARAM_STR);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows[0]['user_pass'];
}

function verifyLogin(){
    $session_token = $_SESSION['userData']['session_token'];
    $session_key = getSessionKey();
    try {
        $decoded = JWT::decode($session_token, $session_key, array('HS256'));
        if($decoded->uip!=$_SERVER['REMOTE_ADDR']){
            return false;
        }
        return true;
    } catch (Exception $e){
        //var_dump($e);
        return false;
    }
}

function setUserToken($user_id, $jwt){
    $db = connectDB();
    try{
        $stmt = $db->prepare("INSERT INTO cr_user_tokens(user_id, token_value) VALUE(:user_id, :token_value);");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        if($jwt==NULL){
            $stmt->bindValue(':token_value', NULL, PDO::PARAM_NULL);
        }
        else {
            $stmt->bindValue(':token_value', $jwt, PDO::PARAM_STR);
        }
        $stmt->execute();
    } catch (Exception $e) {
        $stmt = $db->prepare("UPDATE cr_user_tokens SET token_value=:token_value WHERE user_id=:user_id;");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        if($jwt==NULL){
            $stmt->bindValue(':token_value', NULL, PDO::PARAM_NULL);
        }
        else {
            $stmt->bindValue(':token_value', $jwt, PDO::PARAM_STR);
        }
        $stmt->execute();
    }
}

function checkUserToken($user_id, $jwt){
    $db = connectDB();
    $stmt = $db->prepare("SELECT token_value FROM cr_user_tokens WHERE user_id=:user_id");
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['token_value'] == $jwt;
}
?>