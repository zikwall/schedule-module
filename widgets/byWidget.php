<?php
namespace humhub\modules\schedule\widgets;

use humhub\modules\university\models\UniversityStudyGroups;
use yii\base\Widget;

class byWidget extends Widget
{
    public function run()
    {
        return $this->render('byWidget');
    }
}
