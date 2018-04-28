<?php
/**
 * @var \yii\web\View $this
 * @var \humhub\modules\schedule\models\ScheduleAviableDay $dayInfo
 * @var \humhub\modules\schedule\models\ScheduleAviableCouple $coupleInfo
 * @var \humhub\modules\university\models\UniversityStudyGroups $groupInfo
 * @var \humhub\modules\schedule\models\ScheduleSchedule $discipline
 */
?>
<div class="modal-dialog modal-dialog-normal animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <strong><?= $dayInfo->name; ?></strong> <?= $coupleInfo->displayName; ?>
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
            <div class="panel">
                <div class="panel-body">
                    <div data-toggle="tooltip" title="Группа">
                        <span class="label label-default"><i class="fa fa-users fa-fw" aria-hidden="true"></i></span>
                        <span class="label label-default">Группа: </span>
                        <span class="label label-info"><?= $groupInfo->displayName; ?></span>
                    </div>
                    <div data-toggle="tooltip" title="Профиль подготовки">
                        <span class="label label-default"><i class="fa fa-paperclip fa-fw" aria-hidden="true"></i></span>
                        <span class="label label-default">Профиль подготовки: </span>
                        <span class="label label-info"><?= $groupInfo->profile->name; ?></span>
                    </div>
                    <div data-toggle="tooltip" title="Дисциплина">
                        <span class="label label-default"><i class="fa fa-book fa-fw" aria-hidden="true"></i></span>
                        <span class="label label-default">Дисциплина: </span>
                        <span class="label label-info"><?= $discipline->discipline->name; ?></span>
                    </div>
                    <div data-toggle="tooltip" title="Место">
                        <span class="label label-default"><i class="fa fa-building fa-fw" aria-hidden="true"></i></span>
                        <span class="label label-default">Место: </span>
                        <span class="label label-info"><?= $discipline->classroom->building->name; ?></span> <span class="label label-info"><?= $discipline->classroom->getDisplayRoom(); ?></span>
                    </div>
                </div>
            </div>

            <div id="viewmaplocation" style="">
                <?php

                $building = $discipline->classroom->building;

                $obj = new \humhub\modules\university\widgets\yandexmap\GeoObject([
                    'hintContent' => 'ssss',
                    'balloonContent' => 'wswsw',
                ],[]);

                $map = new \humhub\modules\university\widgets\yandexmap\Map('yandex_map', [
                    'center' => [$building->latitude, $building->longitude],
                    'zoom' => 15,
                    // Enable zoom with mouse scroll
                    'behaviors' => array('default', 'scrollZoom'),
                    'type' => "yandex#map",
                ],
                    [
                        'objects' => [new \humhub\modules\university\widgets\yandexmap\objects\Placemark([$building->latitude, $building->longitude], [$obj], [
                            'draggable' => true,
                            'balloonContentFooterLayout' => 'ymaps.templateLayoutFactory.createClass(
                                население: $[properties.population], координаты: $[geometry.coordinates])',
                            // Отключаем задержку закрытия всплывающей подсказки.
                            'hintHideTimeout' => 0,
                            //'visible' => false,
                            'preset' => 'islands#blueHomeIcon',
                            'iconColor' => '#2E9BB9',
                            'events' => [
                                'dragend' => 'js:function (e) {
                    console.log(e.get(\'target\').geometry.getCoordinates());
                }'
                            ]
                        ])]
                    ],
                    [
                        // Permit zoom only fro 9 to 11
                        'minZoom' => 9,
                        'maxZoom' => 11,
                        'controls' => [
                            "new ymaps.control.SmallZoomControl()",
                            "new ymaps.control.TypeSelector(['yandex#map', 'yandex#satellite'])",
                        ],
                    ]
                );
                ?>

                <div class="panel">
                    <div class="panel-heading">
                        <strong>Геолокация</strong>
                    </div>
                    <div class="panel-body">
                        <?= humhub\modules\university\widgets\yandexmap\Canvas::widget([
                            'htmlOptions' => [
                                'style' => 'height: 400px;',
                            ],
                            'map' => $map,

                        ]);
                        ?>
                    </div>
                </div>

                <?php if(!Yii::$app->user->isGuest):?>
                <div class="panel">
                    <div class="panel-heading">
                        <strong>Медиа</strong> информация корпуса/здания
                    </div>
                    <div class="panel-body">
                        <?= \humhub\modules\file\widgets\ShowFiles::widget(['object' => $building])
                        ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
