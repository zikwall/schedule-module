<?php
/**
 * @var $couple integer
 * @var $group integer
 * @var \humhub\modules\schedule\models\ScheduleSchedule $dailyDiscipline
 */

use yii\bootstrap\Html;

/**
 * @var \humhub\modules\schedule\models\ScheduleSchedule $discipline
 */
?>
<div class="pull-left">
    <?= Html::a('<i class="fa fa-eye"></i>', [
            '/schedule/public/view-ajax',
            'day' => $day, 'couple' => $couple, 'group' => $group, 'discipline' => $discipline->id
        ], [
        'class' => 'btn btn-success btn-sm',
        'data-target' => '#globalModal'
    ]) ?>
    <?= Html::a('<i class="fa fa-question"></i>', ['/schedule/public/view-desc-ajax', 'discipline' =>  $discipline->id], [
        'class' => 'btn btn-default btn-sm',
        'data-target' => '#globalModal'
    ]) ?>

    <?php
    if(Yii::$app->user->can(new \humhub\modules\schedule\permissions\ManageDailySchedule())){
        echo Html::a('<i class="fa fa-pencil"></i>', ['/schedule/admin/edit-ajax', 'daily' =>  $discipline->id, 'faculty' => Yii::$app->request->getQueryParam('faculty'), 'course' => $discipline->studyGroup->course->number], [
            'class' => 'btn btn-info btn-sm',
            'data-target' => '#globalModal'
        ]);
    }
    ?>

    <?php
    if(Yii::$app->user->can(new \humhub\modules\schedule\permissions\ManageScheduleIssues())){
        echo Html::a('<i class="fa fa-plus"></i>', ['/schedule/admin/add-issues', 'daily' =>  $discipline->id, 'faculty' => Yii::$app->request->getQueryParam('faculty'), 'course' => $discipline->studyGroup->course->number], [
            'class' => 'btn btn-warning btn-sm',
            'data-target' => '#globalModal'
        ]);
    }
    ?>

</div>
<ul class="nav nav-pills preferences">
    <li class="dropdown">
        <?= Html::a('<i class="fa fa-angle-down"></i>', '#', [
                'class' => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
                'aria-label' => 'Toggle panel menu',
                'aria-haspopup' => 'true',
                'aria-expanded' => 'false'
        ]) ?>
        <ul class="dropdown-menu pull-right">
            <li>
                <?= Html::a('<i class="fa fa-calendar-plus-o"></i> Информация', '', [
                        'data-toggle' => 'collapse',
                        'data-target' => '#daily' . $discipline->id,
                        'class' => 'panel-collapse'
                ])?>
            </li>
            <?php if(Yii::$app->user->can(new \humhub\modules\schedule\permissions\ManageDailySchedule())): ?>
                <li>
                    <?= Html::a('<i class="fa fa-trash"></i> Удалить', ['/schedule/admin/delete-ajax', 'id' => $discipline->id, 'faculty' => Yii::$app->request->getQueryParam('faculty'), 'course' => $discipline->studyGroup->course->number], [
                        'class' => 'panel-collapse',
                        'data' => [
                            'confirm' => 'Вы действительно хотите удалить данное занятие из расписания?',
                            'method' => 'post',
                        ],
                    ]); ?>
                </li>
            <?php endif; ?>
        </ul>
    </li>
</ul>