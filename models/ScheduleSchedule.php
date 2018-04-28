<?php

namespace humhub\modules\schedule\models;

use humhub\components\ActiveRecord;
use humhub\modules\api\modules\rest\helpers\ArrayHelper;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\faculties\models\UniversityBuildingClassroom;
use humhub\modules\schedule\models\query\ScheduleActiveQuery;
use humhub\modules\schedule\notifications\ScheduleCreate;
use humhub\modules\schedule\notifications\ScheduleEdit;
use humhub\modules\university\models\UniversityDiscipline;
use humhub\modules\university\models\UniversityStudyGroups;
use humhub\modules\university\models\UniversityTeachers;
use humhub\modules\user\models\User;
use tracker\models\Issue;
use Yii;
use yii\bootstrap\Html;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "schedule_schedule".
 *
 * @property integer $id
 * @property integer $day_id
 * @property integer $couple_id
 * @property integer $teacher_id
 * @property integer $discipline_id
 * @property integer $study_group_id
 * @property integer $type_id
 * @property string $en_name
 * @property string $desc
 * @property integer $weekly_type_id
 * @property integer $classroom_id
 *
 * @property ScheduleLinkIssues[] $scheduleLinkIssues
 * @property ScheduleLinkSubgroups[] $scheduleLinkSubgroups
 * @property ScheduleAviableCouple $couple
 * @property ScheduleAviableDay $day
 * @property UniversityDiscipline $discipline
 * @property ScheduleLessonType $type
 * @property UniversityBuildingClassroom $classroom
 * @property ScheduleWeeklyType $weeklyType
 * @property UniversityStudyGroups $studyGroup
 * @property UniversityTeachers $teacher
 */
class ScheduleSchedule extends ActiveRecord
{
    public $notifyStudents = true;
    public $joinCouples = false;
    public $groupsAssigned = '';
    public $formSubgroup = '';
    public $formIssuees = '';

    const SCENARIO_ISSUES = 'issues';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule_schedule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day_id', 'couple_id', 'teacher_id', 'discipline_id', 'study_group_id', 'type_id', 'weekly_type_id', 'classroom_id'], 'required'],
            [['day_id', 'couple_id', 'teacher_id', 'discipline_id', 'study_group_id', 'type_id', 'weekly_type_id', 'classroom_id'], 'integer'],
            [['en_name'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 200],
            [['couple_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleAviableCouple::className(), 'targetAttribute' => ['couple_id' => 'id']],
            [['day_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleAviableDay::className(), 'targetAttribute' => ['day_id' => 'id']],
            [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => UniversityDiscipline::className(), 'targetAttribute' => ['discipline_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleLessonType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['classroom_id'], 'exist', 'skipOnError' => true, 'targetClass' => UniversityBuildingClassroom::className(), 'targetAttribute' => ['classroom_id' => 'id']],
            [['weekly_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleWeeklyType::className(), 'targetAttribute' => ['weekly_type_id' => 'id']],
            [['study_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => UniversityStudyGroups::className(), 'targetAttribute' => ['study_group_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => UniversityTeachers::className(), 'targetAttribute' => ['teacher_id' => 'id']],
            [['day_id', 'couple_id', 'study_group_id', 'weekly_type_id'], 'checkDayAndCouple'],
            [['teacher_id'], 'checkTeacher'],
            [['classroom_id'], 'checkClassroom'],
            ['notifyStudents', 'boolean'],
            ['joinCouples', 'boolean'],
            [['groupsAssigned', 'formIssuees'], 'safe'],
            ['formSubgroup', 'exist', 'skipOnError' => true, 'targetClass' => ScheduleSubgroups::className(), 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ScheduleModule.base', 'ID'),
            'day_id' => Yii::t('ScheduleModule.base', 'Day ID'),
            'couple_id' => Yii::t('ScheduleModule.base', 'Couple ID'),
            'teacher_id' => Yii::t('ScheduleModule.base', 'Teacher ID'),
            'discipline_id' => Yii::t('ScheduleModule.base', 'Discipline ID'),
            'study_group_id' => Yii::t('ScheduleModule.base', 'Study Group ID'),
            'type_id' => Yii::t('ScheduleModule.base', 'Type ID'),
            'en_name' => Yii::t('ScheduleModule.base', 'En Name'),
            'desc' => Yii::t('ScheduleModule.base', 'Desc'),
            'weekly_type_id' => Yii::t('ScheduleModule.base', 'Weekly Type ID'),
            'classroom_id' => Yii::t('ScheduleModule.base', 'Classroom ID'),
            'notifyStudents' => 'Оповестить студентов',
            'joinCouples' => 'Общие пары',
            'formIssuees' => 'Задачи'
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_ISSUES] = ['formIssuees'];

        return $scenarios;
    }

    public function groupLink(UniversityStudyGroups $group)
    {
        return Html::a('<i class="fa fa-link"></i> '.$group->displayName, ['/university/group/view', 'id' => $group->id], ['target' => '_blank']);
    }

    public function checkDayAndCouple($attribute, $params)
    {
        $query = self::find()->where(['day_id' => $this->day_id])
            ->andWhere(['couple_id' => $this->couple_id])->andWhere(['weekly_type_id' => $this->weekly_type_id])
            ->andWhere(['study_group_id' => $this->study_group_id]);

        if(!empty($this->formSubgroup)){
            $query->joinWith('scheduleLinkSubgroups sls')
                ->andWhere(['sls.subgroup_id' => $this->formSubgroup]);
        }

        $groups = clone $query;

        if($query->exists()){
            $n = 0;
            foreach ($groups->group([])->all() as $group){
                $message[] = $this->groupLink($group->studyGroup);
                $n++;
            }

            $this->addError('couple_id', \Yii::t('ScheduleModule.base', 'В {n, plural, =0{группе} =1{группе} other{# группах}} : {groups}', [
                'n' => $n,
                'groups' => implode(', ', $message)
            ]));

            $this->addError('day_id', 'Данный день и пара уже заняты!');
            $this->addError('weekly_type_id', 'На данную неделю!');
            $this->addError('study_group_id', 'Для этой группы!');

            if(!empty($this->formSubgroup)){
                $this->addError('formSubgroup', 'Для этой подгруппы!');
            }
        }

    }

    public function checkTeacher($attribute, $params)
    {
        $query = self::find()->where(['day_id' => $this->day_id])
            ->andWhere(['couple_id' => $this->couple_id])
            ->andWhere(['weekly_type_id' => $this->weekly_type_id])
            ->andWhere(['teacher_id' => $this->teacher_id]);

        $groups = clone $query;

        if($query->exists()){
            if(!$this->joinCouples){
                $n = 0;
                foreach ($groups->group(['displayName'])->all() as $group){
                    $message[] = $this->groupLink($group->studyGroup);
                    $n++;
                }
                $this->addError('teacher_id', \Yii::t('ScheduleModule.base', 'В {n, plural, =0{группе} =1{группе} other{# группах}} : {groups}', [
                    'n' => $n,
                    'groups' => implode(', ', $message)
                ]));
            }
        }
    }

    public function checkClassroom($attribute, $params)
    {
        $query = self::find()->where(['day_id' => $this->day_id])
            ->andWhere(['couple_id' => $this->couple_id])
            ->andWhere(['weekly_type_id' => $this->weekly_type_id])
            ->andWhere(['classroom_id' => $this->classroom_id]);

        $groups = clone $query;

        if($query->exists()){
            if(!$this->joinCouples) {
                $n = 0;
                foreach ($groups->group(['displayName'])->all() as $group){
                    $message[] = $this->groupLink($group->studyGroup);
                    $n++;
                }
                $this->addError('classroom_id', \Yii::t('ScheduleModule.base', 'В {n, plural, =0{группе} =1{группе} other{# группах}} : {groups}', [
                    'n' => $n,
                    'groups' => implode(', ', $message)
                ]));
            }
        }
    }

    public function afterFind()
    {
        foreach ($this->studyGroup as $group){
            $this->groupsAssigned[] = $group->id;
        }

        if (!empty($this->id)) {
            $row = ScheduleLinkSubgroups::find()->select(['subgroup_id'])->where(['schedule_id' => $this->id])
                ->asArray()
                ->one();

            $this->formSubgroup = $row['subgroup_id'];

            $issues = ScheduleLinkIssues::find()->select(['issues_id'])
                ->where(['schedule_id' => $this->id])
                ->asArray()
                ->all();

            foreach($issues as $issue) {
                $this->formIssuees[] = $issue['issues_id'];
            }
        }

        parent::afterFind();
    }


    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    /**
     * toDo remethod to beforeSave for check new Record
     *
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if(!$this->scenario == self::SCENARIO_ISSUES){
            if(is_array($this->groupsAssigned)){
                foreach ($this->groupsAssigned as $assignee){
                    $this->study_group_id = $assignee;
                    $this->save();
                }
            }

            if ($this->formSubgroup) {

                $linkRelated = ScheduleLinkSubgroups::find()->where(['schedule_id' => $this->id])->all();

                foreach ($linkRelated as $item) {
                    $item->delete();
                }

                //foreach($this->formSubgroup as $subGroup) {
                $pc = new ScheduleLinkSubgroups();
                $pc->schedule_id = $this->id;
                $pc->subgroup_id = $this->formSubgroup;
                $pc->save();
                //}
            }

            if($this->notifyStudents){

                $currentUser = \Yii::$app->user->getIdentity();

                /**
                 * toDo: notification type fix
                 */
                if($this->isNewRecord){
                    $notification = new ScheduleCreate();
                } else {
                    $notification = new ScheduleEdit();
                }

                $users = User::find()->leftJoin('schedule_user_link sul', 'user.id = sul.user_id')
                    ->where(['sul.study_group_id' => $this->study_group_id])
                    ->all();

                $notification->source = $this;
                $notification->originator = $currentUser;

                foreach ($users as $user){
                    /** @var User $user */
                    $notification->send($user);
                }
            }
        } elseif($this->scenario == self::SCENARIO_ISSUES) {
            if(is_array($this->formIssuees)){

                $issuesRelated = ScheduleLinkIssues::find()->where(['schedule_id' => $this->id])->all();

                foreach ($issuesRelated as $item){
                    $item->delete();
                }

                foreach($this->formIssuees as $issue) {
                    $pc = new ScheduleLinkIssues();
                    $pc->schedule_id = $this->id;
                    $pc->issues_id = $issue;
                    $pc->save();
                }
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public static function find()
    {
        return new ScheduleActiveQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLinkIssues()
    {
        return $this->hasMany(ScheduleLinkIssues::className(), ['schedule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLinkSubgroups()
    {
        return $this->hasMany(ScheduleLinkSubgroups::className(), ['schedule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubgroups()
    {
        return $this->hasMany(ScheduleSubgroups::className(), ['id' => 'subgroup_id'])
            ->viaTable(ScheduleLinkSubgroups::tableName(), ['schedule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouple()
    {
        return $this->hasOne(ScheduleAviableCouple::className(), ['id' => 'couple_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDay()
    {
        return $this->hasOne(ScheduleAviableDay::className(), ['id' => 'day_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscipline()
    {
        return $this->hasOne(UniversityDiscipline::className(), ['id' => 'discipline_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ScheduleLessonType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassroom()
    {
        return $this->hasOne(UniversityBuildingClassroom::className(), ['id' => 'classroom_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeeklyType()
    {
        return $this->hasOne(ScheduleWeeklyType::className(), ['id' => 'weekly_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudyGroup()
    {
        return $this->hasOne(UniversityStudyGroups::className(), ['id' => 'study_group_id']);
    }

    public function getStudyGroups()
    {
        return $this->hasMany(UniversityStudyGroups::className(), ['id' => 'study_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(UniversityTeachers::className(), ['id' => 'teacher_id']);
    }

    /**
     * @return array
     */
    public function getTeacherList()
    {
        return ArrayHelper::map(UniversityTeachers::find()
            ->with('user')->all(), 'id', 'user.displayName');
    }

    /**
     * @return array[]
     */
    public function getStudyGroupList($faculty, $course, $group = null)
    {
        $groupQuery = UniversityStudyGroups::find();

        if(!empty($group)){
            $groupQuery->where(['id' => $group]);
        }

        return ArrayHelper::map($groupQuery->andWhere(['faculty_id' => $faculty])->andWhere(['course_id' => $course])->asArray()->all(), 'id', 'displayName');
    }

    /**
     * @return array[]
     */
    public function getWeeklyTypeList()
    {
        return ArrayHelper::map(ScheduleWeeklyType::find()->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array[]
     */
    public function getTypeList()
    {
        return ArrayHelper::map(ScheduleLessonType::find()->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array[]
     */
    public function getDisciplineList($currentTeacher = null)
    {
        $query = UniversityDiscipline::find();

        if(!empty($currentTeacher)){
            $query->leftJoin('university_teacher_discipline utd', 'university_discipline.id = utd.discipline_id')
                ->where(['utd.teacher_id' => $currentTeacher]);
        }

        return ArrayHelper::map($query->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array[]
     */
    public function getDisciplineToTeacherList($teacher)
    {
        return UniversityDiscipline::find()->select(['university_discipline.id', 'name'])
            ->leftJoin('university_teacher_discipline utd', 'university_discipline.id = utd.discipline_id')
            ->where(['utd.teacher_id' => $teacher])
            ->asArray()->all();
    }

    /**
     * @return array[]
     */
    public function getDayList($day = null)
    {
        $query = ScheduleAviableDay::find();

        if(!empty($day)){
            $query->where(['id' => $day]);
        }

        return ArrayHelper::map($query->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array[]
     */
    public function getCoupleList($couple = null)
    {
        $query = ScheduleAviableCouple::find();

        if(!empty($couple)){
            $query->where(['id' => $couple]);
        }

        return ArrayHelper::map($query->asArray()->all(), 'id', 'displayName');
    }

    public function getIssuesList()
    {
        return ArrayHelper::map(Issue::find()->all(), 'id', 'title');
    }

    /**
     * @return $this
     */
    public function getScheduleIssues()
    {
        return $this->hasMany(Issue::className(), ['id' => 'issues_id'])
            ->viaTable(ScheduleLinkIssues::tableName(), ['schedule_id' => 'id']);
    }

    /**
     * @return array[]
     */
    public function getClassroomList()
    {
        return ArrayHelper::map(UniversityBuildingClassroom::find()->all(), 'id', 'displayRoom');
    }

}
