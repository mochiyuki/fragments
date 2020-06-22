<?
include 'config.php';
$reqCustomers=$sql_connection->prepare("SELECT * FROM members WHERE username LIKE :keyword");
$reqCustomers->bindValue(':keyword', '%'.$_POST['keyword'].'%');
$reqCustomers->execute();

$customers=$reqCustomers->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($customers);

?>