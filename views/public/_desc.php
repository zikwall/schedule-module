<?php
/**
 * @var \yii\web\View $this
 *
 * @var \humhub\modules\schedule\models\ScheduleSchedule $description
 */
?>
<div class="modal-dialog modal-dialog-normal animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <strong>Описание</strong> <?= $description->day->name; ?> - <?= $description->couple->displayName; ?>
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
            <?php if($description->desc){
                echo humhub\widgets\MarkdownView::widget(['markdown' => $description->desc]);
            } else {
                echo 'У данной пары пока нет описания';
            }
            ?>
        </div>
    </div>
</div>
