<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\search\ScheduleWeeklyType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-weekly-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'en_name') ?>

    <?= $form->field($model, 'color') ?>

    <?= $form->field($model, 'sign') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('UniversityModule.base', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('UniversityModule.base', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
