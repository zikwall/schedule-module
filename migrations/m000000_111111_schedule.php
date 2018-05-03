<?php

class m000000_111111_schedule extends \yii\db\Migration
{
    public $prefix = 'schedule_';

    public function up()
    {
        $config = Yii::$app->getModule('university')->settings;

        $this->createTable('{{%schedule_aviable_day}}', [
            'id' => $this->primaryKey(),
            'identity' => $this->string(45)->notNull(),
            'status' => $this->integer(1)->defaultValue(1),
            'displayName' => $this->string(100)->notNull(),
            'name' => $this->string(100)->notNull(),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
            'desc' => $this->string(200)->null()
        ], '');

        $aviableDays = [
            1 => [
                'displayName' => 'Понедельник',
                'name' => 'Понедельник',
                'en_name' => 'Monday'
            ],
            2 => [
                'displayName' => 'Вторник',
                'name' => 'Вторник',
                'en_name' => 'Tuesday'
            ],
            3 => [
                'displayName' => 'Среда',
                'name' => 'Среда',
                'en_name' => 'Wednesday'
            ],
            4 => [
                'displayName' => 'Четверг',
                'name' => 'Четверг',
                'en_name' => 'Thursday'
            ],
            5 => [
                'displayName' => 'Пятница',
                'name' => 'Пятница',
                'en_name' => 'Friday'
            ],
            6 => [
                'displayName' => 'Суббота',
                'name' => 'Суббота',
                'en_name' => 'Saturday'
            ],
        ];

        foreach ($aviableDays as $day){
            $this->insert('{{%schedule_aviable_day}}', [
                'identity' => \humhub\libs\UUID::v4(),
                'name' => $day['name'],
                'displayName' => $day['displayName'],
                'en_name' => $day['en_name'],
            ]);
        }

        $this->createTable('{{%schedule_aviable_couple}}', [
            'id' => $this->primaryKey(),
            'identity' => $this->string(45)->notNull(),
            'status' => $this->integer(1)->defaultValue(1),
            'displayName' => $this->string(100)->notNull(),
            'name' => $this->string(100)->notNull(),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
            'lessonStart' => $this->time()->notNull(),
            'lessonEnd' => $this->time()->notNull(),
            'color' => $this->string(7)->defaultValue('#6fdbe8'),
            'desc' => $this->string(200)->null()
        ], '');

        $aviableCouples = [
            1 => [
                'displayName' => '1 пара',
                'name' => '1_пара',
                'lessonStart' => '08:20:00',
                'lessonEnd' => '09:50:00',
            ],
            2 => [
                'displayName' => '2 пара',
                'name' => '2_пара',
                'lessonStart' => '10:00:00',
                'lessonEnd' => '11:30:00',
            ],
            3 => [
                'displayName' => '3 пара',
                'name' => '3_пара',
                'lessonStart' => '11:40:00',
                'lessonEnd' => '13:10:00',
            ],
            4 => [
                'displayName' => '4 пара',
                'name' => '4_пара',
                'lessonStart' => '13:55:00',
                'lessonEnd' => '15:25:00',
            ],
            5 => [
                'displayName' => '5 пара',
                'name' => '5_пара',
                'lessonStart' => '15:35:00',
                'lessonEnd' => '17:05:00',
            ],
            6 => [
                'displayName' => '6 пара',
                'name' => '6_пара',
                'lessonStart' => '17:15:00',
                'lessonEnd' => '18:45:00',
            ],
            7 => [
                'displayName' => '7 пара',
                'name' => '7_пара',
                'lessonStart' => '18:55:00',
                'lessonEnd' => '20:25:00',
            ],
            8 => [
                'displayName' => '8 пара',
                'name' => '8_пара',
                'lessonStart' => '20:35:00',
                'lessonEnd' => '22:05:00',
            ],
        ];

        foreach ($aviableCouples as $couple){
            $this->insert('{{%schedule_aviable_couple}}', [
                'identity' => \humhub\libs\UUID::v4(),
                'displayName' => $couple['displayName'],
                'name' => $couple['name'],
                'lessonStart' => $couple['lessonStart'],
                'lessonEnd' => $couple['lessonEnd'],
            ]);
        }

        $this->createTable('{{%university_study_courses}}', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->notNull(),
            'name' => $this->string(100)->null(),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
            'color' => $this->string(7)->defaultValue('#6fdbe8'),
            'desc' => $this->string(200)->null()
        ], '');

        $universityCourses = [
            1 => [
                'number' => 1,
                'name' => '1 курс',
                'color' => '#1ae620'
            ],
            2 => [
                'number' => 2,
                'name' => '2 курс',
                'color' => '#0ec314'
            ],
            3 => [
                'number' => 3,
                'name' => '3 курс',
                'color' => '#0ec389'
            ],
            4 => [
                'number' => 4,
                'name' => '4 курс',
                'color' => '#128eab'
            ],
            5 => [
                'number' => 5,
                'name' => '5 курс',
                'desc' => 'Магистратура',
                'color' => '#075fab'
            ],
            6 => [
                'number' => 6,
                'name' => '6 курс',
                'desc' => 'Магистратура',
                'color' => '#0732ab'
            ],
        ];

        foreach ($universityCourses as $cours){
            $this->insert('{{%university_study_courses}}', [
                'number' => $cours['number'],
                'name' => $cours['name'],
                'desc' => !empty($cours['desc']) ? $cours['desc'] : null,
                'color' => $cours['color']
            ]);
        }

        $this->createTable('{{%university_study_groups}}', [
            'id' => $this->primaryKey(),
            'faculty_id' => $this->integer()->notNull(),
            'profile_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'space_id' => $this->integer()->null(),
            'chair_id' => $this->integer()->notNull(),
            'name' => $this->string(20)->notNull()->comment('programm name: group_51_2'),
            'displayName' => $this->string(100)->notNull(),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
            'year' => $this->date()->notNull()->comment('year of receipt'),
            'desc' => $this->string(200)->null(),
            'color' => $this->string(7)->defaultValue('#6fdbe8'),
        ], '');

        $studyGroups = [
            1 => [
                'profile_id' => 5,
                'name' => 'гр_01',
                'displayName' => 'ЭК-01-14',
                'date' => 2014
            ],
            2 => [
                'profile_id' => 8,
                'name' => 'гр_02',
                'displayName' => 'ЭК-02-14',
                'date' => 2014
            ],
            3 => [
                'profile_id' => 6,
                'name' => 'гр_31',
                'displayName' => 'ЭК-031-14',
                'date' => 2014
            ],
            4 => [
                'profile_id' => 6,
                'name' => 'гр_32',
                'displayName' => 'ЭК-032-14',
                'date' => 2014
            ],
            5 => [
                'profile_id' => 7,
                'name' => 'гр_04',
                'displayName' => 'ЭК-04-14',
                'date' => 2014
            ],
            6 => [
                'profile_id' => 1,
                'chair_id' => 1,
                'name' => 'гр_51',
                'displayName' => 'ЭК-051-14',
                'date' => 2014
            ],
            7 => [
                'profile_id' => 4,
                'name' => 'гр_06',
                'displayName' => 'ЭК-06-14',
                'date' => 2014
            ],
            8 => [
                'profile_id' => 3,
                'name' => 'гр_07',
                'displayName' => 'ЭК-07-14',
                'date' => 2014
            ],
            9 => [
                'profile_id' => 9,
                'name' => 'гр_81',
                'displayName' => 'ЭК-081-14',
                'date' => 2014
            ],
            10 => [
                'profile_id' => 9,
                'name' => 'гр_82',
                'displayName' => 'ЭК-082-14',
                'date' => 2014
            ],
            11 => [
                'profile_id' => 10,
                'chair_id' => 3,
                'name' => 'гр_09',
                'displayName' => 'ЭК-09-14',
                'date' => 2014
            ],
        ];

        $studyGroups2 = [
            1 => [
                'profile_id' => 5,
                'name' => 'гр_01',
                'displayName' => 'ЭК-01-17',
                'date' => 2017
            ],
            2 => [
                'profile_id' => 8,
                'name' => 'гр_021',
                'displayName' => 'ЭК-021-17',
                'date' => 2017
            ],
            3 => [
                'profile_id' => 8,
                'name' => 'гр_022',
                'displayName' => 'ЭК-022-17',
                'date' => 2017
            ],
            4 => [
                'profile_id' => 6,
                'name' => 'гр_31',
                'displayName' => 'ЭК-031-17',
                'date' => 2017
            ],
            5 => [
                'profile_id' => 6,
                'name' => 'гр_32',
                'displayName' => 'ЭК-032-17',
                'date' => 2017
            ],
            6 => [
                'profile_id' => 7,
                'name' => 'гр_04',
                'displayName' => 'ЭК-04-17',
                'date' => 2017
            ],
            7 => [
                'profile_id' => 1,
                'chair_id' => 1,
                'name' => 'гр_51',
                'displayName' => 'ЭК-051-17',
                'date' => 2017
            ],
            8 => [
                'profile_id' => 4,
                'name' => 'гр_06',
                'displayName' => 'ЭК-06-17',
                'date' => 2017
            ],
            9 => [
                'profile_id' => 3,
                'name' => 'гр_07',
                'displayName' => 'ЭК-07-17',
                'date' => 2017
            ],
            10 => [
                'profile_id' => 9,
                'name' => 'гр_08',
                'displayName' => 'ЭК-08-17',
                'date' => 2017
            ],
            11 => [
                'profile_id' => 10,
                'chair_id' => 3,
                'name' => 'гр_09',
                'displayName' => 'ЭК-09-17',
                'date' => 2017
            ],
        ];

        $studyGroups3 = [
            1 => [
                'profile_id' => 5,
                'name' => 'гр_01',
                'displayName' => 'ЭК-01-16',
            ],
            2 => [
                'profile_id' => 8,
                'name' => 'гр_021',
                'displayName' => 'ЭК-021-16',
            ],
            3 => [
                'profile_id' => 8,
                'name' => 'гр_022',
                'displayName' => 'ЭК-022-16',
            ],
            4 => [
                'profile_id' => 6,
                'name' => 'гр_31',
                'displayName' => 'ЭК-031-16',
            ],
            5 => [
                'profile_id' => 6,
                'name' => 'гр_32',
                'displayName' => 'ЭК-032-16',
            ],
            6 => [
                'profile_id' => 7,
                'name' => 'гр_04',
                'displayName' => 'ЭК-04-16',
            ],
            7 => [
                'profile_id' => 1,
                'chair_id' => 1,
                'name' => 'гр_51',
                'displayName' => 'ЭК-051-16',
            ],
            8 => [
                'profile_id' => 4,
                'name' => 'гр_06',
                'displayName' => 'ЭК-06-16',
            ],
            9 => [
                'profile_id' => 3,
                'name' => 'гр_07',
                'displayName' => 'ЭК-07-16',
            ],
            10 => [
                'profile_id' => 9,
                'name' => 'гр_081',
                'displayName' => 'ЭК-081-16',
            ],
            11 => [
                'profile_id' => 9,
                'name' => 'гр_082',
                'displayName' => 'ЭК-082-16',
            ],
            12 => [
                'profile_id' => 10,
                'chair_id' => 3,
                'name' => 'гр_091',
                'displayName' => 'ЭК-091-16',
            ],
            13 => [
                'profile_id' => 10,
                'chair_id' => 3,
                'name' => 'гр_092',
                'displayName' => 'ЭК-092-16',
            ],
        ];

        $studyGroups4 = [
            1 => [
                'profile_id' => 5,
                'name' => 'гр_01',
                'displayName' => 'ЭК-01-15',
            ],
            2 => [
                'profile_id' => 8,
                'name' => 'гр_02',
                'displayName' => 'ЭК-02-15',
            ],
            3 => [
                'profile_id' => 6,
                'name' => 'гр_31',
                'displayName' => 'ЭК-031-15',
            ],
            4 => [
                'profile_id' => 6,
                'name' => 'гр_32',
                'displayName' => 'ЭК-032-15',
            ],
            5 => [
                'profile_id' => 7,
                'name' => 'гр_04',
                'displayName' => 'ЭК-04-15',
            ],
            6 => [
                'profile_id' => 1,
                'chair_id' => 1,
                'name' => 'гр_51',
                'displayName' => 'ЭК-051-15',
            ],
            61 => [
                'profile_id' => 1,
                'chair_id' => 1,
                'name' => 'гр_52',
                'displayName' => 'ЭК-052-15',
            ],
            7 => [
                'profile_id' => 4,
                'name' => 'гр_06',
                'displayName' => 'ЭК-06-15',
            ],
            8 => [
                'profile_id' => 3,
                'name' => 'гр_07',
                'displayName' => 'ЭК-07-15',
            ],
            9 => [
                'profile_id' => 9,
                'name' => 'гр_81',
                'displayName' => 'ЭК-081-15',
            ],
            10 => [
                'profile_id' => 9,
                'name' => 'гр_82',
                'displayName' => 'ЭК-082-15',
            ],
            11 => [
                'profile_id' => 10,
                'chair_id' => 3,
                'name' => 'гр_09',
                'displayName' => 'ЭК-09-15',
            ],
        ];

        foreach ($studyGroups as $group){
            $color = rand(1, 5);

            $colors = [
                1 => '#6fdbe8',
                2 => '#43c522',
                3 => '#c522a2',
                4 => '#f1950b',
                5 => '#590bf1',
            ];

            $this->insert('{{%university_study_groups}}', [
                'faculty_id' => 1,
                'profile_id' => $group['profile_id'],
                'course_id' => 4,
                'chair_id' => empty($group['chair_id']) ? rand(1, 6) : $group['chair_id'],
                'name' => $group['name'],
                'displayName' => $group['displayName'],
                'year' => $group['date'],
                'color' => $colors[$color]
            ]);
        }

        foreach ($studyGroups2 as $group2){
            $color = rand(1, 5);

            $colors = [
                1 => '#6fdbe8',
                2 => '#43c522',
                3 => '#c522a2',
                4 => '#f1950b',
                5 => '#590bf1',
            ];

            $this->insert('{{%university_study_groups}}', [
                'faculty_id' => 1,
                'profile_id' => $group2['profile_id'],
                'course_id' => 1,
                'chair_id' => empty($group2['chair_id']) ? rand(1, 6) : $group2['chair_id'],
                'name' => $group2['name'],
                'displayName' => $group2['displayName'],
                'year' => $group2['date'],
                'color' => $colors[$color]
            ]);
        }

        foreach ($studyGroups3 as $group3){
            $color = rand(1, 5);

            $colors = [
                1 => '#6fdbe8',
                2 => '#43c522',
                3 => '#c522a2',
                4 => '#f1950b',
                5 => '#590bf1',
            ];

            $this->insert('{{%university_study_groups}}', [
                'faculty_id' => 1,
                'profile_id' => $group3['profile_id'],
                'course_id' => 2,
                'chair_id' => empty($group3['chair_id']) ? rand(1, 6) : $group3['chair_id'],
                'name' => $group3['name'],
                'displayName' => $group3['displayName'],
                'year' => 2016,
                'color' => $colors[$color]
            ]);
        }

        foreach ($studyGroups4 as $group4){
            $color = rand(1, 5);

            $colors = [
                1 => '#6fdbe8',
                2 => '#43c522',
                3 => '#c522a2',
                4 => '#f1950b',
                5 => '#590bf1',
            ];

            $this->insert('{{%university_study_groups}}', [
                'faculty_id' => 1,
                'profile_id' => $group4['profile_id'],
                'course_id' => 3,
                'chair_id' => empty($group4['chair_id']) ? rand(1, 6) : $group4['chair_id'],
                'name' => $group4['name'],
                'displayName' => $group4['displayName'],
                'year' => 2015,
                'color' => $colors[$color]
            ]);
        }

        // 5 курс
        $this->insert('{{%university_study_groups}}', [
            'faculty_id' => 1,
            'profile_id' => 10,
            'course_id' => 5,
            'chair_id' => 3,
            'name' => 'гр_09',
            'displayName' => 'ЭК-09-13',
            'year' => 2013,
            'color' => '#590bf1'
        ]);

        $this->addForeignKey(
            'fa_study_groups_faculty',
            '{{%university_study_groups}}',
            'faculty_id',
            '{{%university_faculties}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_study_groups_profile',
            '{{%university_study_groups}}',
            'profile_id',
            '{{%university_specialities_profiles}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_study_groups_course',
            '{{%university_study_groups}}',
            'course_id',
            '{{%university_study_courses}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_study_groups_chair',
            '{{%university_study_groups}}',
            'chair_id',
            '{{%university_faculty_chair}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%university_user_roles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
        ], '');

        $roles = [
            1 => [
                'name' => 'Студент'
            ],
            2 => [
                'name' => 'Преподаватель'
            ],
            3 => [
                'name' => 'Деканат'
            ],
            4 => [
                'name' => 'Абитуриент'
            ],
        ];

        foreach ($roles as $role){
            $this->insert('{{%university_user_roles}}', [
                'name' => $role['name'],
            ]);
        }

        //$this->addColumn('{{%user}}', 'role', $this->integer()->notNull()->defaultValue(1));
        //$this->addColumn('{{%user}}', 'basis_education', $this->integer()->null());
        //$this->addColumn('{{%user}}', 'form_education', $this->integer()->null());
        //$this->addColumn('{{%user}}', 'study_group', $this->integer()->null());

        /*$this->addForeignKey(
            'fa_user_role',
            '{{%user}}',
            'role',
            '{{%university_user_roles}}',
            'id',
            'CASCADE',
            'CASCADE'
        );*/

        $this->createTable('{{%schedule_position}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull(),
            'shortname' => $this->string(100)->null(),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
            'color' => $this->string(7)->defaultValue('#21da27'),
            'desc' => $this->string(200)->null()
        ], '');

        $posts = [
            1 => [
                'name' => 'Академик-секретарь',
                'shortname' => 'акад.-секр.',
            ],
            2 => [
                'name' => 'Аспирант',
                'shortname' => 'асп.',
            ],
            3 => [
                'name' => 'Ведущий научный сотрудник',
                'shortname' => 'внс',
            ],
            4 => [
                'name' => 'Главный научный сотрудник',
                'shortname' => 'гнс',
            ],
            5 => [
                'name' => 'Ассистент',
                'shortname' => 'асс.',
            ],
            6 => [
                'name' => 'Ведущий специалист',
                'shortname' => 'вед.спец.',
            ],
            7 => [
                'name' => 'Вице-президент',
                'shortname' => 'вице-през.',
            ],
            8 => [
                'name' => 'Генеральный директор',
                'shortname' => 'ген.дир.',
            ],
            9 => [
                'name' => 'Главный редактор',
                'shortname' => 'гл.ред.',
            ],
            10 => [
                'name' => 'Главный специалист',
                'shortname' => 'гл.спец.',
            ],
            11 => [
                'name' => 'Декан',
                'shortname' => 'декан',
            ],
            12 => [
                'name' => 'Директор',
                'shortname' => 'дир.',
            ],
            13 => [
                'name' => 'Заведующий кафедрой',
                'shortname' => 'зав.каф.',
            ],
            14 => [
                'name' => 'Заведующий станцией',
                'shortname' => 'зав.станц.',
            ],
            15 => [
                'name' => 'Зам. академика-секретаря',
                'shortname' => 'зам.акад.-секр.',
            ],
            16 => [
                'name' => 'Зам. генерального директора',
                'shortname' => 'зам.ген.дир.',
            ],
            17 => [
                'name' => 'Зам. главного редактора',
                'shortname' => 'зам.гл.ред.',
            ],
            18 => [
                'name' => 'Зам. декана',
                'shortname' => 'зам.дек.',
            ],
            19 => [
                'name' => 'Зам. директора',
                'shortname' => 'зам.дир.',
            ],
            20 => [
                'name' => 'Зам. председателя',
                'shortname' => 'зам.пред.',
            ],
            21 => [
                'name' => 'Зам. руководителя',
                'shortname' => 'зам.рук.',
            ],
            22 => [
                'name' => 'Зам. руководителя (заведующего, начальника) группы',
                'shortname' => 'зам.рук.гр.',
            ],
            23 => [
                'name' => 'Зам. руководителя (заведующего, начальника) лаборатории',
                'shortname' => 'зам.рук.лаб.',
            ],
            24 => [
                'name' => 'Зам. руководителя (заведующего, начальника) отдела',
                'shortname' => 'зам.рук.отдела',
            ],
            25 => [
                'name' => 'Зам. руководителя (заведующего, начальника, председателя) отделения',
                'shortname' => 'зам.рук.отд.',
            ],
            26 => [
                'name' => 'Зам. руководителя (заведующего, начальника) сектора',
                'shortname' => 'зам.рук.сект.',
            ],
            27 => [
                'name' => 'Зам. руководителя (заведующего, начальника, председателя) центра (научного, учебного и т.п.)',
                'shortname' => 'зам.рук.центра',
            ],
            28 => [
                'name' => 'Лаборант',
                'shortname' => 'лаб.',
            ],
            29 => [
                'name' => 'Проректор',
                'shortname' => 'проректор',
            ],
            30 => [
                'name' => 'Редактор',
                'shortname' => 'ред.',
            ],
            31 => [
                'name' => 'Ректор',
                'shortname' => 'ректор',
            ],
            32 => [
                'name' => 'Руководитель (заведующий, начальник) группы',
                'shortname' => 'рук.гр.',
            ],
            33 => [
                'name' => 'Руководитель (заведующий, начальник) лаборатории',
                'shortname' => 'рук.лаб.',
            ],
            34 => [
                'name' => 'Руководитель (заведующий, начальник) отдела',
                'shortname' => 'рук.отдела',
            ],
            35 => [
                'name' => 'Руководитель (заведующий, начальник, председатель) отделения',
                'shortname' => 'рук.отд.',
            ],
            36 => [
                'name' => 'Руководитель (заведующий, начальник) сектора',
                'shortname' => 'рук.сект.',
            ],
            37 => [
                'name' => 'Руководитель (заведующий, начальник, председатель) центра (научного, учебного и т.п.)',
                'shortname' => 'рук.центра',
            ],
            38 => [
                'name' => 'Специалист (зоолог, программист, геолог, инженер и т.п.)',
                'shortname' => 'спец.',
            ],
            39 => [
                'name' => 'Старший специалист (геолог, зоолог, инженер и т.п.)',
                'shortname' => 'ст.спец.',
            ],
            40 => [
                'name' => 'Старший лаборант',
                'shortname' => 'ст.лаб.',
            ],
            41 => [
                'name' => 'Техник',
                'shortname' => 'техн.',
            ],
            42 => [
                'name' => 'Ученый секpетаpь',
                'shortname' => 'уч.секp.',
            ],
            43 => [
                'name' => 'Без должности',
                'shortname' => 'без.долж.',
            ],
        ];

        foreach ($posts as $post){
            $this->insert('{{%schedule_position}}', [
                'name' => $post['name'],
                'shortname' => $post['shortname'],
            ]);
        }

        $this->createTable('{{%university_science_degree}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'color' => $this->string()->notNull()->defaultValue('#7a7a7a'),
            'shortname' => $this->string(20)->notNull(),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
            'desc' => $this->string(200)->null(),
        ], '');

        $scienceDegrees = [
            1 => [
                'name' => 'Аспирант',
                'shortname' => 'асп.',
            ],
            2 => [
                'name' => 'Ассистент',
                'shortname' => 'асс.',
            ],
            3 => [
                'name' => 'Ведущий научный сотрудник',
                'shortname' => 'внс',
            ],
            4 => [
                'name' => 'Главный научный сотрудник',
                'shortname' => 'гнс',
            ],
            5 => [
                'name' => 'Докторант',
                'shortname' => 'гнс',
            ],
            7 => [
                'name' => 'Доцент',
                'shortname' => 'доц.',
            ],
            8 => [
                'name' => 'Младший научный сотрудник',
                'shortname' => 'мнс',
            ],
            9 => [
                'name' => 'Научный сотрудник',
                'shortname' => 'нс',
            ],
            10 => [
                'name' => 'Преподаватель',
                'shortname' => 'преп.',
            ],
            11 => [
                'name' => 'Профессор',
                'shortname' => 'проф.',
            ],
            12 => [
                'name' => 'Старший преподаватель',
                'shortname' => 'ст.преп.',
            ],
            13 => [
                'name' => 'Стажер',
                'shortname' => 'стажер',
            ],
            14 => [
                'name' => 'Старший научный сотрудник',
                'shortname' => 'снс',
            ],
        ];

        foreach ($scienceDegrees as $scienceDegree){
            $this->insert('{{%university_science_degree}}', [
                'name' => $scienceDegree['name'],
                'shortname' => $scienceDegree['shortname'],
            ]);
        }

        $this->createTable('{{%university_teachers}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'science_id' => $this->integer()->notNull(),
            'chair_id' => $this->integer()->notNull(),
            'story' => $this->text()->null()
        ], '');

        $teachers = [
            1 => [
                'user_id' => 1,
                'science_id' => rand(1, 14),
                'post_id' => rand(1, 42),
                'chair_id' => 1,
            ],
            2 => [
                'user_id' => 2,
                'science_id' => rand(1, 14),
                'post_id' => rand(1, 42),
                'chair_id' => 3,
            ],
            3 => [
                'user_id' => 3,
                'science_id' => rand(1, 14),
                'post_id' => rand(1, 42),
                'chair_id' => 2,
            ],
        ];

        foreach ($teachers as $teacher){
            $this->insert('{{%university_teachers}}', [
                'user_id' => $teacher['user_id'],
                'science_id' => $teacher['science_id'],
                'post_id' => $teacher['post_id'],
                'chair_id' => $teacher['chair_id'],
                'story' => $this->getLoremText()
            ]);
        }

        $this->addForeignKey(
            'fa_teacher_user',
            '{{%university_teachers}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_teacher_position',
            '{{%university_teachers}}',
            'post_id',
            '{{%schedule_position}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_teacher_science_degree',
            '{{%university_teachers}}',
            'science_id',
            '{{%university_science_degree}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_teacher_chair',
            '{{%university_teachers}}',
            'chair_id',
            '{{%university_faculty_chair}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%university_discipline}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
            'color' => $this->string(7)->defaultValue('#777'),
            'desc' => $this->string(200)->null()
        ], '');

        $disciplines = [
            1 => [
                'name' => 'Программирование'
            ],
            2 => [
                'name' => 'Маркетинг'
            ],
            3 => [
                'name' => 'Архитектура препприятий'
            ],
            4 => [
                'name' => 'Управление жизненными циклами информационных систем'
            ],
            5 => [
                'name' => 'Менеджмент'
            ],
            6 => [
                'name' => 'Региональная экономика'
            ],
            116 => [
                'name' => 'Бухгалтерский учет'
            ],
            7 => [
                'name' => 'Психология и педагогика'
            ],
            8 => [
                'name' => 'Информационные технологии в экономике и управлении'
            ],
            9 => [
                'name' => 'Философия'
            ],
            10 => [
                'name' => 'Иностранный язык'
            ],
            11 => [
                'name' => 'Элективные курсы по физической культуре и спорту'
            ],
            12 => [
                'name' => 'Чувашский язык'
            ],
            13 => [
                'name' => 'Математика'
            ],
            14 => [
                'name' => 'Граждановедение'
            ],
            15 => [
                'name' => 'Микроэкономика'
            ],
            16 => [
                'name' => 'Экономика организации'
            ],
            17 => [
                'name' => 'Операционные системы., среды и оболочки'
            ],
            18 => [
                'name' => 'Программирование в экономиеских системах'
            ],
            19 => [
                'name' => 'Конституционное право'
            ],
            20 => [
                'name' => 'Экономическая теория: микроэкономика'
            ],
            21 => [
                'name' => 'Анализ хозяйственной деятельности в государственных (муниципальных) учреждениях '
            ],
            22 => [
                'name' => 'Конъюктура мировых рынков'
            ],
            23 => [
                'name' => 'Практический аудит'
            ],
            24 => [
                'name' => 'Автоматизация финансово-экономической деятельности'
            ],
            25 => [
                'name' => 'Второй иностранный язык'
            ],
            26 => [
                'name' => 'Дипломатия'
            ],
            27 => [
                'name' => 'Платежные системы и организация расчетов в коммерческих банках'
            ],
            28 => [
                'name' => 'Финансы государсвтенных и муниципальных учреждений'
            ],
            29 => [
                'name' => 'Организация деятельности центрального банка'
            ],
            30 => [
                'name' => 'Финансовый менеджмент'
            ],
            31 => [
                'name' => 'Налоговый учет'
            ],
            32 => [
                'name' => 'Бухгалтерский учет и анализ в банках'
            ],
            33 => [
                'name' => 'Учет и анализ внешнеэкономической деятельности'
            ],
            34 => [
                'name' => 'Логистика'
            ],
            35 => [
                'name' => 'Реструктуризация предприятия'
            ],
            36 => [
                'name' => 'Экономика инновационной деятельности'
            ],
            37 => [
                'name' => 'Нечеткая логика и нейронные сети'
            ],
            38 => [
                'name' => 'Налоговый менеджмент'
            ],
            39 => [
                'name' => 'Информационная безопасность'
            ],
            40 => [
                'name' => 'Имитационное моделирование'
            ],
            41 => [
                'name' => 'Анализ данных'
            ],
            42 => [
                'name' => 'Автоматизация обработки информации в бюджетной сфере'
            ],
            43 => [
                'name' => 'Анализ финансовой отчетности'
            ],
            44 => [
                'name' => 'Экономическая безопасность'
            ],
            45 => [
                'name' => 'Маркетинговые коммуникации'
            ],
            46 => [
                'name' => 'Стратегический менеджмент'
            ],
            47 => [
                'name' => 'Управление проектами'
            ],
            48 => [
                'name' => 'Эффективность информационных технологий'
            ],
            49 => [
                'name' => 'Маркетинг инноваций'
            ],
            50 => [
                'name' => 'Банковский учет и аудит'
            ],
            51 => [
                'name' => 'Социлогия управления'
            ],
            52 => [
                'name' => 'Планирование и проектирование организации'
            ],
            53 => [
                'name' => 'Организация и методика налоговых проверок'
            ],
            54 => [
                'name' => 'Финансовое регулирование банкротств'
            ],
            55 => [
                'name' => 'Организация предоставления государственных и муниципальных услуг'
            ],
            56 => [
                'name' => 'Контроль и ревизия'
            ],
            57 => [
                'name' => 'Экспертиза  и оценка инвестиционных проектов'
            ],
            58 => [
                'name' => 'Земельное право '
            ],
            59 => [
                'name' => 'Бизнес-планирование'
            ],
            60 => [
                'name' => 'Оценка рисков'
            ],
            61 => [
                'name' => 'Управление общественными отношениями'
            ],
            62 => [
                'name' => 'Проффесиональная деятельность на рынке ценных бумаг'
            ],
            63 => [
                'name' => 'Финансы предприятий'
            ],
            64 => [
                'name' => 'Исследование операций '
            ],
        ];

        foreach ($disciplines as $discipline){
            $this->insert('{{%university_discipline}}', [
                'name' => $discipline['name']
            ]);
        }

        $this->createTable('{{%university_teacher_discipline}}', [
            'id' => $this->primaryKey(),
            'teacher_id' => $this->integer()->notNull(),
            'discipline_id' => $this->integer()->notNull()
        ], '');

        $this->addForeignKey(
            'fa_teacher_discipline_assignee',
            '{{%university_teacher_discipline}}',
            'teacher_id',
            '{{%university_teachers}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_discipline_teacher_assignee',
            '{{%university_teacher_discipline}}',
            'discipline_id',
            '{{%university_discipline}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $teacherDiscipline = [
            1 => [
                'teacher' => 2,
                'dicipline' => 3
            ],
            2 => [
                'teacher' => 2,
                'dicipline' => 1
            ],
            3 => [
                'teacher' => 3,
                'dicipline' => 4
            ],
            4 => [
                'teacher' => 3,
                'dicipline' => 1
            ],
            5 => [
                'teacher' => 1,
                'dicipline' => 3
            ],
            6 => [
                'teacher' => 1,
                'dicipline' => 2
            ],
            7 => [
                'teacher' => 1,
                'dicipline' => 1
            ],
        ];

        foreach ($teacherDiscipline as $td){
            $this->insert('{{%university_teacher_discipline}}', [
                'teacher_id' => $td['teacher'],
                'discipline_id' => $td['dicipline']
            ]);
        }

        $this->createTable('{{%schedule_lesson_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
            'color' => $this->string(7)->defaultValue('#5cb85c'),
            'desc' => $this->string(200)->null(),
            'sign' => $this->string(20)->null(),
        ], '');

        $lessonTypes = [
            1 => [
                'name' => 'Лекция',
                'sign' => 'лк',
                'color' => '#5cb85c'
            ],
            2 => [
                'name' => 'Практика',
                'sign' => 'пр',
                'color' => '#428bca'
            ],
            3 => [
                'name' => 'Семинарское занятие',
                'sign' => 'семинар',
                'color' => '#19c4ea'
            ],
            4 => [
                'name' => 'Лабораторное занятие',
                'sign' => 'лб',
                'color' => '#ea1996'
            ],
            5 => [
                'name' => 'Занятие на компьютерах',
                'sign' => 'кз',
                'color' => '#e0640c'
            ],
        ];

        foreach ($lessonTypes as $type){
            $this->insert('{{%schedule_lesson_type}}', [
                'name' => $type['name'],
                'sign' => $type['sign'],
                'color' => $type['color']
            ]);
        }

        $this->createTable('{{%schedule_schedule}}', [
            'id' => $this->primaryKey(),
            'day_id' => $this->integer()->notNull(),
            'couple_id' => $this->integer()->notNull(),
            'teacher_id' => $this->integer()->notNull(),
            'discipline_id' => $this->integer()->notNull(),
            'study_group_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'half_year' => $this->integer()->notNull()->defaultValue(2),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
            'desc' => $this->string(200)->null(),
        ], '');

        $this->addColumn('{{%schedule_schedule}}', 'weekly_type_id', $this->integer()->notNull());
        $this->addColumn('{{%schedule_schedule}}', 'classroom_id', $this->integer()->notNull());
        //$this->addColumn('{{%aschedule_schedule}}',  'study_subgroup' , $this->integer()->null());

        $this->batchInsert('{{%schedule_schedule}}', ['day_id', 'couple_id', 'teacher_id', 'discipline_id',
            'study_group_id', 'type_id', 'weekly_type_id', 'classroom_id'], [
            [
                1, 1, 1, 2, 1, 2, 1, 1
            ],
            [
                1, 1, 2, 1, 1, 1, 2, 2
            ],
            [
                1, 2, 3, 5, 2, 1, 1, 4
            ],
            [
                1, 3, 2, 2, 3, 2, 2, 4
            ],
            [
                1, 4, 1, 3, 6, 4, 1, 3
            ],
            [
                1, 2, 2, 1, 5, 2, 1, 2
            ],
        ]);

        $this->batchInsert('{{%schedule_schedule}}', ['day_id', 'couple_id', 'teacher_id', 'discipline_id',
            'study_group_id', 'type_id', 'weekly_type_id', 'classroom_id'], [
            [
                2, 1, 1, 2, 7, 2, 1, 1
            ],
            [
                2, 1, 1, 1, 7, 2, 2, 2
            ],
            [
                4, 2, 3, 5, 12, 1, 1, 3
            ],
            [
                4, 3, 2, 2, 11, 2, 2, 4
            ],
            [
                6, 4, 1, 3, 9, 4, 1, 3
            ],
            [
                5, 2, 2, 1, 7, 2, 1, 2
            ],
        ]);

        $this->createTable('{{%schedule_weekly_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'en_name' => $this->string(100)->null()->comment('i18n field'),
            'color' => $this->string(7)->defaultValue('#428bca'),
            'sign' => $this->string(10)->notNull()
        ], '');

        $this->batchInsert('{{%schedule_weekly_type}}', ['name', 'en_name', 'color', 'sign'], [
            [
                'Четная',
                'even',
                '#428bca',
                '**'
            ],
            [
                'Нечетная',
                'odd',
                '#f3820e',
                '*'
            ]
        ]);

        $this->addForeignKey(
            'fa_schedule_weekly_type',
            '{{%schedule_schedule}}',
            'weekly_type_id',
            '{{%schedule_weekly_type}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_schedule_classroom',
            '{{%schedule_schedule}}',
            'classroom_id',
            '{{%university_building_classroom}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_day_schedule',
            '{{%schedule_schedule}}',
            'day_id',
            '{{%schedule_aviable_day}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_couple_schedule',
            '{{%schedule_schedule}}',
            'couple_id',
            '{{%schedule_aviable_couple}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_teacher_schedule',
            '{{%schedule_schedule}}',
            'teacher_id',
            '{{%university_teachers}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_discipline_schedule',
            '{{%schedule_schedule}}',
            'discipline_id',
            '{{%university_discipline}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_study_group_schedule',
            '{{%schedule_schedule}}',
            'study_group_id',
            '{{%university_study_groups}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_lesson_type_schedule',
            '{{%schedule_schedule}}',
            'type_id',
            '{{%schedule_lesson_type}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%schedule_user_link}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'role_id' => $this->integer()->null(), // toDO
            'university_id' => $this->integer()->notNull(),
            'faculty_id' => $this->integer()->notNull(),
            'study_group_id' => $this->integer()->notNull(),
            'basis_education_id' => $this->integer()->notNull(),
            'form_education_id' => $this->integer()->notNull()
        ], '');

        $this->addForeignKey(
            'fa_user_link_to_user',
            '{{%schedule_user_link}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_user_link_to_university',
            '{{%schedule_user_link}}',
            'university_id',
            '{{%university}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_user_link_to_faculty',
            '{{%schedule_user_link}}',
            'faculty_id',
            '{{%university_faculties}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_user_link_to_study_group',
            '{{%schedule_user_link}}',
            'study_group_id',
            '{{%university_study_groups}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%university_basis_education}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
        ], '');

        $this->batchInsert('{{%university_basis_education}}', ['name'], [
            [
                'Бюджет',
            ],
            [
                'Контракт',
            ]
        ]);

        $this->addForeignKey(
            'fa_user_link_basis_education',
            '{{%schedule_user_link}}',
            'basis_education_id',
            '{{%university_basis_education}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%university_form_education}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
        ], '');

        $this->batchInsert('{{%university_form_education}}', ['name'], [
            [
                'Очная',
            ],
            [
                'Очно-заочная',
            ],
            [
                'Заочная',
            ],
            [
                'Экстернат',
            ]
        ]);

        $this->addForeignKey(
            'fa_user_link_form_education',
            '{{%schedule_user_link}}',
            'form_education_id',
            '{{%university_form_education}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%schedule_headers}}', [
            'id' => $this->primaryKey(),
            'faculty_id' => $this->integer()->notNull(),
            'header' => $this->text()->null(),
        ], '');

        $this->addForeignKey(
            'fa_header_to_faculty',
            '{{%schedule_headers}}',
            'faculty_id',
            '{{%university_faculties}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%schedule_subgroups}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'color' => $this->string(7)->defaultValue('#5cb85c'),
        ], '');

        $this->batchInsert('{{%schedule_subgroups}}', ['name'], [
            [
                'I подгруппа'
            ],
            [
                'II подгруппа'
            ],
            [
                'III подгруппа'
            ],
        ]);

        $this->createTable('{{%schedule_link_subgroups}}', [
            'id' => $this->primaryKey(),
            'schedule_id' => $this->integer()->notNull(),
            'subgroup_id' => $this->integer()->notNull(),
        ], '');

        $this->addForeignKey(
            'fa_link_to_schedule',
            '{{%schedule_link_subgroups}}',
            'schedule_id',
            '{{%schedule_schedule}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_link_to_subgroup',
            '{{%schedule_link_subgroups}}',
            'subgroup_id',
            '{{%schedule_subgroups}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        if(Yii::$app->moduleManager->hasModule('tracker-issues') && $config->get('useIssuesForSchedule')) {
            $this->createTable('{{%schedule_link_issues}}', [
                'id' => $this->primaryKey(),
                'schedule_id' => $this->integer()->notNull(),
                'issues_id' => $this->integer()->notNull(),
            ], '');

            $this->addForeignKey(
                'fa_schedule_to_issues',
                '{{%schedule_link_issues}}',
                'schedule_id',
                '{{%schedule_schedule}}',
                'id',
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'fa_issues_to_schedule',
                '{{%schedule_link_issues}}',
                'issues_id',
                '{{%tracker_issue}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
        }
        // ToDo: move to faculties migrations
        $this->createTable('{{%university_faculty_chairtimes}}', [
            'id' => $this->primaryKey(),
            'chair_id' => $this->integer()->notNull(),
            'signature_id' => $this->integer()->comment('responsible who signed')
        ], '');

        $this->addForeignKey(
            'fa_chairtimes_to_chair',
            '{{%university_faculty_chairtimes}}',
            'chair_id',
            '{{%university_faculty_chair}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_chairtimes_to_signature',
            '{{%university_faculty_chairtimes}}',
            'signature_id',
            '{{%university_teachers}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%university_faculty_chairtimes_assignee}}', [
            'id' => $this->primaryKey(),
            'chairtimes_id' => $this->integer()->notNull(),
            'teacher_id' => $this->integer()
        ], '');

        $this->addForeignKey(
            'fa_chairtimes_assignee_to_chairtime',
            '{{%university_faculty_chairtimes_assignee}}',
            'chairtimes_id',
            '{{%university_faculty_chairtimes}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_chairtimes_assignee_to_teacher',
            '{{%university_faculty_chairtimes_assignee}}',
            'teacher_id',
            '{{%university_teachers}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%university_faculty_chairtimes_assignee_times}}', [
            'id' => $this->primaryKey(),
            'chairtimes_assignee_id' => $this->integer()->notNull(),
            'day_id' => $this->integer()->notNull(),
            'time' => $this->time()->null()
        ], '');

        $this->addForeignKey(
            'fa_chairtimes_assignee_to_times_to_chairtimes',
            '{{%university_faculty_chairtimes_assignee_times}}',
            'chairtimes_assignee_id',
            '{{%university_faculty_chairtimes_assignee}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fa_chairtimes_assignee_to_times_to_day',
            '{{%university_faculty_chairtimes_assignee_times}}',
            'day_id',
            '{{%schedule_aviable_day}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // end ToDo.

        //$this->addColumn('{{%user}}', 'study_group_id', $this->integer()->null());
    }

    public function down()
    {
        $this->dropForeignKey('fa_study_groups_profile', '{{%university_study_groups}}');
        $this->dropForeignKey('fa_study_groups_faculty', '{{%university_study_groups}}');
        $this->dropForeignKey('fa_study_groups_course', '{{%university_study_groups}}'); //
        $this->dropForeignKey('fa_user_role', '{{%user}}'); //
        $this->dropForeignKey('fa_teacher_user', '{{%university_teachers}}');
        $this->dropForeignKey('fa_teacher_position', '{{%university_teachers}}');
        $this->dropForeignKey('fk_teacher_science_degree', '{{%university_teachers}}');
        $this->dropForeignKey('fa_teacher_chair', '{{%university_teachers}}');
        $this->dropForeignKey('fa_teacher_discipline_assignee', '{{%university_teacher_discipline}}');
        $this->dropForeignKey('fa_discipline_teacher_assignee', '{{%university_teacher_discipline}}');

        $this->dropForeignKey('fa_schedule_weekly_type', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_schedule_classroom', '{{%schedule_schedule}}');

        $this->dropForeignKey('fa_day_schedule', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_couple_schedule', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_teacher_schedule', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_discipline_schedule', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_study_group_schedule', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_lesson_type_schedule', '{{%schedule_schedule}}');

        $this->dropForeignKey('fa_user_link_basis_education', '{{%schedule_user_link}}');
        $this->dropForeignKey('fa_user_link_form_education', '{{%schedule_user_link}}');

        $this->dropForeignKey('fa_user_link_to_user', '{{%schedule_user_link}}');
        $this->dropForeignKey('fa_user_link_to_university', '{{%schedule_user_link}}');
        $this->dropForeignKey('fa_user_link_to_faculty', '{{%schedule_user_link}}');
        $this->dropForeignKey('fa_user_link_to_study_group', '{{%schedule_user_link}}');

        $this->dropForeignKey('fa_header_to_faculty', '{{%schedule_headers}}');
        $this->dropForeignKey('fa_link_to_schedule', '{{%schedule_link_subgroups}}');
        $this->dropForeignKey('fa_link_to_subgroup', '{{%schedule_link_subgroups}}');

        // toDo: move to faculties mogrations
        $this->dropForeignKey('fa_chairtimes_to_chair', '{{%university_faculty_chair_times}}');
        $this->dropForeignKey('fa_chairtimes_to_teacher', '{{%university_faculty_chair_times}}');

        /*$this->dropColumn('{{%user}}', 'role');
        $this->dropColumn('{{%user}}', 'basis_education');
        $this->dropColumn('{{%user}}', 'form_education');
        $this->dropColumn('{{%user}}', 'study_group');*/

        $this->dropTable('{{%schedule_aviable_day}}');
        $this->dropTable('{{%schedule_aviable_couple}}');
        $this->dropTable('{{%university_study_groups}}');  //
        $this->dropTable('{{%university_user_roles}}'); //
        $this->dropTable('{{%university_study_courses}}'); //
        $this->dropTable('{{%university_teachers}}');
        $this->dropTable('{{%schedule_position}}');
        $this->dropTable('{{%university_teacher_discipline}}');
        $this->dropTable('{{%university_discipline}}');
        $this->dropTable('{{%schedule_lesson_type}}');
        $this->dropTable('{{%schedule_schedule}}');
        $this->dropTable('{{%schedule_weekly_type}}');
        $this->dropTable('{{%university_science_degree}}'); //

        $this->dropTable('{{%schedule_user_link}}'); //
        $this->dropTable('{{%university_basis_education}}'); //
        $this->dropTable('{{%university_form_education}}'); //

        $this->dropTable('{{%schedule_headers}}'); //
        $this->dropTable('{{%schedule_link_subgroups}}'); //
        $this->dropTable('{{%schedule_subgroups}}'); //

        $this->dropTable('{{%university_faculty_chair_times}}'); //

    }

    public function getLoremText()
    {
        return 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.';
    }
}
