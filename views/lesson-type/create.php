<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleLessonType */

$this->title = Yii::t('UniversityModule.base', 'Create ScheduleHelper Lesson Type');
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

<div class="schedule-lesson-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php $this->endContent(); ?>
