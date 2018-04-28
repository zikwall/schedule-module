<?php
$this->registerJsFile('https://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru');
$this->registerCss('.columnText {width: 1px; float: left;word-wrap: break-word; }');
?>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Расписание</strong> занятий

            <?= \humhub\modules\schedule\widgets\ScheduleCoursesWidget::widget(
                    [
                            'faculty' => Yii::$app->request->getQueryParam('faculty'),
                    ]
            ); ?>
        </div>
        <div class="panel-body">
            <?= $content; ?>
        </div>

        <?= \humhub\modules\schedule\widgets\byWidget::widget(); ?>
    </div>
</div>

