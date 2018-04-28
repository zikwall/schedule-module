<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model humhub\modules\schedule\models\ScheduleHeaders */
/* @var $form ActiveForm */
?>
<style>
    .non {
        display: none;
    }
</style>
<?php $this->beginContent('@humhub/modules/schedule/views/layouts/_advancedLayoutForSchedule.php') ?>
<div class="panel">
    <div class="panel-body">
        <strong>Шапка</strong> расписания создание
    </div>
</div>
<div class="headerForm">

    <table class="table table-bordered" id="dynamic_head_actions">
        <tr>
            <td>
                <button type="button" name="overviewTableStructure" id="overviewTableStructure" class="btn btn-success">Предпросмотр структуры шаблона</button>
                <button type="button" name="overviewArrayStructure" id="overviewArrayStructure" class="btn btn-success">Показать массив</button>
            </td>
        </tr>
        <tr>
            <td id="overviewCommonStructureContainer" class="non">
                <br>
            </td>
        </tr>
    </table>

    <?php $form = ActiveForm::begin([
            'id' => 'dynamic-insert'
    ]); ?>

        <div class="table-responsive">
            <table class="table table-bordered" id="dynamic">
                <tr>
                    <td>Идентификатор</td>
                    <td>Родитель</td>
                    <td>Сортировка на уровне</td>
                    <td>Название поля в таблице</td>
                    <td>Название для шапки</td>
                    <td>Действия</td>
                </tr>
                <tr>
                    <td><input type="text" name="id[]" placeholder="Идентификатор" class="form-control name_list" value="1"/></td>
                    <td><input type="text" name="internal_key[]" placeholder="Родитель" class="form-control name_list" /></td>
                    <td><input type="text" name="sort_order[]" placeholder="Сортировка на уровне" class="form-control name_list" /></td>
                    <td><input type="text" name="field_name[]" placeholder="Название поля в таблице" class="form-control name_list" /></td>
                    <td><input type="text" name="name[]" placeholder="Название для шапки" class="form-control name_list" /></td>
                    <td><button type="button" name="add" id="add" class="btn btn-success">Добавить поле</button></td>
                </tr>
            </table>
        </div>

        <br><hr>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('UniversityModule.base', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->endContent(); ?>

<script>
    $(document).ready(function() {
        var i = 1;
        var x = 1;

        $('#add').click(function () {
            x++; // inc(x)
            $('#dynamic').append(
                '<tr id="row' + x + '">' +
                '<td>' +
                '<input type="text" name="id[]" placeholder="Идентификатор" class="form-control name_list" value="' + x + '"/>' +
                '</td> ' +
                '<td>' +
                '<input type="text" name="internal_key[]" placeholder="Родитель" class="form-control name_list" />' +
                '</td> ' +
                '<td>' +
                '<input type="text" name="sort_order[]" placeholder="Сортировка на уровне" class="form-control name_list" />' +
                '</td> ' +
                '<td>' +
                '<input type="text" name="field_name[]" placeholder="Название поля в таблице" class="form-control name_list" />' +
                '</td> ' +
                '<td>' +
                '<input type="text" name="name[]" placeholder="Название для шапки" class="form-control name_list" />' +
                '</td> ' +
                '<td>' +
                '<button type="button" name="remove_insert" id="' + x + '" class="btn btn-danger btn_remove_insert">X</button>' +
                '</td>' +
                '</tr>');
        });

        $(document).on('click', '.btn_remove_insert', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
            x = x - 1;
        });

        $('#overviewTableStructure').click(function(){
            var btnSelector = '#overviewTableStructure';
            var tdSelector = '#overviewCommonStructureContainer';
            if($(btnSelector).text() === 'Предпросмотр структуры шаблона'){
                $.ajax({
                    type: 'post',
                    url: '/schedule/admin/header-preview',
                    data: $('#dynamic-insert').serialize(),
                    beforeSend: function () {
                        $(btnSelector).prop('disabled', true);
                        $(btnSelector).text('Loading...Please, wait...');
                    },
                    success: function (response) {
                        $(tdSelector).empty();
                        $(tdSelector).html('<table class="">'+response+'</table>');
                        $(tdSelector).removeClass( "non" );
                        $(btnSelector).removeClass( "btn-success" ).addClass( "btn-danger" );
                        $(btnSelector).text( "Скрыть предпросмотр структуры шаблона" );
                        $(btnSelector).removeAttr('disabled');
                    },
                    error: function () {
                        alert('Not OKay');
                        $(btnSelector).removeAttr('disabled');
                        $(tdSelector).addClass( "non" );
                        $(btnSelector).addClass( "btn-success" ).removeClass( "btn-danger" );
                        $(btnSelector).text( "Предпросмотр структуры шаблона" );
                        return false;
                    }
                });
            } else {
                $(tdSelector).addClass( "non" );
                $(btnSelector).addClass( "btn-success" ).removeClass( "btn-danger" );
                $(btnSelector).text( "Предпросмотр структуры шаблона" );
            }
        });

        $('#overviewArrayStructure').click(function(){
            var btnSelector = '#overviewArrayStructure';
            var tdSelector = '#overviewCommonStructureContainer';
            if($(btnSelector).text() === 'Показать массив') {
                $.ajax({
                    type: 'post',
                    url: '/schedule/admin/header-array-preview',
                    data: $('#dynamic-insert').serialize(),
                    //dataType: "html",
                    beforeSend: function () {
                        $(btnSelector).prop('disabled', true);
                        $(btnSelector).text('Loading...Please, wait...');
                    },
                    success: function (response) {
                        $(tdSelector).empty();
                        $(tdSelector).html(response);
                        $(btnSelector).text('Скрыть массив');
                        $(btnSelector).removeClass( "btn-success" ).addClass( "btn-danger" );
                        $(tdSelector).removeClass( "non" );
                        $(btnSelector).removeAttr('disabled');
                    },
                    error: function () {
                        alert('Not OKay');
                        $(btnSelector).removeAttr('disabled');
                        $(tdSelector).addClass( "non" );
                        $(btnSelector).text('Показать массив');
                        $(btnSelector).addClass( "btn-success" ).removeClass( "btn-danger" );
                        return false;
                    }
                });
            } else {
                $(tdSelector).addClass( "non" );
                $(btnSelector).text('Показать массив');
                $(btnSelector).addClass( "btn-success" ).removeClass( "btn-danger" );
            }
        });

    });
</script>
