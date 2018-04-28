<?php

namespace humhub\modules\schedule\models;

use humhub\modules\api\modules\rest\helpers\ArrayHelper;
use humhub\modules\schedule\behaviors\Identity;
use humhub\modules\schedule\components\TimeInterval;
use Yii;

/**
 * This is the model class for table "schedule_aviable_day".
 *
 * @property integer $id
 * @property string $identity
 * @property string $name
 * @property string $en_name
 * @property string $desc
 *
 * @property ScheduleSchedule[] $scheduleSchedules
 */
class ScheduleAviableDay extends \yii\db\ActiveRecord
{
    public $days;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule_aviable_day}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identity', 'name'], 'required'],
            [['identity'], 'string', 'max' => 150],
            [['name', 'en_name'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('DocumentModule.base', 'ID'),
            'identity' => Yii::t('ScheduleModule.base', 'Identity'),
            'name' => Yii::t('DocumentModule.base', 'Name'),
            'en_name' => Yii::t('DocumentModule.base', 'En Name'),
            'desc' => Yii::t('DocumentModule.base', 'Desc'),
        ];
    }

    public function behaviors()
    {
        return [
            //Identity::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleSchedules()
    {
        return $this->hasMany(ScheduleSchedule::className(), ['day_id' => 'id']);
    }

    public static function getList($day = null)
    {
        $query = self::find();

        if(!empty($day)){
            $query->where(['id' => $day]);
        }

        return ArrayHelper::map($query->asArray()->all(), 'id', 'name');
    }

    public function nameWithDate($dayNumber)
    {
        return '<b>'.$this->name.'</b> ' . '<br>' . TimeInterval::currentWeekDayOfMonth($dayNumber);
    }

    public function headerNameWithDate($dayNumber)
    {
        return '<div style="text-align: center; vertical-align: middle">'.'<h1>'.$this->name.'</h1> ' . '<br>' . TimeInterval::currentWeekDayOfMonth($dayNumber).'</div>';
    }
}
