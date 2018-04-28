<?php

namespace humhub\modules\schedule\components\cellconstructor\constructors;

use humhub\modules\schedule\components\cellconstructor\helpers\Helper;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;

trait ArrayableTrait
{
    /**
     * Основное хранилище массивов
     *
     * @var array
     */
    public $arrayTreeElementsStorange = [];

    public function unsetStorange()
    {
        unset($this->arrayTreeElementsStorange);
    }

    /**
     * Метод реализует перестановку элементов, ключем ветки массива является его же идентификатор.
     * Так же расчитывает полные "пути" и уровни вложенности
     *
     * @param $dataArray
     * @param bool $useLevels
     * @return array|InvalidParamException
     */
    public function getArrays($dataArray, $useLevels = true, $forsePath = false, $path = null)
    {
        $reformedArray = [];

        if(!is_array($dataArray)){
            throw new InvalidParamException();
        }

        foreach ($dataArray as $element) {
            $reformedArray[$element['id']] = $element;
            $elementPath = $this->arrayPath($element['id'], $dataArray);
            $reformedArray[$element['id']][$forsePath ? $path : 'path'] = $elementPath;
            if($useLevels){
                $reformedArray[$element['id']]['level'] = Helper::level($elementPath);
            }
        }
        return $reformedArray;
    }

    /**
     * @return array
     */
    public function cArrayTreeElementsStorange()
    {
        return $this->arrayTreeElementsStorange;
    }

    /**
     * Метод возвращает все последние элементы древовидного массива.
     *
     * @param $arrayTree
     * @return array
     */
    public function getArrayTreeLastLevelElements($arrayTree)
    {
        if(is_array($arrayTree)){
            foreach ($arrayTree as $items => $item){
                if(ArrayHelper::keyExists('childs', $item)){
                    $this->getArrayTreeLastLevelElements($item['childs']);
                } else {
                    $this->arrayTreeElementsStorange[] = $item;
                }
            }
        }
        return $this->arrayTreeElementsStorange;
    }

    /**
     * Данный метод строит те самые "пути" в "деревьях"
     *
     * @param $findIdentity
     * @param $array
     * @return string
     */
    public function arrayPath($findIdentity, $array = [])
    {
        if(!is_numeric($findIdentity)){
            throw new InvalidParamException();
        }

        $path = '';

        if(is_array($array)){
            foreach ($array as $items => $item){
                if($item['id'] == $findIdentity){
                    $path .= $item['internal_key'] != 0
                        ? $this->arrayPath($item['internal_key'], $array).'.'.$item['name']
                        : $item['name'];
                }
            }
            return $path;
        }
        return '';
    }

    /**
     * Данный метод генерирует "древовидный" массив.
     * Создает новый ключ "childs" и помещает туда всех его "детей"
     *
     * @param $data
     * @return array|InvalidParamException
     */
    public function arrayTree($data)
    {
        $tree = [];

        if(!is_array($data)) {
            throw new InvalidParamException();
        }

        uasort($data, function($a, $b, $sortField = 'sort_order') {
            if ($a[$sortField] == $b[$sortField]) {
                return 0;
            }
            return ($a[$sortField] < $b[$sortField]) ? -1 : 1;
        });

        foreach ($data as $id => &$node) {
            if (!$node['internal_key']){
                $tree[$id] = &$node;
            } else {
                $data[$node['internal_key']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    /**
     * Очень полезный метод сортировки массива.
     * Сортировка на каждом уровне вложенности, в каждой "семье"
     *
     * @param $a
     * @param $b
     * @param string $sortField
     * @return int
     */
    public function arraySort($a, $b, $sortField = 'sort_order')
    {
        if ($a[$sortField] == $b[$sortField]) {
            return 0;
        }
        return ($a[$sortField] < $b[$sortField]) ? -1 : 1;
    }
}