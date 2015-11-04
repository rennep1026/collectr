<?php
require_once('functions.php');

if(!isset($_POST['submitted'])){
    echo "GET OUT!";
}
else{
    $user_email = $_POST['email'];
    $user_name = strtolower($_POST['userName']);
    $user_pass = password_hash($_POST['userPassword'], PASSWORD_DEFAULT);
    $user_gender = $_POST['gender'];
    $gender_ids = array();
    foreach($user_gender as $gender){
        $gender_ids[] = get_gender_id($gender);
    }
    $subjectP = $_POST['subjectP'];
    $objectP = $_POST['objectP'];
    $possDetP = $_POST['possDetP'];
    $possP = $_POST['possP'];
    $reflexP = $_POST['reflexP'];
    $pronoun_id = get_pronoun_id($subjectP, $objectP, $possDetP, $possP, $reflexP);

    $db = connectDB();

    try {
        $stmt = $db->prepare("INSERT INTO cr_user (user_id, user_email, user_name, user_pass, group_id, pronoun_id)
                              VALUES('', :user_email, :user_name, :user_pass, :group_id, :pronoun_id)");
        $stmt->bindValue(':user_email', $user_email, PDO::PARAM_STR);
        $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->bindValue(':user_pass', $user_pass, PDO::PARAM_STR);
        $stmt->bindValue(':group_id', 1, PDO::PARAM_INT);
        $stmt->bindValue(':pronoun_id', $pronoun_id, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $db->prepare("SELECT user_id FROM cr_user WHERE user_email=:user_email;");
        $stmt->bindValue(':user_email', $user_email, PDO::PARAM_STR);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $user_id = $rows[0]['user_id'];

        foreach($gender_ids as $gender_id){
            $stmt = $db->prepare("INSERT INTO cr_user_gender (user_id, gender_id) VALUES(:user_id, :gender_id);");
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindValue(':gender_id', $gender_id, PDO::PARAM_STR);
            $stmt->execute();
        }

        $user_data = getUserData($user_email);
        header("Location: .");
    } catch(PDOException $ex){
        header("Location: ./register?err=user");
    }
}

/**
 * @param $genderName The name of the gender
 * @return integer The ID of the gender
 */
function get_gender_id($genderName){
    $db = connectDB();
    try {
        $stmt = $db->prepare("SELECT gender_id FROM cr_gender WHERE gender_name=:gender_name;");
        $stmt->bindValue(':gender_name', $genderName, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (sizeOf($rows) != 0) {
            $genderID = $rows[0]['gender_id'];
        } else {
            $stmt = $db->prepare("INSERT INTO cr_gender(gender_id, gender_name) VALUES('', :genderName);");
            $stmt->bindValue(':genderName', $genderName, PDO::PARAM_STR);
            $stmt->execute();
            $stmt = $db->prepare("SELECT gender_id FROM cr_gender WHERE gender_name=:gender_name;");
            $stmt->bindValue(':gender_name', $genderName, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $genderID = $rows[0]['gender_id'];
        }
    } catch(PDOException $ex){
        header("Location: ./register?err=gender");
    }
    return $genderID;
}

function get_pronoun_id($subjP, $objP, $possDetP, $possP, $reflexP){
    $pronoun_hash = hashPronouns($subjP, $objP, $possDetP, $possP, $reflexP);
    $db = connectDB();
    try {
        $stmt = $db->prepare("SELECT pronoun_id FROM cr_pronouns WHERE pronoun_hash=:pronoun_hash;");
        $stmt->bindValue(':pronoun_hash', $pronoun_hash, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (sizeOf($rows) != 0) {
            $pronounID = $rows[0]['pronoun_id'];
        } else {
            $stmt = $db->prepare("INSERT INTO cr_pronouns(pronoun_id, pronoun_hash, subj, obj, poss_det, poss_pro,
                                  reflexive) VALUES('', :pronoun_hash, :subj, :obj, :poss_det, :poss_pro,
                                  :reflexive);");
            $stmt->bindValue(':pronoun_hash', $pronoun_hash, PDO::PARAM_STR);
            $stmt->bindValue(':subj', $subjP, PDO::PARAM_STR);
            $stmt->bindValue(':obj', $objP, PDO::PARAM_STR);
            $stmt->bindValue(':poss_det', $possDetP, PDO::PARAM_STR);
            $stmt->bindValue(':poss_pro', $possP, PDO::PARAM_STR);
            $stmt->bindValue(':reflexive', $reflexP, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $db->prepare("SELECT pronoun_id FROM cr_pronouns WHERE pronoun_hash=:pronoun_hash;");
            $stmt->bindValue(':pronoun_hash', $pronoun_hash, PDO::PARAM_STR);
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pronounID = $rows[0]['pronoun_id'];
        }
    } catch(PDOException $ex){
        header("Location: ./register?err=pronoun");
    }
    return $pronounID;
}
?>