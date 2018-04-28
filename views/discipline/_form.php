<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\modules\schedule\widgets\NameWithColorInput;

/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityDiscipline */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-discipline-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= NameWithColorInput::widget(['model' => $model, 'form' => $form, 'nameField' => 'name']); ?>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'formTeachers')->widget(\kartik\select2\Select2::classname(), [
        'data' => $model->getTeacherList(),
        'options' => ['placeholder' => 'Выберите преподавателей ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ])->label('Выберите преподавателей, преподающие данную дисциплину');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('UniversityModule.base', 'Create') : Yii::t('UniversityModule.base', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
