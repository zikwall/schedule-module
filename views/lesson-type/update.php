<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleLessonType */

$this->title = Yii::t('UniversityModule.base', 'Update {modelClass}: ', [
    'modelClass' => 'ScheduleHelper Lesson Type',
]) . $model->name;
?>


<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

<div class="schedule-lesson-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php $this->endContent(); ?>
