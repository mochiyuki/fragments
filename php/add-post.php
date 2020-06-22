<?
session_start();
include 'config.php';

if(isset($_SESSION['logged']) && $_SESSION['logged'] === true){
  $author=$_SESSION['id'];
  $title=$_POST['title'];
  $content=$_POST['content'];

  $reqAddPost=$sql_connection->prepare("INSERT INTO post (title, content, author, dateposted) VALUES (:title, :content, :author, NOW())");
  $reqAddPost->bindValue(':title', $title);
  $reqAddPost->bindValue(':content', $content);
  $reqAddPost->bindValue(':author', $author);
  $reqAddPost->execute();
}
?>