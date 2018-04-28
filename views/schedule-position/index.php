<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel humhub\modules\schedule\models\search\SchedulePositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('ScheduleModule.base', 'ScheduleHelper Positions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-position-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('ScheduleModule.base', 'Create ScheduleHelper Position'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'en_name',
            'desc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>