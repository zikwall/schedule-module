<?php

namespace humhub\modules\schedule\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class Identity extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'setIdentity',
            ActiveRecord::EVENT_BEFORE_INSERT => 'setIdentity',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'setIdentity',
        ];
    }

    public function setIdentity($event) {
        if ($this->owner->isNewRecord) {
            if ($this->owner->identity == "") {
                $this->owner->identity = \humhub\libs\UUID::v4();
            }
        }
    }
}