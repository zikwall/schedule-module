<?php
namespace humhub\modules\schedule\components\cellconstructor\helpers;

use humhub\modules\schedule\components\cellconstructor\containers\ContentContainer;
use yii\helpers\Html;

class EditableHelper extends Helper
{
    public static $scriptsMap = [];

    /**
     * @param $discoverType
     * @return string
     */
    public static function determineFieldType($discoverType)
    {
        $stringTypesArray = ['varchar', 'char', 'text'];
        $numberTypesArray = ['int', 'long', 'tinyint', 'integer'];
        $dateTypesArray   = ['date', 'datetime'];

        if(in_array($discoverType, $stringTypesArray)){
            $definiteType = 'text';
        } elseif(in_array($discoverType, $numberTypesArray)) {
            $definiteType = 'number';
        } elseif(in_array($discoverType, $dateTypesArray)){
            $definiteType = $discoverType == 'datetime' ? 'datetime' : 'date';
        } else {
            $definiteType = 'safe';
        }
        return $definiteType;
    }

    /**
     * @param $script
     */
    public static function addJsScript($script)
    {
        self::$scriptsMap[] = $script;
    }

    /**
     * toDo: update JS side of this method
     *
     * @param $fieldName
     * @param $editType
     * @return string
     */
    public static function createEditableField($fieldName, $editType, $value, $container = null, $dataParams = [])
    {
        extract($dataParams);

        switch ($editType) {
            case 'text':
                $editType = Html::a($value, '#', ['id' => $fieldName, 'data-type' => 'text', 'data-pk' => 1]);
                $js = self::createJsScript($fieldName, '/report/upadate/matrix', [
                    'validateFunction' => 'function(value) {
                                                if($.trim(value) == \'\') {
                                                    return \'This field is required\';
                                                }
                                           }',
                    'successFunction' => 'function(response, newValue) {
                                                if(response) alert(response);
                                          }',
                    'title' => 'Enter Number Values',
                    'params' => "function(params){
                        params.container = '$container';
                        params.colId = $colId;
                        params.rowId = $rowId;
                        params.colPath = '$colPath';
                        params.rowPath = '$rowPath';
                        return params;
                        }"
                ]);
                break;
            case 'number':
                $editType = Html::a($value, '#', ['id' => $fieldName,'data-type' => 'number', 'data-pk' => 1]);
                $js = self::createJsScript($fieldName, '/report/upadate/matrix', [
                    'validateFunction' => 'function(value) {
                                                if($.trim(value) == \'\') {
                                                    return \'This field is required\';
                                                }
                                           }',
                    'successFunction' => 'function(response, newValue) {
                                                if(response) alert(response);
                                          }',
                    'title' => 'Enter Number Values',
                    'params' => "function(params) {
                        params.colId = $colId;
                        params.rowId = $rowId;
                        params.colPath = '$colPath';
                        params.rowPath = '$rowPath';
                        params.container = '$container';
                        return params;
                    }",
                ]);
                break;
            case 'date':
                $editType = Html::a($value, '#', ['id' => $fieldName,
                    'data-type' => 'date',
                    'data-pk' => 1
                   ]);
                $js = self::createJsScript($fieldName, '/report/upadate/matrix', [
                    'title' => 'Select date',
                    'successFunction' => 'function(response, newValue) {
                                                if(response) alert(response);
                                          }',
                    'params' => "function(params) {
                        params.colId = $colId;
                        params.rowId = $rowId;
                        params.colPath = '$colPath';
                        params.rowPath = '$rowPath';
                        params.container = '$container';
                        return params;
                    }",
                    'format' => "'yyyy-mm-dd'",
                    'viewformat' => "'dd/mm/yyyy'",
                    'datepicker' => '{
                                        weekStart: 1
                                    }'
                ]);
                break;
            case 'datetime':
                $editType = Html::a($value, '#', ['id' => $fieldName,
                    'data-type' => 'date',
                    'data-pk' => 1,
                    'data-title' => 'Select date & time']);
                $js = self::createJsScript($fieldName, '/report/upadate/matrix', [
                    'successFunction' => 'function(response, newValue) {
                                                if(response) alert(response);
                                          }',
                    'params' => "function(params) {
                        params.colId = $colId;
                        params.rowId = $rowId;
                        params.colPath = '$colPath';
                        params.rowPath = '$rowPath';
                        params.container = '$container';
                        return params;
                    }",
                    'format' => "'yyyy-mm-dd hh:ii'",
                    'viewformat' => "'dd/mm/yyyy hh:ii'",
                    'datetimepicker' => '{
                                        weekStart: 1
                                    }'
                ]);
                break;
            case 'safe':
                $editType = Html::a($value, '#', ['id' => $fieldName,
                    'data-type' => 'textarea',
                    'data-pk' => 1,
                    'data-title' => 'Enter Text Area']);
                $js = self::createJsScript($fieldName, '/report/upadate/matrix', [
                    'title' => 'Enter Text Area',
                    'successFunction' => 'function(response, newValue) {
                                                if(response) alert(response);
                                          }',
                    'params' => "function(params) {
                        params.colId = $colId;
                        params.rowId = $rowId;
                        params.colPath = '$colPath';
                        params.rowPath = '$rowPath';
                        params.container = '$container';
                        return params;
                    }",
                ]);
                break;
        }

        return $editType.' '.$js;
    }

    /**
     * @param $identity
     * @param $postUrl
     * @param array $scriptElemetnts
     * @return string
     */
    public static function createJsScript($identity, $postUrl, $scriptElemetnts = [])
    {
        extract($scriptElemetnts);

        $script = '<script>';
        $script .= '$(function(){';
            $script .= '$(\'#'.$identity.'\').editable({';
                $script .= 'url: \''.$postUrl.'\'';
                    if($title){
                        $script .= ', title: \''.'Enter '.$title.'\'';
                    }
                    if($ajaxOptions){
                        $script .= ', ajaxOptions:'.$ajaxOptions;
                    }
                    if($successFunction){
                        $script .= ', success:'.$successFunction;
                    }
                    if($validateFunction){
                        $script .= ', validate:'.$validateFunction;
                    }
                    if($errorFunction){
                        $script .= ', error:'.$errorFunction;
                    }
                    if($params){
                        $script .= ', params:'.$params;
                    }
                    if($format){
                        $script .= ', format:'.$format;
                    }
                    if($viewformat){
                        $script .= ', viewformat:'.$viewformat;
                    }
                    if($datepicker){
                        $script .= ', datepicker:'.$datepicker;
                    }
                    if($datetimepicker){
                        $script .= ', datetimepicker:'.$datetimepicker;
                    }
                $script .= '});';
            $script .= '});';
        $script .= '</script>';

        //self::addJsScript($script);
        return $script;
    }

    /**
     * @param array $attributes
     * @return string
     */
    public static function attr($attributes = [])
    {
        $attr = '';
        if(is_array($attributes)){
            foreach ($attributes as $attribute => $value){
                $attr .= $value['name'].' = "'.$value['value'].'"';
            }
        }
        return $attr;
    }

    /**
     * @param $fieldName
     * @param $postUrl
     * @param $type
     * @param null $scriptElements
     * @param null $attributes
     * @return string
     */
    public static function field($fieldName, $postUrl,  $type, $scriptElements = null, $attributes = null)
    {
        $editableField = Html::a($fieldName, '#', $attributes);
        $jScript = static::createJsScript($fieldName, $postUrl, $scriptElements);

        return $editableField.' '.$jScript;
    }

    /**
     * @param $fieldName
     * @param $posUrl
     * @param null $scriptElements
     * @param null $attributes
     * @return string
     */
    public static function text($fieldName, $posUrl, $scriptElements = null, $attributes = null)
    {
        return static::field($fieldName, 'text', $posUrl, $scriptElements, $attributes);
    }

    public static function number($fieldName, $posUrl, $scriptElements = null, $attributes = null)
    {
        return static::field($fieldName, 'number', $posUrl, $scriptElements, $attributes);
    }

    public static function date()
    {

    }

    public static function dateTime()
    {

    }

    public static function wysihtml5()
    {

    }

    public static function typeahead()
    {

    }

    public static function typeaheadJs()
    {

    }

    public static function select2()
    {

    }
}