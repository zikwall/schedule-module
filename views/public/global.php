<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 13.03.2018
 * Time: 20:40
 */

$this->registerCss('
.center{text-align: center; vertical-align: middle;}
.topright { position: absolute; top: 5px; right: 5px; text-align: right; }
'

);

use humhub\libs\Html;
?>

<div class="panel-body">

    <?= $this->render('_informationHeader'); ?>
    <?php if(!empty(Yii::$app->request->getQueryParam('profile') || !empty(Yii::$app->request->getQueryParam('group')))): ?>
        <br>
        <?= Html::backButton(); ?>
    <?php endif; ?>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-3 pull-left">
                <div class="pagination">
                    <?= ($pagination != null) ? \humhub\widgets\LinkPager::widget(['pagination' => $pagination]) : ''; ?>
                </div>
            </div>
            <br>
            <div class="col-md-9">
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-filter"></i> Показать панель фильтров', '#', [
                        'class' => 'btn btn-success',
                        'onclick' => '$("#filter").slideToggle("fast");$("#filter").focus();return false;'
                    ]); ?>
                    <?= Html::a('<i class="fa fa-print"></i> Вывести на печать расписание', '#', [
                        'data-ui-loader' => '',
                        'class' => 'btn btn-warning'
                    ]); ?>
                    <?= \humhub\modules\schedule\widgets\ScheduleManagerPanelWidget::widget(['type' => 1]); ?>
                </div>
            </div>
        </div>

        <?= \humhub\modules\schedule\widgets\ScheduleFilterWidget::widget([
            'days' => $days, 'couples' => $couples, 'weekly' => $weekly, 'disciplines' => $disciplines, 'teachers' => $teachers,
            'types' => $types, 'groups' => $groups, 'groupsAll' => $groupsAll, 'classrooms' => $classrooms, 'profiles' => $profiles,
            'specialities' => $specialities
        ]); ?>

    </div>
</div>

<?= $table->render();?>
