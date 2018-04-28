<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\search\UniversityStudyGroups */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-study-groups-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'faculty_id') ?>

    <?= $form->field($model, 'profile_id') ?>

    <?= $form->field($model, 'course_id') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'displayName') ?>

    <?php // echo $form->field($model, 'en_name') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'color') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('ScheduleModule.base', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('ScheduleModule.base', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
