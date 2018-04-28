<?php

namespace humhub\modules\schedule\components\cellconstructor;


class ConstructorConfiguration
{
    const FIELDS = [
        'primaryIdentity'  => 'id',
        'typeIdentity'     => 'field_type',
        'relationIdentity' => 'internal_key',
        'sortOrder'        => 'sort_order',
        'physicalName'     => 'field_name',
        'visibleName'      => 'name',
        'lenghtOptions'    => 'lenght',
        'statusOptions'    => 'status',
        'headingOptions'   => 'heading',
        'pathOptions'      => 'path',
        'levelOptions'     => 'level',
        'childsOptions'    => 'childs'
    ];
}