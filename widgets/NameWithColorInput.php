<?php

namespace humhub\modules\schedule\widgets;

use humhub\components\Widget;

class NameWithColorInput extends Widget
{
    public $model;
    public $form;

    public $nameField = 'displayName';
    public $colorField = 'color';

    public function run()
    {
        return $this->render('nameWithColorInput', [
            'model' => $this->model,
            'form' => $this->form,
            'name' => $this->nameField,
            'color' => $this->colorField
        ]);
    }
}

?>