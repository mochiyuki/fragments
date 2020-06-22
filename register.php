<?
include 'php/config.php';

$username=trim($_POST['username']);
$password=trim($_POST['password']);
$passwordver=trim($_POST['passwordver']);
$email=$_POST['email'];
//vérifier si les champs ne sont pas vides
if(!empty($username)&& !empty($password)&& !empty($passwordver)&& !empty($email)){
  //si les champs ne sont pas vides, vérifier que l'username respecte certaines règles
  if(preg_match('/^[a-z\d_]{2,20}$/i', $username)){
    //requête pour compter les lignes d'une colonne donné
    $reqcheckUsername=$sql_connection->prepare("SELECT COUNT(*) AS members_count FROM members WHERE username = :username");
    $reqcheckUsername->bindValue(':username', $username);
    $reqcheckUsername->execute();
    $usernameUnavailable=$reqcheckUsername->fetch(PDO::FETCH_ASSOC);
    //vérifier si l'username n'est pas déjà pris
    if($usernameUnavailable['members_count'] == 0){
      //vérifier que l'email soit valide
      if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        //même requête pour vérifier que l'adresse email ne soit pas déjà utilisée
        $reqcheckEmail=$sql_connection->prepare("SELECT COUNT(*) AS email_addresses FROM members WHERE email = :email");
        $reqcheckEmail->bindValue(':email', $email);
        $reqcheckEmail->execute();
        $emailUnavailable=$reqcheckEmail->fetch(PDO::FETCH_ASSOC);
        if($emailUnavailable['email_addresses'] == 0){
          //vérifier que les deux mots de passe se correspondent
          if($password === $passwordver){
            //créer une clé de hashage pour le mot de passe
            $hashed_password=password_hash($password, PASSWORD_DEFAULT);
            //créer une clé de hashage pour la clé de confirmation
            $confirmkey=md5($username);
            //si toutes les conditions sont respectées alors ajouter le nouveau utilisateur
            $newMember=$sql_connection->prepare("INSERT INTO members (username, password, passwordver, email, confirmkey, dateregistered) VALUES (:username, :password, :passwordver, :email, :confirmkey, NOW())");
            $newMember->bindValue(':username', $username);
            $newMember->bindValue(':password', $hashed_password);
            $newMember->bindValue(':passwordver', $hashed_password);
            $newMember->bindValue(':email', $email);
            $newMember->bindValue(':confirmkey', $confirmkey);
            $newMember->execute();
            
            $subject="Your confirmation key";
            $message="Confirm your account http://localhost/projet/welcome.php?confirm=$confirmkey";

            $mailTo=$_POST['email'];
            mail($mailTo, $subject, $message);
            echo json_encode(array('type' => 'success', 'message' => 'success'));
          } else{echo json_encode(array('type' => 'error1', 'message' => 'passwords do not match'));}
        } else{echo json_encode(array('type' => 'error2', 'message' => 'email already in use'));}
      } else{echo json_encode(array('type' => 'error3', 'message' => 'email not valid'));}
    } else{echo json_encode(array('type' => 'error4', 'message' => 'username already taken'));}
  } else{echo json_encode(array('type' => 'error5', 'message' => 'username must be min 2 characters long'));}
} else{echo json_encode(array('type' => 'error6', 'message' => 'empty fields'));}