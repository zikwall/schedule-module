<?php

namespace humhub\modules\schedule\models;

use humhub\modules\api\modules\rest\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "schedule_subgroups".
 *
 * @property integer $id
 * @property string $name
 * @property string $color
 *
 * @property ScheduleLinkSubgroups[] $scheduleLinkSubgroups
 */
class ScheduleSubgroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule_subgroups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['color'], 'string', 'max' => 7],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ScheduleModule.base', 'ID'),
            'name' => Yii::t('ScheduleModule.base', 'Name'),
            'color' => Yii::t('ScheduleModule.base', 'Color'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLinkSubgroups()
    {
        return $this->hasMany(ScheduleLinkSubgroups::className(), ['subgroup_id' => 'id']);
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->orderBy([self::tableName() . '.name' => SORT_ASC])->all(),
            'id', 'name'
        );
    }
}
