<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\search\ScheduleSchedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-schedule-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'day_id') ?>

    <?= $form->field($model, 'couple_id') ?>

    <?= $form->field($model, 'teacher_id') ?>

    <?= $form->field($model, 'discipline_id') ?>

    <?php // echo $form->field($model, 'study_group_id') ?>

    <?php // echo $form->field($model, 'type_id') ?>

    <?php // echo $form->field($model, 'en_name') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('ScheduleModule.base', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('ScheduleModule.base', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>