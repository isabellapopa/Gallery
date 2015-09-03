<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use kato\DropZone;
$this->title = 'Photos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    if(Yii::$app->user->hasRole('freeUser')){

    echo DropZone::widget(
        [
            'options' => [
                'maxFiles' => '10',
                'maxFilesize' => '2',
                'clientEvents' => [
                    'complete' => "function(file){console.log(file)}",
                    'removedfile' => "function(file){alert(file.name + ' is removed')}"
                ]
            ],
            'uploadUrl' => \yii\helpers\Url::to(['photo', 'albumId' => $albumId])
        ]);
    }
    if(!Yii::$app->user->hasRole('freeUser')) {
        echo DropZone::widget(
            [
                'options' => [
                    'maxFilesize' => '2',
                    'clientEvents' => [
                        'complete' => "function(file){console.log(file)}",
                        'removedfile' => "function(file){alert(file.name + ' is removed')}"
                    ]
                ],
                'uploadUrl' => \yii\helpers\Url::to(['photo', 'albumId' => $albumId])
            ]);
    }
    ?>
</div>