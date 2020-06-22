<?
  session_start();
  include 'php/config.php';
  //login.php pour valider que les champs ne soient pas vides, que le username existe et que le mot de passe match
  $username=trim($_POST['username']);
  $password=trim($_POST['password']);

  if(!empty($username) && !empty($password)){
    $reqCheckUsername=$sql_connection->prepare("SELECT COUNT(*) AS members_list FROM members WHERE username = :username");
    $reqCheckUsername->bindValue(':username', $username);
    $reqCheckUsername->execute();
    $usernameExists=$reqCheckUsername->fetch(PDO::FETCH_ASSOC);
    if($usernameExists['members_list'] == 1){
      $reqUser=$sql_connection->prepare("SELECT * FROM members WHERE username = :username");
      $reqUser->bindValue(':username', $username);
      $reqUser->execute();
      $user=$reqUser->fetch(PDO::FETCH_ASSOC);
      //$user['new-pass'] étant le mot de passe temporaire pour se logger, généré par le lien de mot de passe oublié
      if(password_verify($password, $user['password']) OR $password===$user['newpass']){
        if($user['active'] == 1){
          $_SESSION['logged']=true;
          $_SESSION['id']=$user['id'];
          $_SESSION['username']=$user['username'];
          $_SESSION['password']=$user['password'];
          echo json_encode(array('type' => 'success', 'message' => 'Logged'));
        } else{echo json_encode(array('type' => 'error1', 'message' => 'Account not activated'));}
      } else{echo json_encode(array('type' => 'error2', 'message' => 'Wrong password'));}
    } else{echo json_encode(array('type' => 'error3', 'message' => 'Account doesn\'t exist'));}
  } else{echo json_encode(array('type' => 'error4', 'message' => 'Empty field'));}
?>