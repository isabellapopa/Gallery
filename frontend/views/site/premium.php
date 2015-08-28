<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>


<div class="container">
    <h1>Premium Account</h1>
    <p>Username: <?php echo Yii::$app->user->identity->username ?> </p>
    <p>Email:  <?php echo Yii::$app->user->identity->email  ?> </p>
    <div class="premium-cont">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>
        <?php
        //$model['startDate'] = Yii::$app->formatter->format($model['startDate'], 'date');
        //$model['endDate'] = Yii::$app->formatter->format($model['endDate'], 'date'); ?>
            <?= $form->field($model, 'cardType',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-2',]])
                ->dropDownList(
                    $cardType,
                    ['prompt'=>'----------Choose a Name----------']
                )
            ?>

        <?= $form->field($model, 'yearAccountDisable',[
            'horizontalCssClasses' => [
                'wrapper' => 'col-sm-2',]])
            ->dropDownList(
                $years,
                ['prompt'=>'----------Choose a Name----------']
            )
        ?>
        <?= $form->field($model, 'monthAccountDisable',[
            'horizontalCssClasses' => [
                'wrapper' => 'col-sm-2',]])
            ->dropDownList(
                $month,
                ['prompt'=>'----------Choose a Name----------']
            )
        ?>

        <div class="form-group">
            <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>

