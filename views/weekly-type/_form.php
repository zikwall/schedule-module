<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\modules\schedule\widgets\NameWithColorInput;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleWeeklyType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-weekly-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= NameWithColorInput::widget(['model' => $model, 'form' => $form, 'nameField' => 'name']); ?>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sign')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('UniversityModule.base', 'Create') : Yii::t('UniversityModule.base', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
