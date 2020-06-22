<?
	include 'php/config.php';
//start de la session
	session_start();
	if(!isset($_SESSION['logged'])) $_SESSION['logged'] = false;
//if (isset($_SESSION['logged']) && $_SESSION['logged'] === true)
//si utilisateur est loggé il peut aller sur les pages si elles existent, si pas loggé, il va sur la page account ou il y a le login et register
if(isset($_GET['page'])) {
$page = $_GET['page'];}
else { $page = 'home'; }

if ($_SESSION['logged'] !== true) {
    $page = 'account';
	}

	if(!file_exists('content/'.$page.'.php')) {
		include('content/404.php');
		exit;
	}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title> Fragments App </title>
  <link rel="stylesheet" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
  <div id="wrapper">
    <?
      include('content/'.$page.'.php');
    ?>
  </div>

  <footer>
    <p> @2018 Fragments App </p>
  </footer>

<script src="main.js"></script>
</body>

</html>