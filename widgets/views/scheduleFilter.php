<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="clearfix" id="<?= $id; ?>" style="display: none">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <p class="panel-heading">Дни недели</p><hr>

                    <?= Html::checkboxList('days', $days, \humhub\modules\schedule\models\ScheduleAviableDay::getList(), [
                        'separator' => '<br>'
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <p class="panel-heading">Пары</p><hr>
                    <?= Html::checkboxList('couples', $couples, \humhub\modules\schedule\models\ScheduleAviableCouple::getList(), [
                        'separator' => '<br>'
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <p class="panel-heading">Опциональные фильры:</p><hr>
                    <label>Типы учебных недель</label>
                    <?= Html::radioList('weekly', $weekly, \humhub\modules\schedule\models\ScheduleWeeklyType::getList(), [
                        'class' => 'form-control',
                        'itemOptions' => ['class' => 'radio'],
                    ]); ?>
                    <?php if(!$isContainer && empty($group)): ?>
                    <br><label>По предметам</label>
                    <?= Html::dropDownList('disciplines', $disciplines, \humhub\modules\university\models\UniversityDiscipline::getListLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'discipline-id',
                        'data-ui-select2' => ''
                    ]); ?>
                    <br><label>По преподавателям</label>
                    <?= Html::dropDownList('teachers', $teachers, \humhub\modules\university\models\UniversityTeachers::getListLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'discipline-id',
                        'data-ui-select2' => ''
                    ]); ?>
                    <?php else: ?>
                    <br><label>По предметам</label>
                    <?= Html::dropDownList('disciplines', $disciplines, \humhub\modules\university\models\UniversityDiscipline::getListLikeGroup($group),[
                        'multiple' => true,
                        'id' => 'discipline-id',
                        'data-ui-select2' => ''
                    ]); ?>
                    <br><label>По преподавателям</label>
                    <?= Html::dropDownList('teachers', $teachers, \humhub\modules\university\models\UniversityTeachers::getListLikeGroup($group) ,[
                        'multiple' => true,
                        'id' => 'discipline-id',
                        'data-ui-select2' => ''
                    ]); ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-12">
                    <p class="panel-heading">Типы предметов</p>
                    <?= Html::checkboxList('types', $types, \humhub\modules\schedule\models\ScheduleLessonType::getList(), [
                        'class' => 'form-control',
                        'separator' => ' | '
                    ]); ?>
                </div>
                <?php if(!$isContainer && empty($group)): ?>
                <div class="col-md-6">
                    <hr>
                    <p class="panel-heading">По учебным группам (которые есть в расписании)</p>
                    <?= Html::dropDownList('groups', $groups, \humhub\modules\university\models\UniversityStudyGroups::getListLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'discipline-id',
                        'data-ui-select2' => ''
                    ]); ?>
                    <hr>
                    <p class="panel-heading">По всем учебным группам</p>
                    <?= Html::dropDownList('groupsAll', $groupsAll, \humhub\modules\university\models\UniversityStudyGroups::getListAllLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'discipline-id',
                        'data-ui-select2' => ''
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <hr>
                    <p class="panel-heading">По аудиториям</p>
                    <?= Html::dropDownList('classrooms', $classrooms, \humhub\modules\faculties\models\UniversityBuildingClassroom::getListLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'discipline-id',
                        'data-ui-select2' => ''
                    ]); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="panel-footer">
            <div class="form-group">
                <?= Html::submitButton('Фильтровать', [
                    'class' => 'btn btn-primary',
                    'data-method' => 'post'
                ]); ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
