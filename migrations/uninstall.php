<?php
/**
 * @author Andrey Kapitonov <dj-on-ik@mail.com>
 */
class uninstall extends \yii\db\Migration
{
    public $prefix = 'schedule_';

    public function up()
    {
        $this->dropForeignKey('fa_study_groups_profile', '{{%university_study_groups}}');
        $this->dropForeignKey('fa_study_groups_faculty', '{{%university_study_groups}}');
        $this->dropForeignKey('fa_study_groups_course', '{{%university_study_groups}}'); //
        //$this->dropForeignKey('fa_user_role', '{{%user}}'); //
        $this->dropForeignKey('fa_teacher_user', '{{%university_teachers}}');
        $this->dropForeignKey('fa_teacher_position', '{{%university_teachers}}');
        $this->dropForeignKey('fk_teacher_science_degree', '{{%university_teachers}}');
        $this->dropForeignKey('fa_teacher_chair', '{{%university_teachers}}');
        $this->dropForeignKey('fa_teacher_discipline_assignee', '{{%university_teacher_discipline}}');
        $this->dropForeignKey('fa_discipline_teacher_assignee', '{{%university_teacher_discipline}}');

        $this->dropForeignKey('fa_schedule_weekly_type', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_schedule_classroom', '{{%schedule_schedule}}');

        $this->dropForeignKey('fa_user_link_to_user', '{{%schedule_user_link}}');
        $this->dropForeignKey('fa_user_link_to_university', '{{%schedule_user_link}}');
        $this->dropForeignKey('fa_user_link_to_faculty', '{{%schedule_user_link}}');
        $this->dropForeignKey('fa_user_link_to_study_group', '{{%schedule_user_link}}');

        $this->dropForeignKey('fa_day_schedule', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_couple_schedule', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_teacher_schedule', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_discipline_schedule', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_study_group_schedule', '{{%schedule_schedule}}');
        $this->dropForeignKey('fa_lesson_type_schedule', '{{%schedule_schedule}}');

        $this->dropForeignKey('fa_user_link_basis_education', '{{%schedule_user_link}}');
        $this->dropForeignKey('fa_user_link_form_education', '{{%schedule_user_link}}');

        $this->dropForeignKey('fa_header_to_faculty', '{{%schedule_headers}}');
        $this->dropForeignKey('fa_link_to_schedule', '{{%schedule_link_subgroups}}');
        $this->dropForeignKey('fa_link_to_subgroup', '{{%schedule_link_subgroups}}');

        //$this->dropColumn('{{%user}}', 'role');
        //$this->dropColumn('{{%user}}', 'basis_education');
        //$this->dropColumn('{{%user}}', 'form_education');
        //$this->dropColumn('{{%user}}', 'study_group');

        $config = Yii::$app->getModule('university')->settings;

        if(Yii::$app->moduleManager->hasModule('tracker-issues') && $config->get('useIssuesForSchedule')) {
            $this->dropForeignKey('fa_schedule_to_issues', '{{%schedule_link_issues}}');
            $this->dropForeignKey('fa_issues_to_schedule', '{{%schedule_link_issues}}');
            $this->dropTable('{{%schedule_link_issues}}');
        }

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
    }
}
