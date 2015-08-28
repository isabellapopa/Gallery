<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Create New Album';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-album">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>

            <?= $form->field($model, 'name') ?>

            <?= $form->field($model,'description') ?>

            <?= $form->field($model, 'tag')?>

            <div class="form-group">
                <?= Html::submitButton('Create Album', ['class' => 'btn btn-primary', 'name' => 'createAlbum-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
