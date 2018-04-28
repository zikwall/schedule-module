<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityTeachers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-teachers-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($model, 'user_id')->dropDownList($model->getUserList(), ['id' => 'user-id', 'data-ui-select2' => ''])->label('Выберите пользователя в системе') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'post_id')->dropDownList($model->getPostList(), ['id' => 'post-id', 'data-ui-select2' => ''])->label('Должность') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'science_id')->dropDownList($model->getScienceList(), ['id' => 'science-id', 'data-ui-select2' => ''])->label('Научная степень') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'chair_id')->dropDownList($model->getChairList(), ['id' => 'chair-id', 'data-ui-select2' => ''])->label('Кафедра') ?>
    </div>

    <?/*= $form->field($model, 'formDisciplines')
        ->dropDownList($model->getDisciplineList(),
            ['text' => 'Please select', 'multiple' => true]
        ); */?>

    <?= $form->field($model, 'formDisciplines')->widget(\kartik\select2\Select2::classname(), [
        'data' => $model->getDisciplineList(),
        'options' => ['placeholder' => 'Выберите предметы ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ])->label('Выберите дисциплины, которые преподает');
    ?>

    <div class="form-group">
        <?= $form->field($model, 'story')->textarea([
            'class' => 'form-control',
            'id' => 'newStory', 'rows' => '6',
            'placeholder' => 'Описание...'
        ]); ?>
        <?= humhub\widgets\MarkdownEditor::widget(['fieldId' => 'newStory']); ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('UniversityModule.base', 'Create') : Yii::t('UniversityModule.base', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
