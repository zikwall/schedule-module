<?php
use yii\bootstrap\Html;

$request = Yii::$app->request;

$linkParams = [
    $link,
    'faculty' => $request->getQueryParam('faculty'),
    'course' => $request->getQueryParam('course'),
];

if(!empty($request->getQueryParam('page'))){
    $linkParams['page'] = $request->getQueryParam('page');
}

if(!empty($request->getQueryParam('per-page'))){
    $linkParams['per-page'] = $request->getQueryParam('per-page');
}


$query = $request->getQueryParam('manager');

if(empty($query)) {

    $linkParams['manager'] = 1;

    echo Html::a('<i class="fa fa-user"></i> Активировать режим менеджера', $linkParams, [
        'data-ui-loader' => '',
        'class' => 'btn btn-default'
    ]);

} elseif(isset($query) && $query == 1) {

    $linkParams['manager'] = 0;

   echo Html::a('<i class="fa fa-user"></i> Деативировать режим менеджера', $linkParams, [
        'data-ui-loader' => '',
        'class' => 'btn btn-danger'
   ]);
}

if(!Yii::$app->user->identity->isSystemAdmin()){
    echo PHP_EOL, Html::a(' Менеджер', '/schedule/admin', [
        'data-ui-loader' => '',
        'class' => 'btn btn-default',
    ]);
}