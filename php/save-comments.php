<?
session_start();
include 'config.php';

$post_id=$_POST['post_id'];
$message=$_POST['message'];
$id=$_SESSION['id'];
//echo $post_id;
//echo $message;
?>
<?
$reqAddComment=$sql_connection->prepare("INSERT INTO comments (message, post_id, member_id) VALUES (:message, :post_id, :member_id)");
$reqAddComment->bindValue(':message', $message);
$reqAddComment->bindValue(':post_id', $post_id);
$reqAddComment->bindValue(':member_id', $id);
$reqAddComment->execute();
?>
<?
$reqViewComment=$sql_connection->prepare("SELECT * FROM comments WHERE post_id = :post_id ORDER BY id DESC LIMIT 1");
$reqViewComment->bindValue(':post_id', $post_id);
$reqViewComment->execute();
$resViewComment=$reqViewComment->fetchAll(PDO::FETCH_ASSOC);
//print_r($resViewComment);
?>
<div class="comment-container">
<?
//echo json_encode($resViewComment);

foreach($resViewComment as $val){
?>
<h4 class="comment-message"> <? echo $val['message']; ?> </h4>
<?
$memberUsername=$val['member_id'];
$reqViewed=$sql_connection->prepare("SELECT username FROM members WHERE id = :id");
$reqViewed->bindValue(':id', $memberUsername);
$reqViewed->execute();
$resViewed=$reqViewed->fetchAll(PDO::FETCH_ASSOC);

foreach($resViewed as $val){
  ?>
  <h6 class="comment-author"> by <? echo $val['username']; ?> </h6>
  <?
}
}
?>
</div>