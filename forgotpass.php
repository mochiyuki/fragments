<?
include 'php/config.php';

if(isset($_POST['forgotpass'])){
  $email=$_POST['email'];
  if(!empty($email)){
    $reqcheckEmail=$sql_connection->prepare("SELECT COUNT(*) AS email_addresses FROM members WHERE email = :email");
    $reqcheckEmail->bindValue(':email', $email);
    $reqcheckEmail->execute();
    $resEmail=$reqcheckEmail->fetch(PDO::FETCH_ASSOC);
    //voir dans la bdd si email est lié à un compte, si oui alors on génére (grâce à ces deux fonctions ci dessus) une chaîne de caractères pour créer un mot de passe temporaire
    if($resEmail['email_addresses'] > 0){
      $randomStr='kittenslovephp123';
      $randomStr=str_shuffle($randomStr);
      $randomStr=substr($randomStr, 0, 10);
      $subject="Reset password";
      $message="Click this link to reset password http://localhost/projet/resetpass.php?token=$randomStr&email=$email";
      $mailTo=$_POST['email'];
      mail($mailTo, $subject, $message);

      $reqToken=$sql_connection->prepare("UPDATE members SET token = :token WHERE email= :email");
      $reqToken->bindValue(':token', $randomStr);
      $reqToken->bindValue(':email', $email);
      $reqToken->execute();

    } else{echo 'Email isn\'t in our database';}
  } else{echo 'Write your email address';}
}
?>

<form action="forgotpass.php" method="POST">
  <input type="text" name="email">
  <button name="forgotpass"> Recover </button>
</form>