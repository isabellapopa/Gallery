<?php

use yii\grid\GridView;
?>
<?php
foreach ($albums as $album ){
        ?>
<div class="container">
    <?php if($album['userId']== Yii::$app->user->id){?>
    <h1>Album title: <?php echo $album['name']; ?> </h1>
        <?php } ?>
</div>

  <?php
      foreach ($photos as $photo ){
          if($photo['userId'] == Yii::$app->user->id){
              if($album['id'] == $photo['albumId']) {
                  ?>
                  <img src="http://gallery.dev/images/<?php echo $photo['photoName']; ?>" alt="" class="img-thumbnail"> <br>
                  <?php
              }
          }

    }
}

?>