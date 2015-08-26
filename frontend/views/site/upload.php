<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($modelUpload, 'imageFile')->fileInput() ?>

<?= Html::submitButton('Change', ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>

<?php ActiveForm::end() ?>