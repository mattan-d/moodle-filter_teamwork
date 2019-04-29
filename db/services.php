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
 * Core external functions and service definitions.
 *
 * The functions and services defined on this file are
 * processed and registered into the Moodle DB after any
 * install or upgrade operation. All plugins support this.
 *
 * For more information, take a look to the documentation available:
 *     - Webservices API: {@link http://docs.moodle.org/dev/Web_services_API}
 *     - External API: {@link http://docs.moodle.org/dev/External_functions_API}
 *     - Upgrade API: {@link http://docs.moodle.org/dev/Upgrade_API}
 *
 * @package    local_sharingactivity
 * @category   webservice
 * @copyright  2009 Petr Skodak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(

    // Render main popup.
        'render_teamwork_html' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'render_teamwork_html',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Render teamwork html',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Render teams card.
        'render_teams_card' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'render_teams_card',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Render teams card',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Render student list.
        'render_student_list' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'render_student_list',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Render student list',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Render student list.
        'render_student_settings_popup' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'render_student_settings_popup',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Render student settings popup',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Set teamwork enable/disable.
        'set_teamwork_enable' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'set_teamwork_enable',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Set teamwork enable',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Set access to student.
        'set_access_to_student' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'set_access_to_student',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Set teamwork enable',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Add new card.
        'add_new_card' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'add_new_card',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Add new card',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Delete card.
        'delete_card' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'delete_card',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Delete card',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Show random popup.
        'show_random_popup' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'show_random_popup',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Show random popup',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Set random team.
        'set_random_team' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'set_random_team',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Set random team',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Set name card.
        'set_new_team_name' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'set_new_team_name',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Set new team name',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Drag student to/from card.
        'drag_student_card' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'drag_student_card',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Drag_student_card',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),

    // Student settings popup data.
        'student_settings_popup_data' => array(
                'classname' => 'filter_teamwork_external',
                'methodname' => 'student_settings_popup_data',
                'classpath' => 'filter/teamwork/externallib.php',
                'description' => 'Student settings popup data',
                'type' => 'read',
                'ajax' => true,
                'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
        ),
);
