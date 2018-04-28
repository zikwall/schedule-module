<?php
    $containerId = time().'couple-color-chooser-edit';
?>

<div id="<?= $containerId ?>" class="form-group couple-color-chooser-edit" style="margin-top: 5px;">
    <?= humhub\widgets\ColorPickerField::widget(['model' => $model, 'field' => $color, 'container' => $containerId]); ?>

    <?= $form->field($model, $name, ['template' => '
        {label}
        <div class="input-group">
            <span class="input-group-addon">
                <i></i>
            </span>
            {input}
        </div>
        {error}{hint}'
        ])->textInput(['placeholder' => 'Название пары', 'maxlength' => 45 ]) ?>
</div>
