<?php

use humhub\libs\Html;

$getCourse = !empty(Yii::$app->request->getQueryParam('course')) ? Yii::$app->request->getQueryParam('course') : 1;
$checkCourse = !empty($course) ? $course : $getCourse;
?>

<?php \humhub\modules\schedule\widgets\ScheduleAdminTabs::markAsActive(['/schedule/admin/index']); ?>

<div class="clearfix">
    <div class="panel-body">
        <h4><?= Yii::t('UniversityModule.setting', 'Управление расписанием'); ?></h4>
        <div class="help-block">
            <?= Yii::t('UniversityModule.setting', 'Теперь управление расписанием Вашего университеа будет максимально проста!'); ?>
        </div>
        <div class="pull-right">
            <p>
                <?= Html::a(Yii::t('ScheduleModule.base', 'Создать расписание для {course} курса', ['course' => $checkCourse]), [
                        'create',
                        'faculty' => !empty($faculty) ? $faculty : Yii::$app->request->getQueryParam('faculty'),
                        'course' => $checkCourse
                ], ['class' => 'btn btn-success']) ?>
                <?= Html::backButton(['index'], ['label' => Yii::t('AdminModule.base', 'Back to overview'),]); ?>
            </p>
        </div>

    </div>
</div>

<?= \humhub\modules\schedule\widgets\ScheduleAdminCoursesWidget::widget([
    'faculty' => !empty($faculty) ? $faculty : Yii::$app->request->getQueryParam('faculty'),
    'course' => $checkCourse
]); ?>

<div class="panel-body">
    <?= $content; ?>
</div>