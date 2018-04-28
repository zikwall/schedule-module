<?php
namespace humhub\modules\schedule\widgets;

use yii\base\Widget;
use humhub\modules\schedule\models\ScheduleSchedule;

class NearestCouplesWidget extends Widget
{
    public $contentContainer;

    public function run()
    {
        $currents = ScheduleSchedule::find()->current()->all();

        return $this->render('nearestCouplesWidget', [
            'currents' => $currents
        ]);
    }
}
