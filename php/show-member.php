<?
session_start();
include 'config.php';

$member=$_POST['member'];

//echo $member;
$reqView=$sql_connection->prepare("SELECT * FROM members WHERE id = :id");
$reqView->bindValue(':id', $member);
$reqView->execute();
$resView=$reqView->fetchAll(PDO::FETCH_ASSOC);
?>

<?
foreach($resView as $val){
?>
<a href="<? echo $page='home'; ?>"> Return to homepage </a>
<div class="profile-format">
  <? echo $val['username']; ?>
  <? echo $val['email']; ?>
  <div class="profile-img"> <? echo '<img width="600" height="400" src="'.$val['profileimg'].'">'; ?> </div>
</div>
<?
}
?>

<?
$reqView=$sql_connection->prepare("SELECT * FROM post WHERE author = :id");
$reqView->bindValue(':id', $member);
$reqView->execute();
$resView=$reqView->fetchAll(PDO::FETCH_ASSOC);
?>

<?
foreach($resView as $val){
?>
<div class="list-format">
  <h5> <? echo $val['title']; ?> </h5>
</div>
<?
}
?>