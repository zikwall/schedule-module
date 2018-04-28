<?php
use yii\helpers\Html;
?>
<ul class="media-list">
    <?php foreach ($groups as $group): ?>
    <?php /** @var \humhub\modules\university\models\UniversityStudyGroups $group */ ?>
        <a href="<?= \yii\helpers\Url::to(['/schedule/public/global-alternative',
                'faculty' => $group->faculty_id,
                'course' => $group->course_id,
                'group' => $group->id
        ])?>">
            <li style="border-left: 3px solid <?= $group->color; ?>">
                <div class="media">
                    <div class="media-body  text-break">
                        <strong><?= $group->displayName; ?></strong>
                        <?= Html::tag('span', $group->profile->shortname, [
                            'class' => 'label label-info popoverTrigger',
                            'style' => 'background-color: '.$group->profile->color.'!important;',
                            'rel' => 'popover',
                            'data-placement' => 'bottom',
                            'data-trigger' => 'hover',
                            'data-content' => $group->profile->name
                        ]); ?>
                    </div>
                </div>
            </li>
        </a>
        <br>
    <?php endforeach; ?>
</ul>

<script>
    $('.popoverTrigger').popover({ trigger: "hover" });
</script>