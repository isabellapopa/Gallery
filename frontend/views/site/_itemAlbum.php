<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;

/**@var \common\models\Albums $model */

?>

    <div class="container">
        <h1><?php echo $model->name; ?></h1>

        <div class="row-fluid">
            <?php if ($model->photos) { ?>
            <?php foreach ($model->photos as $photo) { ?>
            <img src="http://gallery.dev/images/<?php echo $photo->photoName; ?>" alt="" class="img-thumbnail"> <br>
            <?php if (!$photo->likedAlready()) { ?>
            <a href="javascript:;" class="like-photo-btn" data-id="<?php echo $photo->id; ?>">like</a>
            <?php } else{ ?>
            <span class="test">liked</span>
            <?php }?>
            <?php $form = ActiveForm::begin(['action'=>'/site/save-comment', 'options' => ['data-pjax' => true]]); ?>
            <input type="hidden" name="photoId" value="<?php echo $photo->id; ?>" />
            <?= $form->field(new \common\models\Comment(), 'commentText')->textInput(['maxlength' => 200]) ?>
            <div class="form-group">
                <?= Html::submitButton('Add', ['class' => 'commentBtn', 'name' => 'createComment-button']) ?>
            <?php ActiveForm::end(); ?>
                </div>
        </div>
        <?php } ?>
        <?php } ?>
    </div>


<?php
$js = <<<JS
    $(function(){
        $('body').on('click', '.like-photo-btn', function(e) {
           $.get("/site/like?photoId=" + $(this).attr('data-id'), function (data) {
                });
               $("#test").val("liked");
        });
    });
JS;
$this->registerJs($js, View::POS_END, 'my-options');
$redirect = <<<JS

    $(function(){
        $('body').on('click', '.commentBtn',function(e){
            window.location.assign(" http://gallery.dev/site/gallery " );
            });
    });

JS;
$this->registerJS($redirect,View::POS_END,'my-options');