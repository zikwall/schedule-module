<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 05.04.2018
 * Time: 19:38
 */

use yii\helpers\Html;
?>

<?php $this->beginContent('@notification/views/layouts/mail.php', $_params_); ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>
        <td style="font-size: 14px; line-height: 22px; font-family:Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:<?= Yii::$app->view->theme->variable('text-color-highlight', '#555555') ?>; font-weight:300; text-align:left;">
            <?= Yii::t('ScheduleModule.views_notifications_somethingHappened', "%someUser% did something cool.", [
                '%someUser%' => '<strong>' . Html::encode($originator->displayName) . '</strong>'
            ]); ?>
        </td>
    </tr>
</table>



<?php $this->endContent();?>
