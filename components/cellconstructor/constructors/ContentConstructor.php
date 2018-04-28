<?php

namespace humhub\modules\schedule\components\cellconstructor\constructors;

use humhub\modules\schedule\components\cellconstructor\ConstructorComponent;
use humhub\modules\schedule\components\cellconstructor\helpers\Helper;
use yii\base\InvalidParamException;
use yii\helpers\Json;

/**
 * Class ContentConstructor
 *
 * last updates: 06.02.2018 23:00
 */
class ContentConstructor extends ConstructorComponent
{
    use ArrayableTrait;

    /**
     * @param $templateName
     * @param $upHierarchy
     * @param $leftHierarchy
     * @param bool $isReturnedInsertId
     * @param int $type
     * @param string $charset
     * @param string $engine
     * @return array|bool|string
     */
    public function commandSaveMatrixTemplate($templateName, $upHierarchy = [], $leftHierarchy = [], $isReturnedInsertId = false, $type = 2, $charset = 'utf8', $engine = 'InnoDb')
    {
        if(empty($upHierarchy) || empty($leftHierarchy)){
            throw new InvalidParamException('One or more required attributes are not array or empty!');
        }

        $upHierarchyToJson = Json::encode($upHierarchy);
        $leftHierarchyToJson = Json::encode($leftHierarchy);

        if(empty($templateName)){
            throw new InvalidParamException('Template name can not be null!');
        }

        if($insertId = $this->getContainer()->container->table('templates')->insert([
            'name' => $templateName,
            'user_id' => Core::$app->user->getUser()->id,
            'type' => $type,
            'hierarchy' => $upHierarchyToJson,
            'leftHierarchy' => $leftHierarchyToJson,
            'charset' => $charset,
            'engine' => $engine
        ])){
            return $isReturnedInsertId ? $insertId : true;
        }

        return false;
    }

    /**
     * @param $jssonArray
     * @return bool
     */
    public function commandCreateFlatHeader($jssonArray)
    {
        if(empty($jssonArray)){
            throw new InvalidParamException('The main hierarchy[] can not be empty array!');
        }

        $getArray = $this->getArrays($jssonArray);
        $hierarchyToJson = Json::encode($getArray);

        return false;
    }
}