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

    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render('_informationHeader'); ?>
                <?php if(!empty(Yii::$app->request->getQueryParam('profile') || !empty(Yii::$app->request->getQueryParam('group')))): ?>
                    <br>
                    <?= Html::backButton(); ?>
                <?php endif; ?>
            </div>
            <br>
            <div class="col-md-9">
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-filter"></i> Показать панель фильтров', '#', [
                        'class' => 'btn btn-success',
                        'onclick' => '$("#filter").slideToggle("fast");$("#filter").focus();return false;'
                    ]); ?>

                    <?= \humhub\modules\schedule\widgets\ScheduleManagerPanelWidget::widget(['type' => 2]); ?>
                </div>
            </div>
        </div>
        <br>
        <?= \humhub\modules\schedule\widgets\ScheduleFilterWidget::widget([
            'days' => $days, 'couples' => $couples, 'weekly' => $weekly, 'disciplines' => $disciplines, 'teachers' => $teachers,
            'isContainer' => true,
            'group' => $userGroup
        ]); ?>

    </div>
    <div class="panel-body pull-left">
        Группа: <strong><?= $group->displayName; ?></strong>
    </div>
</div>

<?= $table->render();?>






