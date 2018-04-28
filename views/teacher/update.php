<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityTeachers */

$this->title = Yii::t('UniversityModule.base', 'Update {modelClass}: ', [
    'modelClass' => 'University Teachers',
]) . $model->id;
?>

<div class="university-teachers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
