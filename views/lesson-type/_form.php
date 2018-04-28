<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\modules\schedule\widgets\NameWithColorInput;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleLessonType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-lesson-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= NameWithColorInput::widget(['model' => $model, 'form' => $form, 'nameField' => 'name']); ?>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= $form->field($model, 'desc')->textarea([
            'class' => 'form-control',
            'id' => 'newDesc', 'rows' => '4',
            'placeholder' => 'Описание...'
        ]); ?>
        <?= humhub\widgets\MarkdownEditor::widget(['fieldId' => 'newDesc']); ?>
    </div>

    <?= $form->field($model, 'sign')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('UniversityModule.base', 'Create') : Yii::t('UniversityModule.base', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
