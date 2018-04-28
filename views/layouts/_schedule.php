<?php $this->beginContent('@humhub/modules/admin/views/layouts/main.php') ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Yii::t('ScheduleModule.base','<strong>Расписание занятий</strong>');?>
        </div>
        <?= \humhub\modules\schedule\widgets\ScheduleAdminTabs::widget(); ?>

        <div class="panel-body">
            <?= $content; ?>
        </div>
    </div>
<?php $this->endContent(); ?>