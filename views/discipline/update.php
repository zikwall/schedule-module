<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityDiscipline */

$this->title = Yii::t('UniversityModule.base', 'Update {modelClass}: ', [
    'modelClass' => 'University Discipline',
]) . $model->name;
?>

<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>

<div class="university-discipline-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php $this->endContent(); ?>
