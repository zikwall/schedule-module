<?php
/**
 * @var \yii\web\View $this
 *
 * @var \humhub\modules\university\models\UniversityStudyGroups $group
 */
?>
<div class="modal-dialog modal-dialog-normal animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <strong>Описание</strong> <?= $group->displayName; ?>
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
            <?php if($group->desc){
                echo humhub\widgets\MarkdownView::widget(['markdown' => $group->desc]);
            } else {
                echo 'У данной группы пока нет описания';
            }
            ?>
        </div>
    </div>
</div>
