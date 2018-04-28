<?php

namespace humhub\modules\schedule\permissions;

use humhub\modules\admin\components\BaseAdminPermission;

class ManageScheduleIssues extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'schedule_manage_schedule_issues';
    protected $moduleId = 'schedule';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = 'Управление задачами для расписания';
        $this->description = 'Разрешение на создание/обновление/удаление задач расписаний';
    }

}
