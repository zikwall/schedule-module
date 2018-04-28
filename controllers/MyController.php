<?php

namespace humhub\modules\schedule\controllers;

use humhub\modules\api\modules\rest\helpers\ArrayHelper;
use humhub\modules\schedule\components\cellconstructor\constructors\TableConstructor;
use humhub\modules\schedule\components\cellconstructor\constructors\ExtendedTableConstructor;
use humhub\modules\schedule\components\cellconstructor\helpers\Helper;
use humhub\modules\schedule\models\ScheduleHelper;
use humhub\modules\schedule\models\ScheduleAviableCouple;
use humhub\modules\schedule\models\ScheduleAviableDay;
use humhub\modules\schedule\models\ScheduleSchedule;
use humhub\modules\university\models\ScheduleUserLink;
use humhub\modules\university\models\UniversityStudyGroups;
use Yii;
use humhub\modules\user\models\User;
use yii\base\InvalidCallException;
use yii\web\NotFoundHttpException;

class MyController extends \humhub\modules\content\components\ContentContainerController
{

    public $hideSidebar = true;
    public $subLayout = "@humhub/modules/schedule/views/layouts/_schedule";

    public $userGroup;

    public function init()
    {
        return parent::init();
    }

    public function actionIndex()
    {
        if(!$this->contentContainer instanceof User){
            throw new InvalidCallException('Не правильный контейнер');
        }

        $group = ScheduleUserLink::find()->where(['user_id' => $this->contentContainer->id])->one();
        $this->userGroup = $group->study_group_id;

        $days = ScheduleAviableDay::find();
        $couples = ScheduleAviableCouple::find();

        if(!$this->userGroup){
            return $this->render('notScheduleForYou');
        }

        if(!$studyGroup = UniversityStudyGroups::findOne($this->userGroup)){
            return $this->render('notFoundStudyGroups', []);
        }

        if ($daysIds = Yii::$app->request->post('days', [])) {
            $days->andWhere(['in', 'id', $daysIds]);
        }

        if ($couplesIds = Yii::$app->request->post('couples', [])) {
            $couples->andWhere(['in', 'id', $couplesIds]);
        }

        if ($weeklyIds = Yii::$app->request->post('weekly', [])) {
            ScheduleHelper::$weekly = $weeklyIds;
        }

        if ($disciplineIds = Yii::$app->request->post('disciplines', [])) {
            ScheduleHelper::$disciplines = $disciplineIds;
        }

        if ($teacherIds = Yii::$app->request->post('teachers', [])) {
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
            $schelduleArray[$day->id]['field_name'] =  $day->nameWithDate($dayCounter);
            $schelduleArray[$day->id]['sort_order'] = $day->id;
            $schelduleArray[$day->id]['identityDayKey'] = $day->identity;

            $schelduleArrayActions[] = $schedule->getDayActions($day);

            foreach ($couples->all() as $couple) {
                /**@var ScheduleAviableCouple $couple */
                $couplesArray[] = $schedule->getAviableStaticCouple($couple);
            };

            $dayCounter++;
        }

        $header = $constructor->arrayTree($constructor->getArrays(ArrayHelper::merge($schelduleArray, $schelduleArrayActions)));

        $coupleTree = $constructor->arrayTree($constructor->getArrays($couplesArray));
        $dayTree = $constructor->arrayTree($constructor->getArrays($header));

        $table = $constructor->drawScheduleTable($dayTree, $coupleTree, $this->userGroup,true, 'Пары | Дни недели');

        return $this->render('index', [
            'table' => $table,
            'group' => $studyGroup,
            'days' => $daysIds,
            'couples' => $couplesIds,
            'weekly' => $weeklyIds,
            'disciplines' => $disciplineIds,
            'teachers' => $teacherIds,
            'userGroup' => $this->userGroup
        ]);
    }

    public function actionAlternative()
    {
        if(!$this->contentContainer instanceof User){
            throw new InvalidCallException('Не правильный контейнер');
        }

        $group = ScheduleUserLink::find()->where(['user_id' => $this->contentContainer->id])->one();
        $this->userGroup = $group->study_group_id;

        $days = ScheduleAviableDay::find();
        $couples = ScheduleAviableCouple::find();

        if(!$this->userGroup){
            return $this->render('notScheduleForYou');
        }

        if(!$studyGroup = UniversityStudyGroups::findOne($this->userGroup)){
            return $this->render('notFoundStudyGroups', []);
        }

        if ($daysIds = Yii::$app->request->post('days', [])) {
            $days->andWhere(['in', 'id', $daysIds]);
        }

        if ($couplesIds = Yii::$app->request->post('couples', [])) {
            $couples->andWhere(['in', 'id', $couplesIds]);
        }

        if ($weeklyIds = Yii::$app->request->post('weekly', [])) {
            ScheduleHelper::$weekly = $weeklyIds;
        }

        if ($disciplineIds = Yii::$app->request->post('disciplines', [])) {
            ScheduleHelper::$disciplines = $disciplineIds;
        }

        if ($teacherIds = Yii::$app->request->post('teachers', [])) {
            ScheduleHelper::$teachers = $teacherIds;
        }

        $schedule = new ScheduleHelper();
        $constructor = new ExtendedTableConstructor();

        $x = 1;
        $dayCounter = 0;

        foreach ($days->all() as $day){
            /** @var ScheduleAviableDay $day */
            $schelduleArray[$day->id]['id'] = $day->id;
            $schelduleArray[$day->id]['name'] = $day->name;
            $schelduleArray[$day->id]['internal_key'] = 0;
            $schelduleArray[$day->id]['field_name'] = $day->headerNameWithDate($dayCounter);
            $schelduleArray[$day->id]['sort_order'] = $day->id;
            $schelduleArray[$day->id]['identityDayKey'] = $day->identity;

            foreach ($couples->all() as $couple) {
                /**@var ScheduleAviableCouple $couple */
                $couplesArray[] = $schedule->getAviableStaticFlatCouple($couple, $x);
                $x++;
                $dayCounter++;
            };

            $coupleTree = $constructor->arrayTree($constructor->getArrays($couplesArray));
            $dayTree = $constructor->arrayTree($constructor->getArrays($schelduleArray));

            $tableObjects[] = (new ExtendedTableConstructor())->drawScheduleTable($dayTree, $coupleTree, $this->userGroup, true, 'Пары | День');

            unset($schelduleArray);
            unset($couplesArray);
        }

        return $this->render('index2', [
            'tableObjects' => $tableObjects,
            'group' => $studyGroup,
            'days' => $daysIds,
            'couples' => $couplesIds,
            'weekly' => $weeklyIds,
            'disciplines' => $disciplineIds,
            'teachers' => $teacherIds,
            'userGroup' => $this->userGroup
        ]);

    }

}
