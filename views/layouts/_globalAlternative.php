<?php
$this->registerJsFile('https://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <div class="panel">
                <div class="panel-heading">
                    <strong>Список</strong> групп
                </div>
                <div class="panel-body">
                    <?= \humhub\modules\schedule\widgets\ScheduleListGroupsWidget::widget([
                        'faculty' => Yii::$app->request->getQueryParam('faculty'),
                        'course' => Yii::$app->request->getQueryParam('course'),
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-10">
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
    </div>
</div>

