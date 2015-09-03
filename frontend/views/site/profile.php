<?php
 use yii\helpers\Html;
$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
?>

        <div class="container">
            <p>Username: <?php echo Yii::$app->user->identity->username ?> </p>
            <p>Email:  <?php echo Yii::$app->user->identity->email  ?> </p>
        </div>
    <div style="color:#999;margin:1em 0">
       Profile Picture : <?php echo Html::img('/images/profilePicture/'. Yii::$app->user->identity->photoName , ['width'=>'100'], ['height'=>'100']); ?>
        </div>
