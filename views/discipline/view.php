<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model humhub\modules\university\models\UniversityDiscipline */

?>
<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayout.php') ?>
<div class="university-discipline-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'name',
            'en_name',
            'color',
            [
                'attribute' => 'teachers',
                'label' => 'Преподаватели',
                'value' => function($model){
                    foreach ($model->teachers as $teacher){
                        $teachers[] = Html::a($teacher->user->displayName, $teacher->user->createUrl());
                    }
                    return implode(', ', $teachers);
                },
                'format' => 'html',
            ],
            'desc',
        ],
    ]) ?>

</div>

<?php $this->endContent(); ?>