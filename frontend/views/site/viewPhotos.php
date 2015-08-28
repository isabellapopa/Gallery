<?php
foreach ($albums as $album ){
        ?>
<div class="container">
    <h1>Album title: <?php echo $album['name']; ?> </h1>
</div>

  <?php
      foreach ($photos as $photo ){
          if($album['id'] == $photo['albumId']) {
              ?>
              <img src="http://shop.dev/images/<?php echo $photo['photoName']; ?>" alt="" class="img-thumbnail"> <br>
              <strong> <?php echo $photo['description']; ?> </strong> <br>
              <strong> <?php echo $photo['tag']; ?> </strong> <br>
              <?php
          }
    }
}
?>