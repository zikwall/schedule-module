<?php
use yii\bootstrap\Html;

/**
 * @var \yii\web\View $this
 *
 * @var \humhub\modules\university\models\UniversityTeachers $teacher
 */
?>
<div class="modal-dialog modal-dialog-normal animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <strong>Проеподаватель</strong> <?= $teacher->user->getDisplayName(); ?>
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">

            <div class="panel">
                <div class="panel-body">
                    <div data-toggle="tooltip" title="Кафедра">
                        <span class="label label-default"><i class="fa fa-users fa-fw" aria-hidden="true"></i></span>
                        <span class="label label-default">Кафедра: </span>
                        <span class="label label-info"><?= $teacher->chair->name; ?></span>
                    </div>
                    <div data-toggle="tooltip" title="Должность">
                        <span class="label label-default"><i class="fa fa-paperclip fa-fw" aria-hidden="true"></i></span>
                        <span class="label label-default">Должность: </span>
                        <span class="label label-info"><?= $teacher->post->name; ?></span>
                    </div>
                    <div data-toggle="tooltip" title="Ученая степень">
                        <span class="label label-default"><i class="fa fa-book fa-fw" aria-hidden="true"></i></span>
                        <span class="label label-default">Ученая степень: </span>
                        <span class="label label-info"><?= $teacher->science->name; ?></span>
                    </div>
                </div>
            </div>
            <div class="panel">
                <?= Html::a('<i class="fa fa-user"></i> Профиль в системе', $teacher->user->createUrl(), [
                        'class' => 'btn btn-primary'
                ]);?>
                <?= Html::a('<i class="fa fa-user"></i> Пары', [
                        '/schedule/public/global',
                        'faculty' => Yii::$app->request->getQueryParam('faculty'),
                        'course' => Yii::$app->request->getQueryParam('course'),
                        'teacher' => $teacher->id
                ], [
                    'class' => 'btn btn-success'
                ]);?>
            </div>
            <?= humhub\widgets\MarkdownView::widget(['markdown' => $teacher->story]); ?>

            <div class="panel">
                <div class="panel-heading">
                    Сейчас ведет пару
                </div>
                <div class="panel-body">
                    <ul class="media-list">
                    <?php foreach(\humhub\modules\schedule\models\ScheduleSchedule::find()->current('+1', '-20')->all() as $current): ?>
                        <?php /** @var \humhub\modules\schedule\models\ScheduleSchedule $current */ ?>
                        <a href="javascript::void()">
                            <li style="border-left: 3px solid #6fdbe8">
                                <div class="media">
                                    <div class="media-body  text-break">
                                        <?php if((new \humhub\modules\schedule\components\TimeInterval($current->couple->getDisplayTime()))->isNow()): ?>
                                            <span class="label label-success pull-right">Текущая пара</span>
                                        <?php endif; ?>
                                        <strong><?= $current->discipline->name; ?></strong>
                                        <span class="label label-success popoverTrigger" style="background-color:<?= $current->type->color; ?>!important;" rel="popover" data-placement="bottom">
                                                <?= $current->type->sign; ?>
                                        </span>
                                        <span class="label label-success popoverTrigger" style="" rel="popover" data-placement="bottom">
                                                <?= $current->classroom->getFullDisplyaRoom(); ?>
                                        </span>
                                        <br><hr>
                                        <span class="time" title="<?= $current->couple->getDisplayTime();?>">
                                    <?= $current->couple->getDisplayTime();?>
                                </span>

                                    </div>
                                </div>
                            </li>
                        </a>
                        <br>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
