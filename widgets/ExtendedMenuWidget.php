<?php

namespace humhub\modules\schedule\widgets;

use Yii;
use humhub\modules\questionanswer\helpers\Url;
use humhub\widgets\BaseMenu;
use yii\base\InvalidCallException;

class ExtendedMenuWidget extends BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@humhub/widgets/views/tabMenu";


    public function addItem($item)
    {
        if (!isset($item['classOption'])) {
            $item['htmlOptions']['class'] .= ' ' . $item['htmlOptions']['classOption'];
        }

        return parent::addItem($item);
    }
}