<div id="homepage">
<header>
  <div id="write">
      <a id="write-new" href="#openModal-new"> Write </a>
      <a id="write-continue" href="#openModal-continue"> Continue </a>
  </div>
  <div id="logo-mini">
    <a href="<? echo $page='home'; ?>"> <img src="1x/logo.png"></img></a>
  </div>
  <div id="settings">
    <div id="myprofile"><a href="<? echo $page='myprofile'; ?>"> My profile </a></div>
    <div id="logout"><a href="logout.php"> Log out </a></div>
  </div>
  <div id="search">
    <input id="searchbar" type="text" placeholder="search member">
    <ul id="search-list" style="background-color:white;"></ul>
    <button id="search-button"> SEARCH </button>
  </div>
  <div id="sort">
    <p id="sortby"> Sort by </p>
    <ul id="options">
      <li id="latest" class="active"><a href="#"> Latest </a></li>
      <li id="popular"><a href="#"> Popular </a></li>
      <li id="trending"><a href="#"> Trending </a></li>
    </ul>
  </div>
</header>

<div id="modal-search">
  <div id="modal-view"></div>
</div>

<!-- pour afficher tous les posts in latest -->
<div id="container">
  <?
  $reqView=$sql_connection->prepare("SELECT * FROM post ORDER BY id DESC");
  $reqView->execute();
  $resView=$reqView->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <?
  foreach($resView as $val){
    $longcontent= $val['content'];
    $shortcontent= substr($longcontent, 0, 200);
    $originalDate = $val['dateposted'];
    $newDate = date("F d Y", strtotime($originalDate));
  ?>
  <div class="post">
    <div class="post-content">
      <div class="story-title"> <? echo $val['title']; ?> </div>
      <div class="story-content"> <? echo $shortcontent; ?> </div>
      <h6 class="story-date"> Posted on <? echo $newDate; ?> </h6>
      <button data-id="<? echo $val['id']; ?>"><a href=".post-modal"> Read more </a></button>
      <?
      $memberUsername=$val['author'];
      $reqViewed=$sql_connection->prepare("SELECT username FROM members WHERE id = :id");
      $reqViewed->bindValue(':id', $memberUsername);
      $reqViewed->execute();
      $resViewed=$reqViewed->fetchAll(PDO::FETCH_ASSOC);

      foreach($resViewed as $val){
        ?>
        <a member-id="<? echo $val['username']; ?>" class="story-author"> By <? echo $val['username']; ?> </a>
        <?
      }
      ?>
    </div>
  </div>
  <?
  }
  ?>
</div>

<!-- pour afficher tous les posts in popular -->
<div id="container2">
  <?
  $reqView=$sql_connection->prepare("SELECT * FROM post ORDER BY value DESC");
  $reqView->execute();
  $resView=$reqView->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <?
  foreach($resView as $val){
    $longcontent= $val['content'];
    $shortcontent= substr($longcontent, 0, 200);
    $originalDate = $val['dateposted'];
    $newDate = date("F d Y", strtotime($originalDate));
  ?>
  <div class="post">
    <div class="post-content">
      <div class="story-title"> <? echo $val['title']; ?> </div>
      <div class="story-content"> <? echo $shortcontent; ?> </div>
      <h6 class="story-date"> Posted on <? echo $newDate; ?> </h6>
      <button data-id="<? echo $val['id']; ?>"><a href=".post-modal"> Read more </a></button>
      <?
      $memberUsername=$val['author'];
      $reqViewed=$sql_connection->prepare("SELECT username FROM members WHERE id = :id");
      $reqViewed->bindValue(':id', $memberUsername);
      $reqViewed->execute();
      $resViewed=$reqViewed->fetchAll(PDO::FETCH_ASSOC);

      foreach($resViewed as $val){
        ?>
        <a member-id="<? echo $val['username']; ?>" class="story-author"> By <? echo $val['username']; ?> </a>
        <?
      }
      ?>
    </div>
  </div>
  <?
  }
  ?>
</div>

<!-- pour afficher tous les posts in trending -->
<div id="container3">
  <?
  $reqView=$sql_connection->prepare("SELECT * FROM post WHERE dateposted > DATE_SUB(NOW(), INTERVAL 24 HOUR) ORDER BY value DESC");
  $reqView->execute();
  $resView=$reqView->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <?
  foreach($resView as $val){
    $longcontent= $val['content'];
    $shortcontent= substr($longcontent, 0, 200);
    $originalDate = $val['dateposted'];
    $newDate = date("F d Y", strtotime($originalDate));
  ?>
  <div class="post">
    <div class="post-content">
      <div class="story-title"> <? echo $val['title']; ?> </div>
      <div class="story-content"> <? echo $shortcontent; ?> </div>
      <h6 class="story-date"> Posted on <? echo $newDate; ?> </h6>
      <button data-id="<? echo $val['id']; ?>"><a href=".post-modal"> Read more </a></button>
      <?
      $memberUsername=$val['author'];
      $reqViewed=$sql_connection->prepare("SELECT username FROM members WHERE id = :id");
      $reqViewed->bindValue(':id', $memberUsername);
      $reqViewed->execute();
      $resViewed=$reqViewed->fetchAll(PDO::FETCH_ASSOC);

      foreach($resViewed as $val){
        ?>
        <a member-id="<? echo $val['username']; ?>" class="story-author"> By <? echo $val['username']; ?> </a>
        <?
      }
      ?>
    </div>
  </div>
  <?
  }
  ?>
</div>

<!-- lorsqu'on click sur un post -->
<div class="post-modal">
  <button class="closePost"> Close </button>
  <div class="test1"></div>
  <div class="test2"></div>
</div>
<!-- pour poster -->
<div id="openModal-new">
  <div class="modal-new">
    <p> Please don't leave any empty field </p>
  <button id="closeModal"> X </button>
  <input class="title" name="title" placeholder="Title">
  <textarea class="content" name="content" rows="10"></textarea>
  <button type="submit" class="send-new" name="send-new"> Post </button>
  </div>
</div>

<div id="openModal-continue">
  <ul>
    <?
    $reqList=$sql_connection->prepare("SELECT * FROM post WHERE author = :id");
    $reqList->bindValue(':id', $_SESSION['id']);
    $reqList->execute();
    $resList=$reqList->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <?
    foreach($resList as $val){
      ?>
      <li> <input type="radio" class="story_id" name="story_id" value="<? echo $val['id']; ?>"> <? echo $val['title']; ?> </input> </li>
      <?
    }
    ?>
  </ul>
    <form class="suite-form" action="" method="POST">
      <textarea class="suite" name="suite"></textarea>
      <input type="hidden" class="story_id" name="story_id" value="<? echo $val['id']; ?>">
      <button type="submit" class="send-continue" name="send-continue"> Post suite </button>
    </form>
</div>

<div class="member-profile">
  <div class="test3"></div>
</div>

</div>

<script type="text/javascript">

$(".suite-form").submit(function(event) {
  event.preventDefault();
  var data={
    story_id:$('input[name="story_id"]:checked').val(),
    //story_id:$(this).find('.story_id').attr('story-id'),
    suite:$(this).find('.suite').val()
  }
  //console.log(data);
  $.ajax({
    type:'POST',
    url:'php/add-suite.php',
    data:data
  })
  .done(function(data){
    console.log(data);
});
});

</script>