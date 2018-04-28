<?php

use humhub\libs\Html;
use humhub\modules\schedule\components\cellconstructor\helpers\Helper;
use humhub\modules\schedule\models\ScheduleHelper;

/**
 * @var \humhub\modules\schedule\models\ScheduleSchedule $dailyDiscipline
 */

$style = 'box-shadow: 0 0 10px '.Yii::$app->getModule('schedule')->settings->get('activeDisciplineColor');

?>

<div class="panel" style="<?= $dailyDiscipline->weeklyType->id == ScheduleHelper::getWeeklyType() ? '' : $style; ?>">

    <div class="panel-heading">
        <?= $this->render('_disciplineActions', [
            'discipline' => $dailyDiscipline,
            'day' => $dailyDiscipline->day_id,
            'couple' => $dailyDiscipline->couple_id,
            'group' => $dailyDiscipline->study_group_id
        ]); ?>
    </div>

    <div id="#daily-<?= $dailyDiscipline->id ?>" class="panel-body">
        <hr>
        <div class="">
            <span class="label label-success popoverTrigger" style="background-color:<?= $dailyDiscipline->weeklyType->color; ?>!important;" rel="popover" data-placement="bottom"
                  data-content="<?= $dailyDiscipline->weeklyType->name; ?>">
                <?= $dailyDiscipline->weeklyType->sign; ?>
            </span>
            <b><?= $dailyDiscipline->discipline->name; ?></b>
            <span class="label label-success popoverTrigger" style="background-color:<?= $dailyDiscipline->type->color; ?>!important;" rel="popover" data-placement="bottom"
                  data-content="<?= $dailyDiscipline->type->name; ?>">
                <?= $dailyDiscipline->type->sign; ?>
            </span>
        </div>
        <br>

        <?= Html::a('<i class="fa fa-map-marker fa-lg" style="color: #e85d09;"></i> '.$dailyDiscipline->classroom->getFullDisplyaRoom(), [
                '/faculties/classroom-public/view-ajax',
                'classroom' =>  $dailyDiscipline->classroom->id], [
                'class' => 'popoverTrigger',
                'data-target' => '#globalModal',
                'rel' => 'popover',
                'data-placement' => 'bottom',
                'data-trigger' => 'hover',
                'data-content' => $dailyDiscipline->classroom->classroomType->name
        ]); ?>

            <hr>
            Преподаватель:
            <?= Html::tag('span', $dailyDiscipline->teacher->science->shortname, [
                'class' => 'label label-info popoverTrigger',
                'rel' => 'popover',
                'data-placement' => 'bottom',
                'data-trigger' => 'hover',
                'data-content' => $dailyDiscipline->teacher->science->name
            ]); ?>
            <?= Html::a($dailyDiscipline->teacher->user->getDisplayName(), ['/schedule/public/teacher-ajax', 'id' => $dailyDiscipline->teacher->id],[
                'data-target' => '#globalModal',
            ]); ?>

            <?php if($dailyDiscipline->scheduleLinkSubgroups): ?>
                <br><br>
                <div class="panel panel-warning">
                    <div class="panel-body">
                        <?php
                            $subGroup = $dailyDiscipline->getSubgroups()->one();
                            echo $subGroup->name;
                        ?>
                    </div>
                </div>

            <?php endif; ?>
    </div>

    <?php if($dailyDiscipline->scheduleLinkIssues): ?>
        <div class="panel-body">
            <p class="panel-heading">
                Задачи:
                <a class="dropdown-toggle"
                   onclick="$('#viewIssues<?= $dailyDiscipline->id;?>').slideToggle('fast');$('#viewIssues<?= $dailyDiscipline->id;?>').focus();return false;"
                   data-toggle="dropdown" href="#"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-angle-down fa-fw"></i>
                </a>
            </p>
            <div id="viewIssues<?= $dailyDiscipline->id;?>" style="display: none;">
                <ul class="tour-list">
                    <?php foreach ($dailyDiscipline->scheduleLinkIssues as $issue): ?>
                        <li id="interface_entry" class="">
                            <?= Html::a('<i class="fa fa-chevron-right"></i> '.$issue->issues->title, $issue->issues->content->getUrl(), ['class' => '']); ?>
                        </li><hr>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
    $('.popoverTrigger').popover({ trigger: "hover" });
</script>