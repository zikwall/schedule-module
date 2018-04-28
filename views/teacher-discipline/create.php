<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityTeacherDiscipline */

$this->title = Yii::t('UniversityModule.base', 'Create University Teacher Discipline');
$this->params['breadcrumbs'][] = ['label' => Yii::t('UniversityModule.base', 'University Teacher Disciplines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-teacher-discipline-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
