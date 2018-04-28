<?php

namespace humhub\modules\schedule;

use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\components\ContentContainerModule;
use yii\helpers\Url;

class Module extends ContentContainerModule
{
    public function getContentContainerTypes()
    {
        return [
            User::className(),
        ];
    }

    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer instanceof Space) {
            return [];
        } elseif ($contentContainer instanceof User) {
            return [];
        }

        return [
            new permissions\ManageDailySchedule(),
            new permissions\ManageScheduleIssues()
        ];
    }

    /**
     * @inheritdoc
     */
    public function getContentName()
    {
        return \Yii::t('ScheduleModule.base', 'Расписание занятий');
    }

    public function getContentContainerName(ContentContainerActiveRecord $container)
    {
        return 'Расписание занятий для профиля пользователя';
    }

    public function getContentContainerDescription(ContentContainerActiveRecord $container)
    {
        if ($container instanceof User) {
            return 'Активировать расписание университета в вашем профиле';
        }
    }

    public function disableContentContainer(ContentContainerActiveRecord $container)
    {
        return parent::disableContentContainer($container);
    }

    public function enableContentContainer(ContentContainerActiveRecord $container)
    {
        return parent::enableContentContainer($container);
    }

    public function getConfigUrl()
    {
        return Url::to([
            '/schedule/admin-configure'
        ]);
    }

    public function getContentContainerConfigUrl(ContentContainerActiveRecord $container) {
        if ($container instanceof User) {
            return $container->createUrl('/schedule/configure');
        }
        return;
    }
}