<?php
    $manager = Yii::$app->getModule('schedule')->settings
?>

<div data-toggle="tooltip" title="Текущая неделя:">
    <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
    <span class="label label-default">Текущая неделя: </span>
    <?php if(\humhub\modules\schedule\models\ScheduleHelper::getWeeklyType()): ?>
        <span class="label label-primary">Четная</span>
    <?php else: ?>
        <span class="label label-primary" style="background-color:#f3820e!important;">Нечетная</span>
    <?php endif; ?>
</div>

<div data-toggle="tooltip" title="Информация">
    <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
    <span class="label label-default">Информация: </span>
    <span class="label label-default" style="background-color:<?= $manager->get('activeDisciplineColor'); ?>!important;color:#ffffff!important;"><?= $manager->get('informationLabel'); ?></span>
</div>