<?php

namespace humhub\modules\schedule\controllers;

use humhub\components\Controller;
use humhub\modules\faculties\models\UniversityFaculties;
use humhub\modules\schedule\components\cellconstructor\constructors\TableConstructor;
use humhub\modules\schedule\components\cellconstructor\constructors\ExtendedTableConstructor;
use humhub\modules\schedule\components\cellconstructor\helpers\Helper;
use humhub\modules\schedule\models\ScheduleHelper;
use humhub\modules\schedule\models\ScheduleAviableCouple;
use humhub\modules\schedule\models\ScheduleAviableDay;
use humhub\modules\schedule\models\ScheduleSchedule;
use humhub\modules\specialities\models\UniversitySpecialitiesProfiles;
use humhub\modules\university\models\ScheduleUserLink;
use humhub\modules\university\models\UniversityStudyGroups;
use humhub\modules\university\models\UniversityTeachers;
use yii\base\InvalidParamException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\NotFoundHttpException;

class PublicController extends Controller
{
    public $subLayout = '@humhub/modules/schedule/views/layouts/_main';

    public function init()
    {
        $this->appendPageTitle(Yii::t('ScheduleModule.base', 'Расписание занятий'));
        parent::init();
    }

    public function actionIndex()
    {
        $faculties = UniversityFaculties::find()->all();

        return $this->render('index', [
            'faculties' => $faculties
        ]);
    }

    public function actionAbout()
    {
        $this->subLayout = '@humhub/modules/schedule/views/layouts/_global';
        return $this->render('about');
    }

    public function actionAboutSchedule()
    {
        $this->subLayout = '@humhub/modules/schedule/views/layouts/_global';
        return $this->render('about-schedule');
    }

    /**
     * ToDo: create query service for filtering and matching
     */
    public function actionGlobal($faculty, $course = 1, $profile = null, $group = null)
    {
        $request = Yii::$app->request;

        $studyGroups = UniversityStudyGroups::find()->where(['faculty_id' => $faculty])->andWhere(['course_id' => $course]);
        $days = ScheduleAviableDay::find();
        $couples = ScheduleAviableCouple::find();

        if ($groupIds = $request->post('groups', [])) {
            $studyGroups->andWhere(['in', 'id', $groupIds]);
        }

        if ($profileIds = $request->post('profiles', [])) {
            $studyGroups->andWhere(['in', 'profile_id', $profileIds]);
        }

        if ($specialityIds = $request->post('specialities', [])) {
            $studyGroups->leftJoin(
                UniversitySpecialitiesProfiles::tableName().' sp',
                'sp.id = '.UniversityStudyGroups::tableName().'.profile_id'
            )->andWhere(['in', 'sp.speciality_id', $specialityIds]);
        }

        if ($groupAllIds = $request->post('groupsAll', [])) {
            $studyGroups->andWhere(['in', 'id', $groupAllIds]);
        }

        $countGroups = clone $studyGroups;

        if(!$count = $countGroups->count()){
            return $this->render('notFoundStudyGroups', []);
        }

        $pagination = new \yii\data\Pagination(['totalCount' => $count, 'pageSize' => 6]);

        if ($request->post() && (empty($request->getQueryParam('page')))) {
            $pagination->setPage(0);
        }

        if ($daysIds = $request->post('days', [])) {
            $days->andWhere(['in', 'id', $daysIds]);
        }

        if ($couplesIds = $request->post('couples', [])) {
            $couples->andWhere(['in', 'id', $couplesIds]);
        }

        if ($weeklyIds = $request->post('weekly', [])) {
            ScheduleHelper::$weekly = $weeklyIds;
        }

        if ($typesIds = $request->post('types', [])) {
            ScheduleHelper::$types = $typesIds;
        }

        if ($disciplineIds = $request->post('disciplines', [])) {
            ScheduleHelper::$disciplines = $disciplineIds;
        }

        if ($classroomIds = $request->post('classrooms', [])) {
            ScheduleHelper::$classrooms = $classroomIds;
        }

        if ($teacherIds = $request->post('teachers', [])) {
            ScheduleHelper::$teachers = $teacherIds;
        }

        $studyGroups->offset($pagination->offset)->limit($pagination->limit);

        if($profile && (is_numeric($profile) && $profile > 0)){
            $studyGroups->andWhere(['profile_id' => $profile]);
        } elseif($group && (is_numeric($group) && $group > 0)){
            $studyGroups->andWhere(['id' => $group]);
        } elseif($profile && $group){
            throw new NotFoundHttpException('Хитро, очень хитро(нет), Вы решили сломать меня?');
        }

        $this->subLayout = '@humhub/modules/schedule/views/layouts/_global';

        $schedule = new ScheduleHelper();
        $constructor = new TableConstructor();

        $schelduleArray = [];
        $dayCounter = 0;

        foreach ($days->all() as $day){
            /** @var ScheduleAviableDay $day */
            $rand = $day->id + rand(1, 1000);
            $schelduleArray[$day->id]['id'] = $rand;
            $schelduleArray[$day->id]['name'] = $day->name;
            $schelduleArray[$day->id]['internal_key'] = 0;
            $schelduleArray[$day->id]['field_name'] =  $day->nameWithDate($dayCounter);
            $schelduleArray[$day->id]['sort_order'] = $day->id;
            $schelduleArray[$day->id]['identityDayKey'] = $day->identity;

            foreach($couples->all() as $couple) {
                /**@var ScheduleAviableCouple $couple */
                $useCoupleNumbers = false;
                $coupleParents = [];

                if($useCoupleNumbers){
                    $coupleHead = $coupleParents[] = $schedule->getAviableCoupleHead($rand, $couple);
                    $couplesArray[] = $schedule->getAviableCouple($coupleHead['id'], $day->identity, $couple);
                } else {
                    $couplesArray[] = $schedule->getAviableCouple($rand, $day->identity, $couple);
                }
            };

            $dayCounter++;
        }

        $schelduleArray = $constructor->arrayTree($constructor->getArrays(ArrayHelper::merge($schelduleArray, $coupleParents, $couplesArray)));

        foreach($schedule->getHeader() as $header){
            $headerArray[$header['id']]['id'] = $header['id'];
            $headerArray[$header['id']]['name'] = $header['name'];
            $headerArray[$header['id']]['internal_key'] = $header['internal_key'];
            $headerArray[$header['id']]['field_name'] = Helper::brackets($header['field_name']);
            $headerArray[$header['id']]['sort_order'] = $header['id'];
            $headerArray[$header['id']]['center'] = 1;
        }

        $lastHeaderLevel = $constructor->getArrayTreeLastLevelElements($constructor->arrayTree($constructor->getArrays($headerArray)));

        foreach ($lastHeaderLevel as $item){
            foreach($studyGroups->all() as $group) {
                $parentHead = $groupsHead[] = $schedule->getAviableGroupsHead($item['id'], $group);
                $groupsArray[] = $schedule->getAviableGroup($parentHead['id'], $group);
            };
        }

        $header = $constructor->arrayTree($constructor->getArrays(ArrayHelper::merge($headerArray, $groupsHead, $groupsArray)));

        $table = $constructor->drawScheduleTable($header, $schelduleArray, true);

        return $this->render('global', [
            'table' => $table,
            'pagination' => $pagination,
            'days' => $daysIds,
            'couples' => $couplesIds,
            'weekly' => $weeklyIds,
            'types' => $typesIds,
            'disciplines' => $disciplineIds,
            'teachers' => $teacherIds,
            'groups' => $groupIds,
            'groupsAll' => $groupAllIds,
            'classrooms' => $classroomIds,
            'profiles' => $profileIds,
            'specialities' => $specialityIds
        ]);
    }

    public function actionGlobalAlternative($faculty, $course = 1, $group = null)
    {
        $days = ScheduleAviableDay::find();
        $couples = ScheduleAviableCouple::find();

        if(empty($group)){
            $userGroup = ScheduleUserLink::find()->alias('ul')
                ->select(['ul.study_group_id', 'ul.faculty_id', 'ul.user_id', 'usg.id', 'usg.course_id'])
                ->joinWith(['studyGroup usg'])
                ->where(['ul.user_id' => Yii::$app->user->id])
                ->andWhere(['usg.course_id' => $course, 'ul.faculty_id' => $faculty])->one();

            if($userGroup){
                $group = $userGroup->study_group_id;
            } else {
                $facultyGroups = UniversityStudyGroups::find()->select(['id'])
                    ->where(['faculty_id' => $faculty, 'course_id' => $course])->one();

                $group = $facultyGroups->id;
            }
        }

        if(!$group){
            throw new NotFoundHttpException('Для вас нет расписания! Вимдимо вы забыи указать учебную группу');
        }

        $this->subLayout = '@humhub/modules/schedule/views/layouts/_globalAlternative';

        if(!$studyGroup = UniversityStudyGroups::findOne($group)){
            return $this->render('notFoundStudyGroups', []);
        }

        $request = Yii::$app->request;

        if ($daysIds = $request->post('days', [])) {
            $days->andWhere(['in', 'id', $daysIds]);
        }

        if ($couplesIds = $request->post('couples', [])) {
            $couples->andWhere(['in', 'id', $couplesIds]);
        }

        if ($weeklyIds = $request->post('weekly', [])) {
            ScheduleHelper::$weekly = $weeklyIds;
        }

        if ($typesIds = $request->post('types', [])) {
            ScheduleHelper::$types = $typesIds;
        }

        if ($disciplineIds = $request->post('disciplines', [])) {
            ScheduleHelper::$disciplines = $disciplineIds;
        }

        if ($teacherIds = $request->post('teachers', [])) {
            ScheduleHelper::$teachers = $teacherIds;
        }

        $schedule = new ScheduleHelper();
        $constructor = new ExtendedTableConstructor();
        $dayCounter = 0;

        foreach ($days->all() as $day){
            /** @var ScheduleAviableDay $day */
            $schelduleArray[$day->id]['id'] = $day->id;
            $schelduleArray[$day->id]['name'] = $day->name;
            $schelduleArray[$day->id]['internal_key'] = 0;
            $schelduleArray[$day->id]['field_name'] = $day->nameWithDate($dayCounter);
            $schelduleArray[$day->id]['sort_order'] = $day->id;
            $schelduleArray[$day->id]['identityDayKey'] = $day->identity;

            foreach ($couples->all() as $couple) {
                /**@var ScheduleAviableCouple $couple */
                $couplesArray[] = $schedule->getAviableStaticCouple($couple);
            };

            $dayCounter++;
        }

        $coupleTree = $constructor->arrayTree($constructor->getArrays($couplesArray));
        $dayTree = $constructor->arrayTree($constructor->getArrays($schelduleArray));

        $table = $constructor->drawScheduleTable($dayTree, $coupleTree, $group,true, 'Пары | Дни недели');

        return $this->render('globalAlternative', [
            'table' => $table,
            'group' => $studyGroup,
            'days' => $daysIds,
            'couples' => $couplesIds,
            'weekly' => $weeklyIds,
            'types' => $typesIds,
            'disciplines' => $disciplineIds,
            'teachers' => $teacherIds,
            'userGroup' => $group
        ]);
    }

    public function actionViewAjax($day, $couple, $group, $discipline)
    {
        $dayInfo = ScheduleAviableDay::find()->where(['id' => $day])->one();
        $coupleInfo = ScheduleAviableCouple::find()->where(['id' => $couple])->one();
        $groupInfo = UniversityStudyGroups::find()->where(['id' => $group])->one();
        $disciplineInfo = ScheduleSchedule::find()->where(['id' => $discipline])->one();

        return $this->renderAjax('ajax', [
            'dayInfo' => $dayInfo,
            'coupleInfo' => $coupleInfo,
            'groupInfo' => $groupInfo,
            'discipline' => $disciplineInfo
        ]);
    }

    public function actionViewDescAjax($discipline)
    {
        $desc = ScheduleSchedule::findOne($discipline);

        return $this->renderAjax('_desc', [
            'description' => $desc
        ]);
    }

    public function actionTeacherAjax($id)
    {
        return $this->renderAjax('_teacher', [
            'teacher' => UniversityTeachers::findOne($id)
        ]);
    }

    public function actionGroupInformation($id)
    {
        return $this->renderAjax('_group', [
            'group' => UniversityStudyGroups::findOne($id)
        ]);
    }
}
