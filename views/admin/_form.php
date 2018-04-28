<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleSchedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-schedule-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'errorOptions' => [
                'encode' => false,
                'class' => 'help-block'
            ],
        ]
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'day_id')->dropDownList($model->getDayList(), ['id' => 'day-id', 'data-ui-select2' => '']) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'couple_id')->dropDownList($model->getCoupleList(), ['id' => 'couple-id', 'data-ui-select2' => '']) ?>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <?= $form->field($model, 'teacher_id')->dropDownList($model->getTeacherList(), [
                    'id' => 'teacher-id',
                    'data-ui-select2' => '',
                    'prompt'=>'-Выберите преподавателя-',
                    'onchange'=>'
				    $.post( "'.Yii::$app->urlManager->createUrl('/schedule/admin/discipline?id=').'"+$(this).val(), function( data ) {
				        $( "select#discipline-id" ).html( data );
				    });',
                    'errorOptions' => [
                        'encode' => false,
                        'class' => 'help-block'
                    ],
                ]) ?>
            </div>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'joinCouples')->checkbox()->label('Объединение') ?>
        </div>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'discipline_id')->widget(\kartik\depdrop\DepDrop::classname(), [
            'data' => $model->getDisciplineList($model->teacher_id),
            'options'=> [
                'id' => 'discipline-id'
            ],
            'pluginOptions' => [
                'depends'=>['teacher-id'], // the id for cat attribute
                'placeholder' => 'Select...',
                'url'=>  \yii\helpers\Url::to(['/schedule/admin/sub-discipline'])
            ]
        ]);
        ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'classroom_id')->dropDownList($model->getClassroomList(), ['id' => 'classroom-id', 'data-ui-select2' => '']) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'study_group_id')->dropDownList($model->getStudyGroupList($faculty->id, $course->id), ['id' => 'group-id', 'data-ui-select2' => '']) ?>
    </div>

    <a class="dropdown-toggle"
       onclick="$('#subGroupField').slideToggle('fast');$('#subGroupField').focus();return false;"
       data-toggle="dropdown" href="#"><i class="fa fa-angle-down fa-fw"></i>
    </a>

    <div id="subGroupField" class="form-group" style="display:none;">
        <hr>
        <?= $form->field($model, 'formSubgroup')->dropDownList(\humhub\modules\schedule\models\ScheduleSubgroups::getList(), ['id' => 'subGroup-id', 'data-ui-select2' => '', 'prompt'=>'-Выберите подгруппу-',]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'weekly_type_id')->dropDownList($model->getWeeklyTypeList(), ['id' => 'weeklytype-id', 'data-ui-select2' => '']) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'type_id')->dropDownList($model->getTypeList(), ['id' => 'type-id', 'data-ui-select2' => '']) ?>
    </div>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= $form->field($model, 'desc')->textarea([
                'class' => 'form-control',
                'id' => 'newDesc', 'rows' => '4',
                'placeholder' => 'Описание...'
        ]); ?>
        <?= humhub\widgets\MarkdownEditor::widget(['fieldId' => 'newDesc']); ?>
    </div>

    <?= $form->field($model, 'notifyStudents')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('ScheduleModule.base', 'Create') : Yii::t('ScheduleModule.base', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'data-ui-loader'=>'']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>