<?php

namespace humhub\modules\schedule\components\cellconstructor\constructors;

use Donquixote\Cellbrush\Table\Table;
use humhub\modules\schedule\components\cellconstructor\helpers\EditableHelper;
use yii\base\InvalidParamException;

/**
 * Данный класс является "симмулятором" генератора таблиц.
 * Создает все виды отчетов с "искуственными" данными.
 * Нужен при создании шаблонов.
 *
 * Class SimmulateTableConstructor
 */
class SimmulateTableConstructor extends TableConstructor
{
    /**
     * @param $upHierarchy
     * @param bool $editTable
     * @return Table
     */
    public function simmulateFlatTable($upHierarchy, $editTable = false)
    {
        if($upHierarchy == null || !is_array($upHierarchy)){
            throw new InvalidParamException();
        }

        $colNames = $this->initUpHierarchy($upHierarchy);

        $table = new Table();
        $rowGroupName = 'g';
        $rowGroupNames = [$rowGroupName];

        for ($i = 0; $i < EditableHelper::depth($colNames); ++$i) {
            $table->thead()->addRow($rowGroupName . '.caption');
            $rowGroupName .= '.g';
            $rowGroupNames[] = $rowGroupName;
        }
        $table->thead()->addRow($rowGroupName);

        foreach ($colNames as $colName => $isLeaf) {
            $table->addColName($colName);
            $depth = substr_count($colName, '.');
            $rowGroupName = $rowGroupNames[$depth];
            $rowName = $isLeaf['leaf']
                ? $rowGroupName
                : $rowGroupName . '.caption';
            $table->thead()->th($rowName, $colName, $isLeaf['name']);
        }

        $table->tbody()->addRow(1);
        $lastElementCounts = count($this->getArrayTreeLastLevelElements($upHierarchy));

        for($i = 0; $i <= $lastElementCounts; $i++){
            foreach ($colNames as $colName => $isLeaf){
                /**
                 * toDo: create recursive generated fill downs row
                 */
                //$table->tbody()->td(1, trim($colName), 'contentFillsDown <i class="fa fa-arrow-down" aria-hidden="true"></i>');
            }
        }
        $table->addClass('table table-bordered');
        return $table;
    }

    /**
     * @param $upHierarchy
     * @param $leftHierarchy
     * @param bool $editTable
     * @return Table
     */
    public function simmulateMatrxiTable($upHierarchy, $leftHierarchy, $editTable = true)
    {
        $openEndCols = [];

        if($upHierarchy == null || !is_array($upHierarchy)){
            throw new InvalidParamException();
        }

        if($leftHierarchy == null || !is_array($leftHierarchy)){
            throw new InvalidParamException();
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

        for ($rowOpenEndCounter = 0; $rowOpenEndCounter <= EditableHelper::depth($rowHierarchy); $rowOpenEndCounter++) {
            $openEndCols[] = $rowOpenEndCounter;
        }

        $table->addColNames($openEndCols);
        $table->thead()->thOpenEnd('g', 0, '');

        foreach ($rowHierarchy as $row => $isLeaf){
            $table->addRow($row);
            $table->thOpenEnd($row, $isLeaf['level'], $isLeaf['name']);
            if($isLeaf['isNullRow'] == 0 || $isLeaf['heading'] == 1){
                $table->tbody()->addCellClass($row, $isLeaf['level'], 'center');
            }
        }

        foreach ($colNames as $colName => $isLeaf) {
            $table->addColName($colName);
            $depth = substr_count($colName, '.');
            $rowGroupName = $rowGroupNames[$depth];
            $rowName = $isLeaf['leaf']
                ? $rowGroupName
                : $rowGroupName . '.caption';
            $table->thead()->th($rowName, $colName, $isLeaf['name']);
        }

        $matrix = $this->drawEditableCells($upHierarchy, $leftHierarchy);

        foreach ($matrix as $data){
            $table->tbody()->td($data['xAxisElementPath'], $data['yAxisElementPath'], $data['crossValue']);
        }

        $table->addClass('table table-bordered table-striped');
        return $table;
    }

    /**
     * @param $upTree
     * @param $leftTree
     * @param null $container
     * @param bool $isEditable
     * @return array
     */
    public function drawEditableCells($upTree, $leftTree, $container = null, $isEditable = true, $isUseContainer = true)
    {
        $matrixElementsStorange = [];
        $counterAxis = 0;

        foreach ($this->getArrayTreeLastLevelElements($upTree) as $ordinatesAxis => $yAxisElement){
            foreach($this->getArrayTreeLastLevelElements($leftTree) as $abscissaeAxis => $xAxisElement){
                if($xAxisElement['isNullRow'] == 1 || $xAxisElement['heading'] == 1){
                    $matrixElementsStorange[$counterAxis]['ordinatesAxisIdentity'] = trim($ordinatesAxis);
                    $matrixElementsStorange[$counterAxis]['abscissaeAxisIdentity'] = trim($abscissaeAxis);
                    $matrixElementsStorange[$counterAxis]['coulumnIdentity'] = trim($yAxisElement['id']);
                    $matrixElementsStorange[$counterAxis]['rowIdentity'] = trim($xAxisElement['id']);
                    $matrixElementsStorange[$counterAxis]['yAxisElementPath'] = trim($yAxisElement['path']);
                    $matrixElementsStorange[$counterAxis]['xAxisElementPath'] = trim($xAxisElement['path']);
                    $matrixElementsStorange[$counterAxis]['crossValue'] = 'cell_'.$xAxisElement['id'].'-'.$yAxisElement['id'].'_content <i class="fa fa-star" aria-hidden="true"></i>';
                }
                $counterAxis++;
            }
        }
        return $matrixElementsStorange;
    }
}