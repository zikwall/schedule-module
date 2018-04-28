<?php

namespace humhub\modules\schedule\models;

use tracker\models\Issue;
use Yii;

/**
 * This is the model class for table "schedule_link_issues".
 *
 * @property integer $id
 * @property integer $schedule_id
 * @property integer $issues_id
 *
 * @property Issue $issues
 * @property ScheduleSchedule $schedule
 */
class ScheduleLinkIssues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule_link_issues}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'issues_id'], 'required'],
            [['schedule_id', 'issues_id'], 'integer'],
            [['issues_id'], 'exist', 'skipOnError' => true, 'targetClass' => Issue::className(), 'targetAttribute' => ['issues_id' => 'id']],
            [['schedule_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleSchedule::className(), 'targetAttribute' => ['schedule_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ScheduleModule.base', 'ID'),
            'schedule_id' => Yii::t('ScheduleModule.base', 'Schedule ID'),
            'issues_id' => Yii::t('ScheduleModule.base', 'Issues ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasOne(Issue::className(), ['id' => 'issues_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(ScheduleSchedule::className(), ['id' => 'schedule_id']);
    }
}
