<?php
/**
 * @var \humhub\modules\schedule\models\ScheduleHeaders $model
 */
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayoutForSchedule.php') ?>

<?php if($model): ?>

    <div class="panel">
        <div class="panel-body">
            <strong>Шапка</strong> расписания для: <?= $model->faculty->fullname; ?>
        </div>
    </div>

    <div class="schedule-header">
        <?= $table->render(); ?>
    </div>

<?php else: ?>
    <div class="panel">
        <div class="panel-body">
            <strong>Шапка</strong> расписания еще не задана, создать шапку : <?= \yii\helpers\Html::a('Создать', ['/schedule/admin/edit-header', 'faculty' => $faculty])?>
        </div>
    </div>
<?php endif; ?>

<?php $this->endContent(); ?>