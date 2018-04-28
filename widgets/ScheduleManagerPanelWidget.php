<?php

namespace humhub\modules\schedule\widgets;

use humhub\components\Widget;
use humhub\modules\schedule\permissions\ManageDailySchedule;

class ScheduleManagerPanelWidget extends Widget
{
    public $type = 1;
    public $id = 'managePanel';

    public function run()
    {
        if(!\Yii::$app->user->can(new ManageDailySchedule())){
            return;
        }

        $link = $this->type == 1 ? '/schedule/public/global' : '/schedule/public/global-alternative';

        return $this->render('managePanel', [
            'link' => $link
        ]);
    }
}

?>