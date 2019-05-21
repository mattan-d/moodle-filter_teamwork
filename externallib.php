<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * External interface library for customfields component
 *
 * @package   filter_teamwork
 * @copyright 2018 Devlion <info@devlion.co>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . "/externallib.php");
require_once($CFG->dirroot . "/filter/teamwork/locallib.php");

/**
 * Class filter_teamwork_external
 *
 * @copyright 2018 David Matamoros <davidmc@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_teamwork_external extends external_api {

    public static function render_teamwork_html_parameters() {
        return new external_function_parameters(
                array(
                        'courseid' => new external_value(PARAM_INT, 'courseid int', VALUE_DEFAULT, null),
                        'activityid' => new external_value(PARAM_INT, 'activityid int', VALUE_DEFAULT, null),
                        'moduletype' => new external_value(PARAM_TEXT, 'moduletype text', VALUE_DEFAULT, null),
                        'selectgroupid' => new external_value(PARAM_TEXT, 'selectgroupid text', VALUE_DEFAULT, null),
                )
        );
    }

    public static function render_teamwork_html_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function render_teamwork_html($courseid, $activityid, $moduletype, $selectgroupid) {
        global $OUTPUT, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $arrgroupid = json_decode($selectgroupid);

        $data = array();
        $data['courseid'] = $courseid;
        $data['activityid'] = $activityid;
        $data['moduletype'] = $moduletype;

        $data['teamwork_enable'] = if_teamwork_enable($activityid);
        $data['students_button_status'] = students_button_status($activityid);
        $data['allow_add_teams'] = allow_add_teams($courseid, $activityid, $arrgroupid[0]);
        $data['groups'] = view_groups_select($courseid);

        // Set default groups.
        foreach ($data['groups'] as $group) {
            if ($group->id == $arrgroupid[0]) {
                $group->firstelement = true;
                $data['group_name_select'] = $group->name;
            }
        }

        $data['list_students'] = get_students_by_select($selectgroupid, $courseid, $activityid, $moduletype);
        $data['count_all_students'] = count(get_students_course($courseid));
        $data['cards'] = get_cards($activityid, $moduletype, $courseid, $arrgroupid[0]);
        $data['if_user_teacher'] = if_user_teacher_on_course($courseid);
        $data['if_user_student'] = if_user_student_on_course($courseid);

        $html = $OUTPUT->render_from_template('filter_teamwork/main', $data);

        $arrcontent = array(
                'shadow' => (if_teamwork_enable($activityid)) ? 'skin_hide' : 'skin_show',
                'content' => $html
        );

        $result = array();
        $result['result'] = json_encode($arrcontent);
        return $result;
    }

    public static function render_teams_card_parameters() {
        return new external_function_parameters(

                array(
                        'courseid' => new external_value(PARAM_INT, 'courseid int', VALUE_DEFAULT, null),
                        'activityid' => new external_value(PARAM_INT, 'activityid int', VALUE_DEFAULT, null),
                        'moduletype' => new external_value(PARAM_TEXT, 'moduletype text', VALUE_DEFAULT, null),
                        'selectgroupid' => new external_value(PARAM_TEXT, 'selectgroupid text', VALUE_DEFAULT, null),
                )
        );
    }

    public static function render_teams_card_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function render_teams_card($courseid, $activityid, $moduletype, $selectgroupid) {
        global $OUTPUT, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $arrgroupid = json_decode($selectgroupid);

        $data = array();
        $data['cards'] = get_cards($activityid, $moduletype, $courseid, $arrgroupid[0]);
        $data['if_user_teacher'] = if_user_teacher_on_course($courseid);
        $data['allow_add_teams'] = allow_add_teams($courseid, $activityid, $arrgroupid[0]);

        $html = $OUTPUT->render_from_template('filter_teamwork/teams-card', $data);

        $arrcontent = array(
                'content' => $html,
                'header' => ''
        );

        $result = array();
        $result['result'] = json_encode($arrcontent);
        return $result;
    }

    public static function render_student_list_parameters() {
        return new external_function_parameters(
                array(
                        'courseid' => new external_value(PARAM_INT, 'courseid int', VALUE_DEFAULT, null),
                        'activityid' => new external_value(PARAM_INT, 'activityid int', VALUE_DEFAULT, null),
                        'moduletype' => new external_value(PARAM_TEXT, 'moduletype text', VALUE_DEFAULT, null),
                        'selectgroupid' => new external_value(PARAM_TEXT, 'selectgroupid text', VALUE_DEFAULT, null),
                )
        );
    }

    public static function render_student_list_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function render_student_list($courseid, $activityid, $moduletype, $selectgroupid) {
        global $OUTPUT, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $data = array();
        $data['list_students'] = get_students_by_select($selectgroupid, $courseid, $activityid, $moduletype);

        $html = $OUTPUT->render_from_template('filter_teamwork/students', $data);

        $arrcontent = array(
                'content' => $html,
                'header' => ''
        );

        $result = array();
        $result['result'] = json_encode($arrcontent);
        return $result;
    }

    public static function render_student_settings_popup_parameters() {
        return new external_function_parameters(

                array(
                        'activityid' => new external_value(PARAM_INT, 'activityid int', VALUE_DEFAULT, null),
                        'moduletype' => new external_value(PARAM_TEXT, 'moduletype text', VALUE_DEFAULT, null),
                )
        );
    }

    public static function render_student_settings_popup_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function render_student_settings_popup($activityid, $moduletype) {
        global $DB, $OUTPUT, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        // Get data from DB.
        $teamworkdata = $DB->get_record('teamwork', array('moduleid' => $activityid, 'type' => $moduletype));
        if ($teamworkdata) {
            // Decodede and parse unixdate for separate values.
            if (!empty($teamworkdata->teamuserenddate)) {
                $teamuserenddate = new DateTime("now", core_date::get_server_timezone_object());
                $teamuserenddate->setTimestamp($teamworkdata->teamuserenddate);
            } else {
                $teamuserenddate = new DateTime("7 days",
                        core_date::get_server_timezone_object());
            }
            $teamworkdata->endday = $teamuserenddate->format('d');
            $teamworkdata->endmonth = $teamuserenddate->format('m');
            $teamworkdata->endyear = $teamuserenddate->format('Y');
            $teamworkdata->endhour = $teamuserenddate->format('H');
            $teamworkdata->endmin = $teamuserenddate->format('i');

            // Create months array for select tag.
            $monthselect = array();
            for ($i = 1; $i <= 12; $i++) {
                $monthselect[$i - 1]['mnum'] = $i;
                $monthselect[$i - 1]['mname'] = get_string('month' . $i, 'filter_teamwork');
                if ($monthselect[$i - 1]['mnum'] == $teamworkdata->endmonth) {
                    $monthselect[$i - 1]['selected'] = 'selected';
                }
            }
            $teamworkdata->monthselect = $monthselect;

            if ($teamworkdata->teamuserallowenddate == 1) {
                $teamworkdata->userenddateallowchecked = "checked";
                $teamworkdata->userenddateallowvalue = "1";
            } else {
                $teamworkdata->userenddateallowvalue = "0";
                $teamworkdata->userenddatedisabled = 'disabled="disabled"';
            }

            // Render the popup.
            $html = $OUTPUT->render_from_template('filter_teamwork/student_settings', $teamworkdata);
        }

        $arrcontent = array(
                'content' => $html,
                'header' => get_string('header_student_settings', 'filter_teamwork')
        );

        $result = array();
        $result['result'] = json_encode($arrcontent);
        return $result;
    }

    public static function set_teamwork_enable_parameters() {
        return new external_function_parameters(

                array(
                        'activityid' => new external_value(PARAM_INT, 'activityid int', VALUE_DEFAULT, null),
                        'moduletype' => new external_value(PARAM_TEXT, 'moduletype text', VALUE_DEFAULT, null),
                )
        );
    }

    public static function set_teamwork_enable_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function set_teamwork_enable($activityid, $moduletype) {
        global $USER, $DB, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $teamwork = $DB->get_record('teamwork', array('moduleid' => $activityid, 'type' => $moduletype));
        if (!empty($teamwork)) {
            switch ($teamwork->active) {
                case 0:
                    $teamwork->active = 1;
                    break;
                case 1:
                    $teamwork->active = 0;
                    break;
                default:
                    $teamwork->active = 1;
            }
            $DB->update_record('teamwork', $teamwork, $bulk = false);
        } else {
            $dataobject = new stdClass();
            $dataobject->creatorid = $USER->id;
            $dataobject->moduleid = $activityid;
            $dataobject->type = $moduletype;
            $dataobject->studentediting = 1;
            $dataobject->active = 1;
            $dataobject->timecreated = time();
            $dataobject->timemodified = time();
            $DB->insert_record('teamwork', $dataobject);
        }

        $result = array();
        $result['result'] = json_encode(array());
        return $result;
    }

    public static function set_access_to_student_parameters() {
        return new external_function_parameters(

                array(
                        'access' => new external_value(PARAM_INT, 'access int', VALUE_DEFAULT, null),
                        'activityid' => new external_value(PARAM_INT, 'activityid int', VALUE_DEFAULT, null),
                        'moduletype' => new external_value(PARAM_TEXT, 'moduletype text', VALUE_DEFAULT, null),
                )
        );
    }

    public static function set_access_to_student_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function set_access_to_student($access, $activityid, $moduletype) {
        global $DB, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $teamwork = $DB->get_record('teamwork', array('moduleid' => $activityid, 'type' => $moduletype));
        if (!empty($teamwork)) {
            switch ($teamwork->studentediting) {
                case 0:
                    $teamwork->studentediting = 1;
                    break;
                case 1:
                    $teamwork->studentediting = 0;
                    break;
                default:
                    $teamwork->studentediting = 0;
            }
            $DB->update_record('teamwork', $teamwork, $bulk = false);
        }

        $result = array();
        $result['result'] = json_encode(array());
        return $result;
    }

    public static function add_new_card_parameters() {
        return new external_function_parameters(
                array(
                        'courseid' => new external_value(PARAM_INT, 'courseid int', VALUE_DEFAULT, null),
                        'activityid' => new external_value(PARAM_INT, 'activityid int', VALUE_DEFAULT, null),
                        'moduletype' => new external_value(PARAM_TEXT, 'moduletype text', VALUE_DEFAULT, null),
                        'selectgroupid' => new external_value(PARAM_TEXT, 'selectgroupid text', VALUE_DEFAULT, null),
                )
        );
    }

    public static function add_new_card_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function add_new_card($courseid, $activityid, $moduletype, $selectgroupid) {
        global $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $arrgroupid = json_decode($selectgroupid);
        foreach ($arrgroupid as $id) {
            $card = add_new_card($activityid, $moduletype, $id, array(), $courseid);
        }

        $result = array();
        $result['result'] = json_encode($card);
        return $result;
    }

    public static function delete_card_parameters() {
        return new external_function_parameters(
                array(
                        'teamid' => new external_value(PARAM_INT, 'teamid int', VALUE_DEFAULT, null),
                )
        );
    }

    public static function delete_card_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function delete_card($teamid) {
        global $DB, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $DB->delete_records('teamwork_groups', array('id' => $teamid));
        $DB->delete_records('teamwork_members', array('teamworkgroupid' => $teamid));

        $result = array();
        $result['result'] = json_encode(array());
        return $result;
    }

    public static function show_random_popup_parameters() {
        return new external_function_parameters(
                array()
        );
    }

    public static function show_random_popup_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function show_random_popup() {
        global $OUTPUT, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $data = array('num_students' => FILTER_TEAMWORK_USERS_IN_GROUP);
        $html = $OUTPUT->render_from_template('filter_teamwork/popup-team-selection', $data);

        $arrcontent = array(
                'content' => $html,
                'header' => get_string('random_groups', 'filter_teamwork'),
        );

        $result = array();
        $result['result'] = json_encode($arrcontent);
        return $result;
    }

    public static function set_random_team_parameters() {
        return new external_function_parameters(
                array(
                        'numberofstudent' => new external_value(PARAM_INT, 'number of student int', VALUE_DEFAULT, null),
                        'courseid' => new external_value(PARAM_INT, 'courseid int', VALUE_DEFAULT, null),
                        'activityid' => new external_value(PARAM_INT, 'activityid int', VALUE_DEFAULT, null),
                        'moduletype' => new external_value(PARAM_TEXT, 'moduletype text', VALUE_DEFAULT, null),
                        'selectgroupid' => new external_value(PARAM_TEXT, 'selectgroupid text', VALUE_DEFAULT, null),
                )
        );
    }

    public static function set_random_team_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function set_random_team($numberofstudent, $courseid, $activityid, $moduletype, $selectgroupid) {
        global $DB, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $arrselectid = json_decode($selectgroupid);

        $teamwork = $DB->get_record('teamwork', array('moduleid' => $activityid, 'type' => $moduletype));
        if (!empty($teamwork)) {

            // Delete all cards from tables.
            $teams = $DB->get_records('teamwork_groups', array('teamworkid' => $teamwork->id, 'groupid' => $arrselectid[0]));
            foreach ($teams as $team) {
                $DB->delete_records('teamwork_members', array('teamworkgroupid' => $team->id));
                $DB->delete_records('teamwork_groups', array('id' => $team->id));
            }

            // Insert new teams.
            $students = get_students_by_select($selectgroupid, $courseid, $activityid, $moduletype);
            shuffle($students);
            $chunk = array_chunk($students, $numberofstudent);

            foreach ($chunk as $item) {
                add_new_card($activityid, $moduletype, $arrselectid[0], $item, $courseid);
            }
        }

        $result = array();
        $result['result'] = json_encode(array());
        return $result;
    }

    public static function set_new_team_name_parameters() {
        return new external_function_parameters(
                array(
                        'cardid' => new external_value(PARAM_INT, 'cardid int', VALUE_DEFAULT, null),
                        'cardname' => new external_value(PARAM_TEXT, 'cardname text', VALUE_DEFAULT, null),
                )
        );
    }

    public static function set_new_team_name_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function set_new_team_name($cardid, $cardname) {
        global $DB, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $team = $DB->get_record('teamwork_groups', array('id' => $cardid));
        if (!empty($team)) {
            $team->name = $cardname;
            $DB->update_record('teamwork_groups', $team, $bulk = false);
        }

        $result = array();
        $result['result'] = json_encode(array());
        return $result;
    }

    public static function drag_student_card_parameters() {
        return new external_function_parameters(

                array(
                        'courseid' => new external_value(PARAM_INT, 'courseid int', VALUE_DEFAULT, null),
                        'activityid' => new external_value(PARAM_INT, 'activityid int', VALUE_DEFAULT, null),
                        'moduletype' => new external_value(PARAM_TEXT, 'moduletype text', VALUE_DEFAULT, null),
                        'selectgroupid' => new external_value(PARAM_TEXT, 'selectgroupid text', VALUE_DEFAULT, null),
                        'newteamspost' => new external_value(PARAM_TEXT, 'newteamspost text', VALUE_DEFAULT, null),
                        'draguserid' => new external_value(PARAM_INT, 'draguserid int', VALUE_DEFAULT, null),
                )
        );
    }

    public static function drag_student_card_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function drag_student_card($courseid, $activityid, $moduletype, $selectgroupid, $newteamspost, $draguserid) {
        global $USER, $DB, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $newteams = json_decode($newteamspost);

        $teamwork = $DB->get_record('teamwork', array('moduleid' => $activityid, 'type' => $moduletype));

        // Validate drag and drop.
        if (if_user_student_on_course($courseid) && $draguserid != $USER->id) {
            $students = get_students_by_select($selectgroupid, $courseid, $activityid, $moduletype);

            $flag = 0;
            foreach ($students as $student) {
                if ($student->userid == $draguserid) {
                    $flag = 1;
                }
            }

            if (!$flag) {
                return json_encode(array('error' => 1, 'errormsg' => get_string('error_drag_drop', 'filter_teamwork')));
            }
        }

        foreach ($newteams as $team) {
            if (!empty($team->teamid)) {

                // If action is done by student - apply some filters, limits or additional actions.
                if (if_user_student_on_course($courseid)) {

                    // SF - #753 - Validate number of the team users. Do not add new team member if limit is exceeded.
                    if (count($team->studentid) > $teamwork->teamusernumbers && !empty($teamwork->teamusernumbers)) {
                        continue;
                    }

                    // SG - #754 - don't let user drag another, if he/she doesn/t belong to this team.
                    if (!in_array($USER->id, $team->studentid) && $draguserid != $USER->id) {
                        continue;
                    }

                    // SG - #855 - remove card, if empty team after dragging self out of team.
                    if (empty($team->studentid) && $draguserid == $USER->id) {
                        $DB->delete_records('teamwork_groups', array('id' => $team->teamid));
                        $DB->delete_records('teamwork_members', array('teamworkgroupid' => $team->teamid));
                    }
                }

                // Step 1.
                $arrstudentsrequest = array();
                foreach ($team->studentid as $studentid) {
                    if (!empty($studentid)) {
                        $arrstudentsrequest[] = $studentid;
                        $obj = $DB->get_record('teamwork_members',
                                array('teamworkgroupid' => $team->teamid, 'userid' => $studentid));
                        if (empty($obj)) {
                            $dataobject = new stdClass();
                            $dataobject->teamworkgroupid = $team->teamid;
                            $dataobject->userid = $studentid;
                            $dataobject->timecreated = time();
                            $dataobject->timemodified = time();
                            $DB->insert_record('teamwork_members', $dataobject);
                        }
                    }
                }

                // Step 2.
                $obj = $DB->get_records('teamwork_members', array('teamworkgroupid' => $team->teamid));
                foreach ($obj as $item) {
                    if (!in_array($item->userid, $arrstudentsrequest)) {
                        $DB->delete_records('teamwork_members', array('id' => $item->id));
                    }
                }

            }
        }

        $result = array();
        $result['result'] = json_encode(array());
        return $result;
    }

    public static function student_settings_popup_data_parameters() {
        return new external_function_parameters(
                array(
                        'courseid' => new external_value(PARAM_INT, 'courseid int', VALUE_DEFAULT, null),
                        'activityid' => new external_value(PARAM_INT, 'activityid int', VALUE_DEFAULT, null),
                        'moduletype' => new external_value(PARAM_TEXT, 'moduletype text', VALUE_DEFAULT, null),
                        'teamnumbers' => new external_value(PARAM_INT, 'teamnumbers int', VALUE_DEFAULT, 10),
                        'teamusernumbers' => new external_value(PARAM_INT, 'teamusernumbers int', VALUE_DEFAULT, 3),
                        'teamuserallowenddate' => new external_value(PARAM_RAW, 'teamuserallowenddate int', VALUE_DEFAULT, null),
                        'teamuserenddate' => new external_value(PARAM_RAW, 'teamuserenddate int', VALUE_DEFAULT, null),
                        'teamuserendmonth' => new external_value(PARAM_RAW, 'teamuserendmonth int', VALUE_DEFAULT, null),
                        'teamuserendyear' => new external_value(PARAM_RAW, 'teamuserendyear int', VALUE_DEFAULT, null),
                        'teamuserendhour' => new external_value(PARAM_RAW, 'teamuserendhour int', VALUE_DEFAULT, null),
                        'teamuserendminute' => new external_value(PARAM_RAW, 'teamuserendminute int', VALUE_DEFAULT, null),
                )
        );
    }

    public static function student_settings_popup_data_returns() {
        return new external_single_structure(
                array(
                        'result' => new external_value(PARAM_RAW, 'result json'),
                )
        );
    }

    public static function student_settings_popup_data($courseid, $activityid, $moduletype, $teamnumbers, $teamusernumbers,
            $teamuserallowenddate, $teamuserenddate, $teamuserendmonth, $teamuserendyear, $teamuserendhour, $teamuserendminute) {
        global $DB, $PAGE;

        $context = context_system::instance();
        $PAGE->set_context($context);

        $result = array();

        $teamnumbers = (empty($teamnumbers)) ? 10 : $teamnumbers;
        $teamusernumbers = (empty($teamusernumbers)) ? 3 : $teamusernumbers;
        $teamuserenddatestring =
                $teamuserendyear . '-' . $teamuserendmonth . '-' . $teamuserenddate . 'T' . $teamuserendhour . ':' .
                $teamuserendminute . ':00';
        $teamuserenddate = new DateTime($teamuserenddatestring, core_date::get_server_timezone_object());

        if ($teamuserenddate) {
            $teamuserenddateunix = $teamuserenddate->getTimestamp();
        } else {
            $teamuserenddateunix = null;
        }

        // Update students limits in DB.
        $teamworkdata = $DB->get_record('teamwork', array('moduleid' => $activityid, 'type' => $moduletype));
        if (!empty($teamworkdata)) {
            $teamworkdata->teamnumbers = $teamnumbers;
            $teamworkdata->teamusernumbers = $teamusernumbers;
            $teamworkdata->teamuserallowenddate = $teamuserallowenddate;
            if ($teamuserallowenddate == "0") {
                $teamworkdata->teamuserenddate = null;
            } else if ($teamuserallowenddate == "1") {
                $teamworkdata->teamuserenddate = $teamuserenddateunix;
            }

            $DB->update_record('teamwork', $teamworkdata);
        } else {
            $result['result'] = json_encode(array('error' => 2,
                    'errormsg' => get_string('error_no_db_entry', 'filter_teamwork')));
            return $result;
        }

        $result['result'] = json_encode(array('OK'));
        return $result;
    }
}
