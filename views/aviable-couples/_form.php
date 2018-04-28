<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\modules\schedule\widgets\NameWithColorInput;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleAviableCouple */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-aviable-couple-form">

    <?php $form = ActiveForm::begin(); ?>

    <?/*= $form->field($model, 'identity')->textInput(['maxlength' => true]) */?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Код - названия используется в качестве ключа') ?>

    <?= NameWithColorInput::widget(['model' => $model, 'form' => $form, 'nameField' => 'displayName'])?>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= $form->field($model, 'desc')->textarea([
            'class' => 'form-control',
            'id' => 'newDesc', 'rows' => '4',
            'placeholder' => 'Описание...'
        ]); ?>
        <?= humhub\widgets\MarkdownEditor::widget(['fieldId' => 'newDesc']); ?>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'lessonStart')->textInput()->input('time') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'lessonEnd')->textInput()->input('time') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('ScheduleModule.base', 'Create') : Yii::t('ScheduleModule.base', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>