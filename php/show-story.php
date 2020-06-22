<?
session_start();
include 'config.php';

$story=$_POST['storyId'];

//echo $story;
$reqView=$sql_connection->prepare("SELECT * FROM post WHERE title = :id");
$reqView->bindValue(':id', $story);
$reqView->execute();
$resView=$reqView->fetchAll(PDO::FETCH_ASSOC);
?>

<?
foreach($resView as $val){
?>
  <? echo $val['title']; ?>
  <? echo $val['content']; ?>
<?
}
?>