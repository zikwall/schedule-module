<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Yii::t('ScheduleModule.base','<strong>Расписание занятий</strong>');?>
        </div>

        <?= \humhub\modules\schedule\widgets\ScheduleAdminTabs::widget(); ?>

        <div class="panel-body">
            <?= $content; ?>
        </div>
    </div>
</div>


