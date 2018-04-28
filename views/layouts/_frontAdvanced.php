<?php
use humhub\libs\Html;
?>

<div class="panel-body">
    <h4><?= Yii::t('UniversityModule.setting', 'Управление расписанием'); ?></h4>
    <div class="help-block">
        <?= Yii::t('UniversityModule.setting', 'Расширьте информационный мир Вашего университета с помощью расписания.'); ?>
        <div class="pull-right">
            <?= Html::backButton(['index'], ['label' => Yii::t('AdminModule.base', 'Back to overview'),]); ?>
        </div>
    </div>
</div>

<?= \humhub\modules\schedule\widgets\FrontAdvancedMenu::widget(); ?>

<div class="panel-body">
    <?= $content; ?>
</div>