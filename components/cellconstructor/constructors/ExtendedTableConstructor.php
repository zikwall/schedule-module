<?php

namespace humhub\modules\schedule\components\cellconstructor\constructors;

use Donquixote\Cellbrush\Table\Table;
use humhub\modules\api\modules\rest\helpers\ArrayHelper;
use humhub\modules\schedule\components\cellconstructor\helpers\EditableHelper;
use humhub\modules\schedule\components\cellconstructor\helpers\Helper;
use humhub\modules\schedule\models\ScheduleSchedule;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use Yii;

class ExtendedTableConstructor extends TableConstructor
{
    public function drawScheduleCells($upTree, $leftTree, $identityGroup, $isEditable = true, $isManagerMode)
    {
        $matrixElementsStorange = [];

        foreach ($this->getArrayTreeLastLevelElements($upTree) as $ordinatesAxis => $yAxisElement){
            foreach($this->getArrayTreeLastLevelElements($leftTree) as $abscissaeAxis => $xAxisElement){
                if($xAxisElement['isNullRow'] == 1 || $xAxisElement['heading'] == 1){
                    $matrixElementsStorange[$xAxisElement['id'].$yAxisElement['id']]['hpath'] = trim($yAxisElement['path']);
                    $matrixElementsStorange[$xAxisElement['id'].$yAxisElement['id']]['vpath'] = trim($xAxisElement['path']);
                    //$matrixElementsStorange[$xAxisElement['id'].$yAxisElement['id']]['class'] = 'row-'.$xAxisElement['id'].' col-'.$yAxisElement['id'];

                    if($isEditable){
                        /**
                         * @var [] $identityArray url parametres
                         */
                        $identityArray = [
                            'identityCoupleKey' => $xAxisElement['identityCoupleKey'],
                            'identityDayKey' => $yAxisElement['identityDayKey'],
                            'identityGroup' => $identityGroup
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
     * @inheritdoc
     */
    public function drawScheduleCell($cellItem = [], $cellOptions = [], $editable = false)
    {
        return parent::drawScheduleCell($cellItem, $cellOptions, $editable);
    }

    /**
     * @inheritdoc
     */
    public function drawDailyDiscipline(ScheduleSchedule $dailyDiscipline, $template = 1)
    {
       return parent::drawDailyDiscipline($dailyDiscipline, $template = 1);
    }

    public function drawScheduleTable($upHierarchy, $leftHierarchy, $group, $editTable = false, $openEndColsText = 'Дни недели | время | группы', $managerMode = false)
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

        //Helper::p($rowHierarchy);

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
        $table->thead()->thOpenEnd('g', 0, $openEndColsText)->addCellClass('g', 0, 'center widthCell');

        foreach ($rowHierarchy as $row => $isLeaf){
            $table->addRow($row);
            $table->thOpenEnd($row, $isLeaf['level'], $isLeaf['name']);
            if($isLeaf['isNullRow'] == 0 || $isLeaf['heading'] == 0){
                $table->tbody()->addCellClass($row, $isLeaf['level'], 'center widthCell');
            }
        }

        foreach ($colNames as $colName => $isLeaf) {
            $table->addColName($colName);
            $depth = substr_count($colName, '.');
            $rowGroupName = $rowGroupNames[$depth];
            $rowName = $isLeaf['leaf']
                ? $rowGroupName
                : $rowGroupName . '.caption';
            $table->thead()->th($rowName, $colName, $isLeaf['name'])->addCellClass($rowName, $colName,'center actionCheck');
        }


        if($editTable){

            if(Yii::$app->request->getQueryParam('manager') == 1){
                $managerMode = true;
            }

            $contentContainermMatrixStorange = $this->drawScheduleCells($upHierarchy, $leftHierarchy, $group, $editTable, $managerMode);

            foreach ($contentContainermMatrixStorange as $matrixContent){
                $table->tbody()->td($matrixContent['vpath'], $matrixContent['hpath'], $matrixContent['value']);
                if(!empty($matrixContent['class'])){
                    $table->addCellClass($matrixContent['vpath'], $matrixContent['hpath'], $matrixContent['class']);
                }
            }
        }

        $table->addClass('table table-bordered table-hover actionTable');

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
                    'path' => $el['path'],
                    'identityDayKey' => ArrayHelper::keyExists('identityDayKey', $el) ? $el['identityDayKey'] : '',
                ]
                : [
                    'leaf' => true,
                    'name' => $el['field_name'],
                    'identity' => $el['id'],
                    'level' => Helper::level($el['path']),
                    'path' => $el['path'],
                    'identityDayKey' => ArrayHelper::keyExists('identityDayKey', $el) ? $el['identityDayKey'] : '',
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
                    'identity' => $el['id'],
                    'level' => Helper::level($el['path']),
                    'isNullRow' => $el['isNullRow'],
                    'header' => $el['heading'],
                    'path' => $el['path'],
                    'identityDayKey' => ArrayHelper::keyExists('identityDayKey', $el) ? $el['identityDayKey'] : '',
                    'identitiCoupleKey' => ArrayHelper::keyExists('identityCoupleKey', $el) ? $el['identityCoupleKey'] : '',
                ]
                : [
                    'leaf' => true,
                    'name' => trim($el['field_name']),
                    'identity' => $el['id'],
                    'level' => Helper::level($el['path']),
                    'isNullRow' => $el['isNullRow'],
                    'header' => $el['heading'],
                    'path' => $el['path'],
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
}