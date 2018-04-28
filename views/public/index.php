
<div class="panel panel-default">
    <div class="panel-body">
        <?php foreach ($faculties as $faculty): ?>
        <?php /** @var \humhub\modules\faculties\models\UniversityFaculties $faculty */?>
        <div class="media">
            <div class="content">
                <div class="pull-left" style="min-height:133px;">
                    <a href="http://foto.cheb.ru/foto/foto.cheb.ru-23118.jpg" style="padding-right:12px" data-ui-gallery="gallery-844550b2-8156-4e91-a3cc-6ef230e898ed">
                        <img class="animated fadeIn" src="http://foto.cheb.ru/foto/foto.cheb.ru-23118.jpg" height="113" alt="2015_dodge_challenger_cars-2560x1440 — копия.jpg">
                    </a>
                </div>

                <strong>
                    <a href="/schedule/public/global?faculty=<?= $faculty->id; ?>" style="text-decoration: underline" target="_blank">
                        <?= $faculty->fullname; ?>
                    </a>
                </strong>
                <br><br>

                <small>
                    <span class="label label-default"><i class="fa fa-chain fa-fw" aria-hidden="true"></i></span>
                    <span class="label label-default">Корпус: </span>
                    <span class="label label-default"><a href="javascript::void"><?= $faculty->building->name; ?></a></span>
                </small>

                <br> <br>

                <a class="btn btn-sm btn-default" href="/schedule/public/global?faculty=<?= $faculty->id; ?>" data-ui-loader="">
                   Открыть расписание
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
