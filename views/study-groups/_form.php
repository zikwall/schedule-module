<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityStudyGroups */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-study-groups-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($model, 'faculty_id')->dropDownList(\humhub\modules\faculties\models\UniversityFaculties::getList(), ['id' => 'faculty-id', 'data-ui-select2' => '']) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'profile_id')->dropDownList(\humhub\modules\specialities\models\UniversitySpecialitiesProfiles::getList(), ['id' => 'profile-id', 'data-ui-select2' => '']) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'course_id')->dropDownList(\humhub\modules\university\models\UniversityStudyCourses::getList(), ['id' => 'course-id', 'data-ui-select2' => '']) ?>
    </div>


    <?= \humhub\modules\schedule\widgets\NameWithColorInput::widget(['model' => $model, 'form' => $form, 'nameField' => 'displayName']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('имя без пробелов, пример: эк_51_14') ?>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->input('date') ?>

    <?= humhub\modules\space\widgets\SpacePickerField::widget([
        'form' => $form,
        'model' => $model,
        'attribute' => 'assigneeSpace',
        'maxSelection' => 1,
        'minInput' => 2,
    ])?>

    <div class="form-group">
        <?= $form->field($model, 'desc')->textarea([
            'class' => 'form-control',
            'id' => 'newDesc', 'rows' => '4',
            'placeholder' => 'Описание...'
        ]); ?>
        <?= humhub\widgets\MarkdownEditor::widget(['fieldId' => 'newDesc']); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('ScheduleModule.base', 'Create') : Yii::t('ScheduleModule.base', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
