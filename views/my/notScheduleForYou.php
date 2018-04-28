<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Расписание занятий в профиле</strong>
    </div>
    <div class="panel-body">
        <?php if($this->context->user->id == Yii::$app->user->id): ?>
            Для вас нет расписания, либо вы забыли указать учебную группу в настройках.
            Пожалуйста, сделайте это: <?= \yii\bootstrap\Html::a('Настроить', '/university/user/linker')?>
        <?php else: ?>
            Данный пользователь не настроил модуль расписания для профиля.
        <?php endif; ?>
    </div>
</div>