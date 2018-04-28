<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityTeachers */

?>
<div class="university-teachers-view">

    <p>
        <?= Html::a(Yii::t('UniversityModule.base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('UniversityModule.base', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('UniversityModule.base', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user.displayName',
            'post.name',
            'science.name',
            'chair.name',
            [
                'attribute' => 'disciplines',
                'label' => 'Предметы',
                'value' => function($model){
                    foreach ($model->disciplines as $discipline){
                        $disciplines[] = $discipline->name;
                    }
                    return implode(', ', $disciplines);
                }
            ],
            'story'
        ],
    ]) ?>

</div>
