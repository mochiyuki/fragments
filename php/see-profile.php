<?
session_start();
include 'config.php';

$memberId=$_POST['memberId'];

$reqView=$sql_connection->prepare("SELECT * FROM members WHERE username = :username");
$reqView->bindValue(':username', $memberId);
$reqView->execute();
$resView=$reqView->fetchAll(PDO::FETCH_ASSOC);
?>

<?
foreach($resView as $val){
?>
<a class="back-to-home" href="<? echo $page='home'; ?>"> Return to homepage </a>
<div class="profile-format">
  <h2 class="member-username"> <? echo $val['username']; ?> </h2>
  <h4 class="member-email"> <? echo $val['email']; ?> </h4>
  <div class="profile-img"> <? echo '<img width="600" height="400" src="'.$val['profileimg'].'">'; ?> </div>
</div>
<?
}
?>

<?
$memberIdd=$val['id'];
$reqViewPost=$sql_connection->prepare("SELECT * FROM post WHERE author = :id");
$reqViewPost->bindValue(':id', $memberIdd);
$reqViewPost->execute();
$resViewPost=$reqViewPost->fetchAll(PDO::FETCH_ASSOC);
?>
<?
foreach($resViewPost as $val){
?>
<div class="list-format">
  <button class="show-story" story-id="<? echo $val['title']; ?>"> <? echo $val['title']; ?> </button>
</div>
<?
}
?>

<script>
$('.show-story').on('click', function(event){
  var storyId = $(this).attr('story-id');
  event.preventDefault();
  //console.log(storyId);
  $.ajax({
    type:'POST',
    url:'php/show-story.php',
    data:{storyId:storyId}
  })
  .done(function(data){
    $('.test3').html(data);
  });
});
</script>