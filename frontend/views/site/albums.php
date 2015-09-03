<?php

use yii\helpers\Html;
?>

<?php
foreach ($albums as $album ){
    if($album['userId'] == Yii::$app->user->getId()) {
        ?>
        <div class="container">
            <h1>Album title: <?php echo $album['name']; ?> </h1>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <p><?php echo $album['description']; ?></p>

                <p><?php echo $album['numberPhotos']; ?></p>

                <p><?php echo $album['tag']; ?></p>
                <div style="color:#999;margin:1em 0">
                    Upload photos : <?= Html::a('Upload Photos', ['site/photo', 'albumId' => $album['id']]) ?>.
                    See your album photos :  <?= Html::a('Album Photos', ['site/view-photos']) ?>.
                </div>
            </div>
        </div>
        <?php
    }
}
?>




