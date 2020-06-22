<?
session_start();
include 'config.php';

$postId=$_POST['postId'];

$reqViews=$sql_connection->prepare("UPDATE post SET value=value+1 WHERE id= :id");
$reqViews->bindValue(':id', $postId);
$reqViews->execute();

$reqView=$sql_connection->prepare("SELECT * FROM post WHERE id = :id");
$reqView->bindValue(':id', $postId);
$reqView->execute();
$resView=$reqView->fetchAll(PDO::FETCH_ASSOC);
?>

<?
foreach($resView as $val){
?>
<div class="post">
  <div class="post-content">
    <div class="story-title"> <? echo $val['title']; ?> </div>
    <div class="story-content"> <? echo $val['content']; ?> </div>
  </div>
</div>

<?
$postIdComments=$val['id'];
//echo $postIdComments;
?>
<form class="comment-form" action="" method="POST">
  <textarea class="message" name="message" placeholder="Write your comment"></textarea> <br>
  <input type="hidden" class="post_id" name="post_id" value="<? echo $val['id']; ?>">
  <button type="submit"> Send comment </button>
</form>
<?

$reqViewComments=$sql_connection->prepare("SELECT * FROM comments WHERE post_id = :id");
$reqViewComments->bindValue(':id', $postIdComments);
$reqViewComments->execute();
$resViewComments=$reqViewComments->fetchAll(PDO::FETCH_ASSOC);
//print_r($resViewComments);
?>

<?
foreach($resViewComments as $val){
  ?>
  <div class="comment-container">
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
?>
</div>
<?
}
}
?>

<script type="text/javascript">
$(".comment-form").submit(function(event) {
  event.preventDefault();
  var data={
    post_id:$(this).find('.post_id').val(),
    message:$(this).find('.message').val()
  }

  $.ajax({
    type:'POST',
    url:'php/save-comments.php',
    data:data
  })
  .done(function(data){
    $('.test2').html(data);
  });
});

</script>