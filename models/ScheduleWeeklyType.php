<?php

namespace humhub\modules\schedule\models;

use humhub\modules\api\modules\rest\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "schedule_weekly_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $en_name
 * @property string $color
 * @property string $sign
 *
 * @property ScheduleSchedule[] $scheduleSchedules
 */
class ScheduleWeeklyType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule_weekly_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sign'], 'required'],
            [['name', 'en_name'], 'string', 'max' => 100],
            [['color'], 'string', 'max' => 7],
            [['sign'], 'string', 'max' => 10],
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
            'en_name' => Yii::t('ScheduleModule.base', 'En Name'),
            'color' => Yii::t('ScheduleModule.base', 'Color'),
            'sign' => Yii::t('ScheduleModule.base', 'Sign'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleSchedules()
    {
        return $this->hasMany(ScheduleSchedule::className(), ['weekly_type_id' => 'id']);
    }

    /**
     * @return array[]
     */
    public static function getList()
    {
        $merge = ArrayHelper::merge([1 => ['id' => 0, 'name' => 'Все']], self::find()->asArray()->all());
        return ArrayHelper::map($merge, 'id', 'name');
    }
}
