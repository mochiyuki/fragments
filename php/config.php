<?
date_default_timezone_set('Europe/Paris');
$host='localhost';
$username='root';
$password='';
$dbname='bdd';
$options=array(
  PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8",
  PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
try{$sql_connection=new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password, $options);}
catch(PDOException $e){echo 'Connection failed:'.$e->getMessage();}
?>