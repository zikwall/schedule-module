<?php
/**
 * @var \humhub\modules\user\models\User $contentContainer
 * @var $this humhub\components\View
 */

$this->setPageTitle('Расписание занятий');

?>

<?php $this->beginContent('@humhub/modules/university/views/layouts/_layout.php') ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('AdminModule.user', '<strong>Information</strong>'); ?>
    </div>
    <div class="panel-body">
        <?= $content; ?>
    </div>
</div>
<?php $this->endContent(); ?>
