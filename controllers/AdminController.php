<?php

namespace humhub\modules\schedule\controllers;

use humhub\modules\faculties\models\UniversityFaculties;
use humhub\modules\schedule\components\cellconstructor\constructors\SimmulateTableConstructor;
use humhub\modules\schedule\components\cellconstructor\constructors\TableConstructor;
use humhub\modules\schedule\components\cellconstructor\helpers\Helper;
use humhub\modules\schedule\models\ScheduleHeaders;
use humhub\modules\schedule\models\ScheduleSchedule;
use humhub\modules\schedule\notifications\ScheduleEdit;
use humhub\modules\schedule\permissions\ManageDailySchedule;
use humhub\modules\university\models\UniversityDiscipline;
use humhub\modules\university\models\UniversityStudyCourses;
use humhub\modules\university\models\UniversityTeachers;
use humhub\modules\user\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AdminController extends \humhub\modules\admin\components\Controller
{
    /**
     * @inheritdoc
     */
    public $adminOnly = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if(Yii::$app->user->identity->isSystemAdmin()){
            $this->subLayout = '@humhub/modules/schedule/views/layouts/_adminmain';
        } else {
            $this->subLayout = '@humhub/modules/schedule/views/layouts/_manageMain';
        }

        $this->appendPageTitle(Yii::t('ScheduleModule.base', 'Расписание занятий'));

        return parent::init();
    }

    public function getAccessRules()
    {
        return [
            ['permissions' => [
                ManageDailySchedule::className()
            ]],
        ];
    }

    public function actionAddAjax($faculty, $course = 1, $day, $couple, $group)
    {
        $model = new ScheduleSchedule();
        $currentFaculty = UniversityFaculties::findOne($faculty);
        $groupsLikeCourse = UniversityStudyCourses::findOne($course);

        if(Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->save()) {
                $this->view->saved();
                return $this->redirect(['/schedule/public/global', 'faculty' => $currentFaculty->id, 'course' => $groupsLikeCourse->id]);
            }
        }

        return $this->renderAjax('_modalCreate', [
            'model' => $model,
            'faculty' => $currentFaculty,
            'course' => $groupsLikeCourse,
            'day' => $day,
            'couple' => $couple,
            'group' => $group
        ]);

    }

    public function actionEditAjax($daily, $faculty, $course)
    {
        $model = ScheduleSchedule::findOne($daily);

        if(Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->save()){
                $this->view->saved();
                return $this->redirect(['/schedule/public/global', 'faculty' => $faculty, 'course' => $course]);
            }
        }

        return $this->renderAjax('_modalEdit', [
            'model' => $model,
        ]);

    }

    public function actionAddIssues($daily, $faculty, $course)
    {
        $model = ScheduleSchedule::findOne($daily);
        $model->scenario = ScheduleSchedule::SCENARIO_ISSUES;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->save()){
                $this->view->saved();
                return $this->redirect(['/schedule/public/global', 'faculty' => $faculty, 'course' => $course]);
            }
        }

        return $this->renderAjax('_issues', [
            'model' => $model
        ]);
    }

    public function actionDiscipline($id)
    {
        $disciplines = (new ScheduleSchedule())->getDisciplineToTeacherList($id);

        if (!empty($disciplines)) {
            foreach($disciplines as $discipline) {
                echo "<option value='".$discipline['id']."'>".$discipline['name']."</option>";
            }
        } else {
            echo "<option>-</option>";
        }
    }

    public function actionSubDiscipline()
    {
        if(isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if($parents[0] != null){
                $list = (new ScheduleSchedule())->getDisciplineToTeacherList($parents[0]);
                echo Json::encode(['output' => $list, 'selected'=> '']);
            } else {
                echo Json::encode(['output' => '', 'selected' => '']);
            }
        }
    }

    public function actionCourseSchedule($faculty, $course = 1)
    {
        $scheduleSearch = ScheduleSchedule::find()
            ->leftJoin('university_study_groups', 'schedule_schedule.study_group_id = university_study_groups.id')
            ->where(['university_study_groups.faculty_id' => $faculty])
            ->andWhere(['university_study_groups.course_id' => $course]);

        $dataProvider = new ActiveDataProvider([
            'query' => $scheduleSearch,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        /*$searchModel = new ScheduleSchedule();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['faculty_id' => $faculty])
            ->andWhere(['course_id' => $course]);*/


        return $this->render('indexCourseSchedule', [
            'searchModel' => $scheduleSearch,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHeader($faculty)
    {
        $model = ScheduleHeaders::findOne(['faculty_id' => $faculty]);

        if($model){
            $constructor = new SimmulateTableConstructor();

            $tree = $constructor->arrayTree(Json::decode($model->header));

            return $this->render('header', [
                'model' => $model,
                'faculty' => $faculty,
                'table' => $constructor->simmulateFlatTable($tree, true)
            ]);
        }

        return $this->render('header', [
            'model' => $model,
            'faculty' => $faculty,
        ]);

    }

    public function actionEditHeader($faculty)
    {
        $model = ScheduleHeaders::findOne(['faculty_id' => $faculty]);

        if($model == null){
            $model = new ScheduleHeaders();
        }

        if (Yii::$app->request->getIsPost()) {
            unset($_POST['_csrf']);
            $truePostArray = Helper::truePostArray($_POST);
            $constructor = new TableConstructor();
            $array = $constructor->getArrays($truePostArray);

            $model->faculty_id = $faculty;
            $model->header = Json::encode($array);

            if($model->validate() && $model->save()){
                return $this->redirect(['/schedule/admin/header', 'faculty' => $faculty]);
            } else {
                Helper::p($model->getErrors());
            }
        }

        return $this->render('_headerForm', [
            'model' => $model,
        ]);
    }

    public function actionHeaderPreview()
    {
        if(!Yii::$app->request->isPost){
            throw new BadRequestHttpException('Очень плохой запрос');
        }

        unset($_POST['_csrf']);
        $truePostArray = Helper::truePostArray($_POST);

        $constructor = new SimmulateTableConstructor();

        $data = $constructor->getArrays($truePostArray);
        $tree = $constructor->arrayTree($data);

        echo $table = $constructor->simmulateFlatTable($tree, true)->render();
    }

    public function actionHeaderArrayPreview()
    {
        if(!Yii::$app->request->isPost){
            throw new BadRequestHttpException('Очень плохой запрос');
        }

        unset($_POST['_csrf']);
        $truePostArray = Helper::truePostArray($_POST);

        $constructor = new SimmulateTableConstructor();

        $data = $constructor->getArrays($truePostArray);
        $tree = $constructor->arrayTree($data);
        Helper::p($tree);
    }

    /**
     * Render admin only page
     *
     * @return string
     */
    public function actionIndex()
    {
        $faculties = UniversityFaculties::find();
        $countFaculties = clone $faculties;
        $pagination = new \yii\data\Pagination(['totalCount' => $countFaculties, 'pageSize' => 10]);

        if (Yii::$app->request->post()) {
            $pagination->setPage(0);
        }

        $model = $faculties->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index',[
            'model' => $model,
            'pagination' => $pagination
        ]);

        /*$searchModel = new ScheduleSchedule();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
    }

    /**
     * Displays a single ScheduleSchedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ScheduleSchedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($faculty, $course = 1)
    {
        $model = new ScheduleSchedule();
        $currentFaculty = UniversityFaculties::findOne($faculty);
        $groupsLikeCourse = UniversityStudyCourses::findOne($course);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'faculty' => $currentFaculty,
                'course' => $groupsLikeCourse
            ]);
        }
    }

    /**
     * Updates an existing ScheduleSchedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            /* toDo: create light version redirect*/
            return $this->redirect(['course-schedule',
                'faculty' => $model->studyGroup->faculty_id,
                'course' => $model->studyGroup->course_id
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ScheduleSchedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Url::to('/schedule/public/global', ['faculty' => 1]));
    }

    public function actionDeleteAjax($id, $faculty, $course)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Url::to(['/schedule/public/global', 'faculty' => $faculty, 'course' => $course]));
    }

    public function actionDisciplineList()
    {
        if ($id = Yii::$app->request->post('id')) {
            if($disciplines = UniversityTeachers::find()
                ->all()){

                foreach ($disciplines as $discipline){
                    echo "<option value='" . $discipline->disciplines->id . "'>" . $discipline->disciplines->name . "</option>";
                }

            } else {
                echo "<option>-</option>";
            }
        } else {
            echo "<option>-</option>";
        }
    }

    /**
     * Finds the ScheduleSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ScheduleSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ScheduleSchedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

