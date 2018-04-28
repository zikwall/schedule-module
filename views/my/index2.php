<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 24.03.2018
 * Time: 17:27
 *
 * @var \yii\web\View $this
 */

use yii\bootstrap\Html;

$this->registerCss('.actionCheck {
    border: 1px solid black;
    width: 100px;
    transition: all 0.3s ease-in-out;
    opacity: 1;
    border-collapse: collapse;
    padding: 0;
    margin: 0;
   }
   
   .hidden {
   width: 0;
    opacity: 0;
    font-size: 0;
    padding: 0;
    margin: 0;
    border: 0;
    
}

.widthCell{width: 9%}');
?>

<?php
$this->registerJsFile('https://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru');
?>

<div class="panel">
    <?= \humhub\modules\schedule\widgets\ScheduleTypeWidget::widget(['user' => $this->context->getUser()]); ?>
    <div class="panel-heading">
        <strong>Расписание</strong> для группы: <strong><?= $group->displayName; ?></strong>
    </div>
    <div class="panel-body">
        <?= $this->render('/public/_informationHeader'); ?>
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-filter"></i> Показать панель фильтров', '#', [
                'class' => 'btn btn-success',
                'onclick' => '$("#filter").slideToggle("fast");$("#filter").focus();return false;'
            ]); ?>
        </div>
    </div>
</div>

<?php foreach ($tableObjects as $tableObject): ?>
    <div class="panel">
        <div class="panel-body">

            <?= \humhub\modules\schedule\widgets\ScheduleFilterWidget::widget([
                'days' => $days, 'couples' => $couples, 'weekly' => $weekly, 'disciplines' => $disciplines, 'teachers' => $teachers, 'isContainer' => true,
                'group' => $userGroup
            ]); ?>

            <?= $tableObject->render(); ?>
        </div>
    </div>

<?php endforeach; ?>

<?= \humhub\modules\schedule\widgets\byWidget::widget(); ?>


