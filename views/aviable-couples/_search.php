<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\search\ScheduleAviableCouple */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-aviable-couple-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'identity') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'en_name') ?>

    <?= $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'lessonStart') ?>

    <?php // echo $form->field($model, 'lessonEnd') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('ScheduleModule.base', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('ScheduleModule.base', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>