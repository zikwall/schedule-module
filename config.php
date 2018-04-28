<?php

use humhub\modules\university\widgets\StudentsMenu;
use humhub\modules\user\widgets\ProfileMenu;
use humhub\modules\schedule\widgets\ScheduleTypeWidget;

return [
	'id' => 'schedule',
	'class' => 'humhub\modules\schedule\Module',
	'namespace' => 'humhub\modules\schedule',
	'events' => [
        [
            'class' => \humhub\modules\user\widgets\ProfileSidebar::className(),
            'event' => \humhub\modules\user\widgets\ProfileSidebar::EVENT_INIT,
            'callback' => [
                'humhub\modules\schedule\Events',
                'addUserCoupleWidget'
            ]
        ],
        [
            'class' => ProfileMenu::className(),
            'event' => ProfileMenu::EVENT_INIT,
            'callback' => [
                'humhub\modules\schedule\Events',
                'onProfileMenuInit'
            ],
        ],
		[
			'class' => \humhub\widgets\TopMenu::className(),
			'event' => \humhub\widgets\TopMenu::EVENT_INIT,
			'callback' => ['humhub\modules\schedule\Events', 'onTopMenuInit'],
		],
		[
			'class' => humhub\modules\admin\widgets\AdminMenu::className(),
			'event' => humhub\modules\admin\widgets\AdminMenu::EVENT_INIT,
			'callback' => ['humhub\modules\schedule\Events', 'onAdminMenuInit']
		],
	],
];
?>

