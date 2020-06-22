<?
include 'php/config.php';

if(isset($_GET['email'])&& isset($_GET['token'])){
  $email=$_GET['email'];
  $token=$_GET['token'];
  $reqMember=$sql_connection->prepare("SELECT COUNT(*) AS members_count FROM members WHERE email = :email AND token = :token");
  $reqMember->bindValue(':email', $email);
  $reqMember->bindValue(':token', $token);
  $reqMember->execute();
  $resMember=$reqMember->fetch(PDO::FETCH_ASSOC);
  //echo '1';
  if($resMember['members_count'] == 1){
    $reqActive=$sql_connection->prepare("SELECT active FROM members");
    $reqActive->execute();
    $resActive=$reqActive->fetch(PDO::FETCH_ASSOC);
    if($resActive['active'] == 1){
      $randomPass='kittenslovephp12345';
      $randomPass=str_shuffle($randomPass);
      $randomPass=substr($randomPass, 0, 10);
      echo 'your temporary password is <b>'.$randomPass.'</b> please login to change it to a safer password';
        $reqChange=$sql_connection->prepare("UPDATE members SET newpass = :newpass WHERE email = :email AND token = :token");
        $reqChange->bindValue(':newpass', $randomPass);
        $reqChange->bindValue(':email', $email);
        $reqChange->bindValue(':token', $token);
        $reqChange->execute();
    } else{echo 'account not activated';}
  } else{echo 'you are not in our database';}
}
?>