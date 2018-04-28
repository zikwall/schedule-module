<?php
use humhub\libs\Html;

/**
 * @var \humhub\modules\schedule\models\ScheduleSchedule $discipline
 */
?>
<div class="panel">
    <div class="panel-body">
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-pencil"></i>', [
                '/schedule/admin/day-info',
                'faculty' => Yii::$app->request->getQueryParam('faculty'),
                'course' => $course
            ], [
                'data-target' => '#globalModal',
                'class' => 'btn btn-default btn-sm'
            ])?>
            <?= Html::a('<i class="fa fa-pencil"></i>', [ '/schedule/admin/day-info',
                'faculty' => Yii::$app->request->getQueryParam('faculty'),
                'course' => $course
            ], [
                'data-target' => '#globalModal',
                'class' => 'btn btn-success btn-sm'
            ])?>
            <?= Html::a('<i class="fa fa-plus"></i>', [ '/schedule/admin/add-ajax',
                'faculty' => Yii::$app->request->getQueryParam('faculty'),
                'course' => $course,
                'day' => $day,
                'couple' => $couple,
                'group' => $group
            ], [
                'data-target' => '#globalModal',
                'class' => 'btn btn-info btn-sm'
            ])?>
        </div>
    </div>
</div>
