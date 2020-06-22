<?
include 'php/config.php';

if(isset($_GET['confirm'])){
$confirm=$_GET['confirm'];

$reqCheckConfirm=$sql_connection->prepare("SELECT COUNT(*) AS members_count FROM members WHERE confirmkey= :confirmkey");
$reqCheckConfirm->bindValue(':confirmkey', $confirm);
$reqCheckConfirm->execute();

$confirmKeyExists=$reqCheckConfirm->fetch(PDO::FETCH_ASSOC);

if($confirmKeyExists['members_count'] == 1){
  $confirmUser=$sql_connection->prepare("UPDATE members SET active = 1 WHERE confirmkey= :confirmkey");
  $confirmUser->bindValue(':confirmkey', $confirm);
  $confirmUser->execute();
}
}
?>

<h1> welcome! </h1>

<a href="<? echo $page='account'; ?>"> please login </a>