<?
if(isset($_POST['myform'])){
$img=$_FILES['myfile'];
//print_r($img);
$imgName=$_FILES['myfile']['name'];
$imgTmpName=$_FILES['myfile']['tmp_name'];
$imgSize=$_FILES['myfile']['size'];
$imgError=$_FILES['myfile']['error'];
$imgType=$_FILES['myfile']['type'];
//juste pour avoir extension, ce qui est après le . càd jpeg
$imgExt=explode('.', $imgName);
//print_r($imgExt);

//parfois ce sont des extensions en maj comme JPEG, cette fonction php permet de le transformer en min
$imgActualExt=strtolower(end($imgExt)); //pour la 2ème partie de $imgExt
//echo($imgActualExt);
$validExt=array('jpg', 'jpeg', 'png');
$validType=array('image/gif', 'image/jpg', 'image/jpeg', 'image/png');
//condition pour vérifier si $imgActualExt fait partie de $validExt, si string existe
if(in_array($imgActualExt, $validExt)){
  if(in_array($imgType, $validType)){
    if($imgError===0){//si on n'a pas d'erreur en upload l'image{
      if($imgSize<1000000){
        $imgBaseName = basename($img['name']);
        $name = explode('.', $imgBaseName)[0];
        $imgLocation='upload/'.$name.'.'.$imgActualExt;
        move_uploaded_file($imgTmpName, $imgLocation);
            $reqProfile=$sql_connection->prepare("UPDATE members SET profileimg = :profileimg WHERE id = :id");
            $reqProfile->bindValue(':profileimg', $imgLocation);
            $reqProfile->bindValue(':id', $_SESSION['id']);
            $reqProfile->execute();
      } else{echo 'your image excess allowed size';}
    } else{echo 'there was an error uploading your image';}
  } else{echo 'type not allowed';}
} else{echo 'only .jpg .jpeg and .png extensions are allowed';}
}

if(isset($_POST['change-myemail'])){
  $newEmail=$_POST['change-email'];
  if(filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
    //echo '4';
    //même requête pour vérifier que l'adresse email ne soit pas déjà utilisée
    $reqcheckEmail=$sql_connection->prepare("SELECT COUNT(*) AS email_addresses FROM members WHERE email = :email");
    $reqcheckEmail->bindValue(':email', $newEmail);
    $reqcheckEmail->execute();
    $emailUnavailable=$reqcheckEmail->fetch(PDO::FETCH_ASSOC);
    if($emailUnavailable['email_addresses'] == 0){

  $req=$sql_connection->prepare("UPDATE members SET email = :email WHERE id = :id");
  $req->bindValue(':email', $newEmail);
  $req->bindValue(':id', $_SESSION['id']);
  $req->execute();
} else{echo 'email already in use';}
} else{echo 'email not valid';}
}

if(isset($_POST['change-mypass'])){
  $newPassword=$_POST['change-pass'];
  $newPasswordver=$_POST['change-passver'];

  if($newPassword === $newPasswordver){
    //echo '6';
    //créer une clé de hashage pour le mot de passe
    $newHashed_password=password_hash($newPassword, PASSWORD_DEFAULT);
    //si toutes les conditions sont respectées alors ajouter le nouveau utilisateur
    $reqChangepass=$sql_connection->prepare("UPDATE members SET password = :password, passwordver = :passwordver WHERE id = :id");
    $reqChangepass->bindValue(':password', $newHashed_password);
    $reqChangepass->bindValue(':passwordver', $newHashed_password);
    $reqChangepass->bindValue(':id', $_SESSION['id']);
    $reqChangepass->execute();
    //echo json_encode(array('type' => 'success', 'message' => 'ok'));
  } else{echo json_encode(array('type' => 'error1', 'message' => 'pass do not match'));}
}

if(isset($_POST['add-birthday'])){
  $selectedMonth=$_POST['selected-month'];
  $selectedDay=$_POST['selected-day'];

  if(!checkdate($selectedMonth, $selectedDay, 2016)){
   echo 'not valid';
} else{
  $birthday = '0000'."-". $_POST['selected-month']."-".$_POST['selected-day'];
  $reqAddbirthday=$sql_connection->prepare("UPDATE members SET birthday = :birthday WHERE id = :id");
  $reqAddbirthday->bindValue(':birthday', $birthday);
  $reqAddbirthday->bindValue(':id', $_SESSION['id']);
  $reqAddbirthday->execute();
  echo 'updated';
  }
}
?>

<div id="modifyProfile">

  <a class="back-to-home" href="<? echo $page='home'; ?>"> Return to homepage </a>

  <div class="update-img">
  <form enctype="multipart/form-data" action="myprofile" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
    <input type="file" name="myfile">
    <input class="upload-img" type="submit" name="myform" value="Upload image">
  </form>
</div>

<div class="update-email">
  <form action="myprofile" method="POST">
    <label> Change E-mail </label> <br>
    <input type="text" name="change-email" placeholder="New e-mail"> <br>
    <button type="submit" class="change-email" name="change-myemail"> Change e-mail </button>
  </form>
</div>

  <div class="update-pass">
  <form action="myprofile" method="POST">
    <label> Change Password </label> <br>
    <input type="password" name="change-pass" placeholder="Type new password"> <br>
    <input type="password" name="change-passver" placeholder="Confirm new password"> <br>
    <button type="submit" class="change-mypass" name="change-mypass"> Change password </button>
  </form>
</div>

<div class="update-birthday">
<form action="myprofile" method="POST">
<select class="selected-month" name="selected-month">
  <option value="1">January</option>
  <option value="2">February</option>
  <option value="3">March</option>
  <option value="4">April</option>
  <option value="5">May</option>
  <option value="6">June</option>
  <option value="7">July</option>
  <option value="8">August</option>
  <option value="9">September</option>
  <option value="10">October</option>
  <option value="11">November</option>
  <option value="12">December</option>
</select>
<select class="selected-day" name="selected-day">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
</select>

<button type="submit" class="add-birthday" name="add-birthday"> Add </button>
</form>
</div>

<div class="show-img">
  <?
  $reqUsers=$sql_connection->prepare("SELECT profileimg FROM members WHERE id = :id");
  $reqUsers->bindValue(':id', $_SESSION['id']);
  $reqUsers->execute();
  $users=$reqUsers->fetch(PDO::FETCH_ASSOC);
  if($users['profileimg'] !== null){
      ?>
      <div class="profile-img"> <? echo '<img src="'.$users['profileimg'].'">'; ?> </div>
      <?
    }
  ?>

  <?
  if($users['profileimg'] == null){
    $newPath='upload/myPost.jpg';
    $reqProfile=$sql_connection->prepare("UPDATE members SET profileimg = :profileimg WHERE id = :id");
    $reqProfile->bindValue(':profileimg', $newPath);
    $reqProfile->bindValue(':id', $_SESSION['id']);
    $reqProfile->execute();
  }
?>
</div>
</div>