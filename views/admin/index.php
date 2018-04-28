
<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

<?php

use yii\helpers\Html;
use humhub\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\schedule\models\search\ScheduleAviableDay */
/* @var $dataProvider yii\data\ActiveDataProvider */
/**
 * @var \humhub\modules\faculties\models\UniversityFaculties $model
 */
?>

<?php foreach ($model as $faculty): ?>
    <?php /** @var \humhub\modules\faculties\models\UniversityFaculties $faculty */?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= $faculty->fullname; ?>
            <div class="pull-right">
                <?= Html::a('Перейти к заполнению расписания для '.$faculty->shortname, [
                        '/schedule/admin/course-schedule',
                        'faculty' => $faculty->id,
                ], ['class' => 'btn btn-primary']
                )?>
            </div>
        </div>
        <div class="panel-body">

        </div>
    </div>

<?php endforeach; ?>

<?= ($pagination != null) ? \humhub\widgets\LinkPager::widget(['pagination' => $pagination]) : ''; ?>

<?php $this->endContent(); ?>