<?
echo 'help';
session_start();
include 'config.php';

if(isset($_SESSION['logged']) && $_SESSION['logged'] === true){
  echo '0';
  $author=$_SESSION['id'];
  $suite=$_POST['suite'];
  $story=$_POST['story_id'];

  $reqSeeSuite=$sql_connection->prepare("SELECT COUNT(*) AS story_count FROM suite WHERE post_id = :post_id");
  $reqSeeSuite->bindValue(':post_id', $story);
  $reqSeeSuite->execute();
  $resSeeSuite=$reqSeeSuite->fetch(PDO::FETCH_ASSOC);
  echo 'start';
  if($resSeeSuite['story_count'] == 0){
    echo '1';
  $reqAddSuite=$sql_connection->prepare("INSERT INTO suite (content, dateposted, post_id, chapter) VALUES (:content, NOW(), :post_id, 1)");
  $reqAddSuite->bindValue(':content', $suite);
  $reqAddSuite->bindValue(':post_id', $story);
  $reqAddSuite->execute();
  echo '2';
}
else{
  echo '3';
  $reqSeeSuit=$sql_connection->prepare("INSERT INTO suite (content, dateposted, post_id, chapter) VALUES (:content, NOW(), :post_id, chapter+1)");
  $reqSeeSuit->bindValue(':content', $suite);
  $reqSeeSuit->bindValue(':post_id', $story);
  $reqSeeSuit->execute();

  echo '4';
  $reqViews=$sql_connection->prepare("UPDATE suite SET chapter=chapter+1 WHERE post_id= :post_id ORDER BY id DESC LIMIT 1");
  $reqViews->bindValue(':post_id', $story);
  $reqViews->execute();
  echo '5';
}

echo 'test';
print_r($resSeeSuite);

}

?>