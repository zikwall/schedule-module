<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\university\models\search\UniversityTeacherDiscipline */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('UniversityModule.base', 'University Teacher Disciplines');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-teacher-discipline-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('UniversityModule.base', 'Create University Teacher Discipline'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'teacher_id',
            'discipline_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
