<?php

use humhub\modules\schedule\components\TimeInterval;

?>

<div class="panel">
    <div class="panel-heading">
        <strong>Ближайшие</strong> пары
    </div>
    <div class="panel-body">
        <ul class="media-list">
            <?php if(!empty($currents)): ?>
                <?php foreach ($currents as $current): ?>
                    <a href="javascript::void()">
                        <li style="border-left: 3px solid #6fdbe8">
                            <div class="media">
                                <div class="media-body  text-break">
                                    <?php if((new TimeInterval($current->couple->getDisplayTime()))->isNow()): ?>
                                        <span class="label label-success pull-right">Текущая пара</span>
                                    <?php endif; ?>
                                    <strong><?= $current->discipline->name; ?></strong>
                                    <br><hr>
                                    <span class="time" title="<?= $current->couple->getDisplayTime();?>">
                                    <?= $current->couple->getDisplayTime();?>
                                </span>

                                </div>
                            </div>
                        </li>
                    </a>
                    <br>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

