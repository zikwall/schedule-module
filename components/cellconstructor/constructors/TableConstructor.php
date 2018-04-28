<?php

namespace humhub\modules\schedule\components\cellconstructor\constructors;

use Donquixote\Cellbrush\Table\Table;
use humhub\modules\api\modules\rest\helpers\ArrayHelper;
use humhub\modules\schedule\components\cellconstructor\ConstructorComponent;
use humhub\modules\schedule\components\cellconstructor\constructors\interfaces\ConstructorInterface;
use humhub\modules\schedule\components\cellconstructor\helpers\EditableHelper;
use humhub\modules\schedule\components\cellconstructor\helpers\Helper;
use humhub\modules\schedule\models\ScheduleHelper;
use humhub\modules\schedule\models\ScheduleAviableCouple;
use humhub\modules\schedule\models\ScheduleAviableDay;
use humhub\modules\schedule\models\ScheduleSchedule;
use humhub\modules\schedule\permissions\ManageDailySchedule;
use humhub\modules\university\models\UniversityStudyGroups;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use Yii;

class TableConstructor extends ConstructorComponent implements ConstructorInterface
{
    use ArrayableTrait;

    /**
     * @var array
     */
    public $upHierarchy = [];

    /**
     * @var array
     */
    public $leftHierarchy = [];

    public function drawScheduleCells($upTree, $leftTree, $isEditable = true, $isManagerMode)
    {
        $matrixElementsStorange = [];

        foreach ($this->getArrayTreeLastLevelElements($upTree) as $ordinatesAxis => $yAxisElement){
            foreach($this->getArrayTreeLastLevelElements($leftTree) as $abscissaeAxis => $xAxisElement){
                if($xAxisElement['isNullRow'] == 1 || $xAxisElement['heading'] == 1){
                    $matrixElementsStorange[$xAxisElement['id'].$yAxisElement['id']]['hpath'] = trim($yAxisElement['path']);
                    $matrixElementsStorange[$xAxisElement['id'].$yAxisElement['id']]['vpath'] = trim($xAxisElement['path']);
                    if($isEditable){
                        /**
                         * @var [] $identityArray url parametres
                         */
                        $identityArray = [
                            'identityCoupleKey' => $xAxisElement['identityCoupleKey'],
                            'identityDayKey' => $xAxisElement['identityDayToCoupleKey'],
                            'identityGroup' => $yAxisElement['id']
                        ];

                        $matrixElementsStorange[$xAxisElement['id'].$yAxisElement['id']]['identity'] = $identityArray;
                    }
                }
            }
        }

        //$uniqueMatrixElements = array_unique($matrixElementsStorange);

        $reformedMatrix = [];

        foreach($matrixElementsStorange as $item){
            $reformedMatrix[] = [
                'vpath' => $item['vpath'],
                'hpath' => $item['hpath'],
                'value' => $this->drawScheduleCell($item['identity'], [], $isManagerMode)
            ];
        }

        return $reformedMatrix;
    }

    /**
     * Метод создает ячейки с расписанием
     *
     * TODO: NEED customize!
     *
     * @param $scheduleData
     * @param $classAttr
     * @return string
     */
    public function drawScheduleCell($cellItem = [], $cellOptions = [], $editable = false)
    {
        $disciplinesCell = '';

        $day = ScheduleAviableDay::find()->select(['id'])->where(['identity' => $cellItem['identityDayKey']])->one();
        $couple = ScheduleAviableCouple::find()->select(['id'])->where(['identity' => $cellItem['identityCoupleKey']])->one();
        $group = UniversityStudyGroups::find()->select(['id'])->where(['id' => $cellItem['identityGroup']])->one();

        $editableCellActions = '';

        foreach (ScheduleHelper::getDailyDisciplines($day->id, $couple->id, $group->id) as $dailyDiscipline) {
            /** @var ScheduleSchedule $dailyDiscipline */
            $disciplinesCell .= $this->drawDailyDiscipline($dailyDiscipline);
        }

        if($editable){
            if($this->can(new ManageDailySchedule())){
                $course = Yii::$app->request->getQueryParam('course');
                $editableCellActions = $this->render('@humhub/modules/schedule/views/public/_manageTool', [
                    'course' => !empty($course) ? $course : 1,
                    'day' => $day->id,
                    'couple' => $couple->id,
                    'group' => $group->id
                ]);
            }
        }

        return $editableCellActions . $disciplinesCell;

    }

    /**
     * TODO: NEED customize!
     *
     * @param ScheduleSchedule $dailyDiscipline
     * @param int $template
     * @return string
     */
    public function drawDailyDiscipline(ScheduleSchedule $dailyDiscipline, $template = 1)
    {
        $classesCellString = '';

        /**
         * toDo: create discipline templates
         */
        if($template == 1) {

            $classesCellString = $this->render('@humhub/modules/schedule/views/public/_discipline', [
                'dailyDiscipline' => $dailyDiscipline
            ]);
        }

        return $classesCellString;
    }

    public function drawScheduleTable($upHierarchy, $leftHierarchy, $editTable = false, $openEndColsText = 'Дни недели | время | группы', $managerMode = false)
    {
        $openEndCols = [];

        if($upHierarchy == null || !is_array($upHierarchy)){
            throw new InvalidParamException('Вверхняя иерархия пуста или не массив!');
        }

        if($leftHierarchy == null || !is_array($leftHierarchy)){
            throw new InvalidParamException('Боковая иерархия пуста или не массив!');
        }

        $colNames = $this->initUpHierarchy($upHierarchy);
        $rowHierarchy = $this->initLeftHierarchy($leftHierarchy);

        $table = new Table();

        $rowGroupName = 'g';
        $rowGroupNames = [$rowGroupName];

        for ($i = 0; $i < EditableHelper::depth($colNames); ++$i) {
            $table->thead()->addRow($rowGroupName . '.caption');
            $rowGroupName .= '.g';
            $rowGroupNames[] = $rowGroupName;
        }
        $table->thead()->addRow($rowGroupName);

        for ($i = 0; $i <= EditableHelper::depth($rowHierarchy); $i++) {
            $openEndCols[] = $i;
        }

        $table->addColNames($openEndCols);
        $table->thead()->thOpenEnd('g', 0, $openEndColsText)->addCellClass('g', 0, 'center');

        foreach ($rowHierarchy as $row => $isLeaf){
            $table->addRow($row);
            $table->thOpenEnd($row, $isLeaf['level'], $isLeaf['name']);
            if($isLeaf['isNullRow'] == 0 || $isLeaf['heading'] == 0){
                $table->tbody()->addCellClass($row, $isLeaf['level'], 'center maxWidth');
            }
        }

        foreach ($colNames as $colName => $isLeaf) {
            $table->addColName($colName);
            $depth = substr_count($colName, '.');
            $rowGroupName = $rowGroupNames[$depth];
            $rowName = $isLeaf['leaf']
                ? $rowGroupName
                : $rowGroupName . '.caption';
            $table->thead()->th($rowName, $colName, $isLeaf['name'])->addCellClass($rowName, $colName,'center');
        }

        if($editTable){

            if(Yii::$app->request->getQueryParam('manager') == 1){
                $managerMode = true;
            }

            $contentContainermMatrixStorange = $this->drawScheduleCells($upHierarchy, $leftHierarchy, $editTable, $managerMode);

            foreach ($contentContainermMatrixStorange as $matrixContent){
                $table->tbody()->td($matrixContent['vpath'], $matrixContent['hpath'], $matrixContent['value']);
                if(!empty($matrixContent['class'])){
                    $table->addCellClass($matrixContent['vpath'], $matrixContent['hpath'], $matrixContent['class']);
                }
            }
        }

        $table->addClass('table table-bordered table-hover');

        return $table;
    }

    /**
     * @param $upContent
     * @return array
     */
    public function initUpHierarchy($upContent)
    {
        foreach ($upContent as $els => $el) {
            $this->upHierarchy[trim($el['path'])] = is_array($el['childs'])
                ? [
                    'leaf' => false,
                    'name' => $el['field_name'],
                    'identity' => $el['id'],
                    'level' => Helper::level($el['path']),
                    'up_path' => $el['path']
                ]
                : [
                    'leaf' => true,
                    'name' => $el['field_name'],
                    'identity' => $el['id'],
                    'level' => Helper::level($el['path']),
                    'up_path' => $el['path']
                ];

            if (isset($el['childs'])) {
                $this->initUpHierarchy($el['childs']);
            }
        }

        return $this->upHierarchy;
    }

    /**
     * @param $leftContent
     * @param bool $isConstruct
     * @return array
     */
    public function initLeftHierarchy($leftContent, $isConstruct = false)
    {
        foreach ($leftContent as $els => $el) {
            $this->leftHierarchy[trim($el['path'])] = is_array($el['childs'])
                ? [
                    'leaf' => false,
                    'name' => trim($el['field_name']),
                    'identityX' => $el['id'],
                    'level' => Helper::level($el['path']),
                    'isNullRow' => $el['isNullRow'],
                    'header' => $el['heading'],
                    'left_path' => $el['path'],
                    'identityDayKey' => ArrayHelper::keyExists('identityDayKey', $el) ? $el['identityDayKey'] : '',
                    'identitiCoupleKey' => ArrayHelper::keyExists('identityCoupleKey', $el) ? $el['identityCoupleKey'] : '',
                ]
                : [
                    'leaf' => true,
                    'name' => trim($el['field_name']),
                    'identityY' => $el['id'],
                    'level' => Helper::level($el['path']),
                    'isNullRow' => $el['isNullRow'],
                    'header' => $el['heading'],
                    'left_path' => $el['path'],
                    'identityDayToCoupleKey' => ArrayHelper::keyExists('identityDayToCoupleKey', $el) ? $el['identityDayToCoupleKey'] : '',
                    'identitiCoupleKey' => ArrayHelper::keyExists('identityCoupleKey', $el) ? $el['identityCoupleKey'] : '',
                    'type' => ArrayHelper::keyExists('arrayElementType', $el) ? $el['arrayElementType'] : 0,
                ];

            if (isset($el['childs'])) {
                $this->initLeftHierarchy($el['childs']);
            }
        }

        return $this->leftHierarchy;
    }

    public function oldCompare()
    {
        $editableCellActionsDropDown = Html::a('<i class="fa fa-angle-down fa-fw"></i>', '#', [
            'data-toggle' => 'dropdown',
            'class' => 'btn btn-default btn-sm dropdown-toggle',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
            'onClick' => "$('#vieweditablecellaction_".$scheduleData['identityDayKey']."_".$scheduleData['identityCoupleKey'].$scheduleData['identityGroup']."').slideToggle('fast');$('#vieweditablecellaction_".$scheduleData['identityDayKey']."_".$scheduleData['identityCoupleKey'].$scheduleData['identityGroup']."').focus();return false;"
        ]);

        $editableCellActions = $editableCellActionsDropDown . '<br><div id="vieweditablecellaction_'.$scheduleData['identityDayKey'].'_'.$scheduleData['identityCoupleKey'].$scheduleData['identityGroup'].'" class="panel" style="display: none;"><div class="panel-body">wswswswsws</div></div><hr> ';

    }
}