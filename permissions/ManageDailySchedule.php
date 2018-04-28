<?php

namespace humhub\modules\schedule\permissions;

use humhub\modules\admin\components\BaseAdminPermission;

class ManageDailySchedule extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'schedule_manage_daily_schedule';
    protected $moduleId = 'schedule';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = 'Управление расписанием';
        $this->description = 'Разрешение на создание/обновление/удаление занятий по дням и парам';
    }

}
