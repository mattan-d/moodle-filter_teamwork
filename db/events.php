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
 * Allow teachers and students to create and manage "teams" from within the assignment.
 * These "teams" exist only in that specific assignment, and are used for collaborative submission of that assignment.
 *
 * @package     filter
 * @subpackage  teamwork
 * @copyright   2019 onwards - Weizmann institute, Department of Science teaching.
 * @author      PeTeL project manager petel@weizmann.ac.il
 * @author      Devlion LTD info@devlion.co
 * @author      Nadav Kavalerchik <nadav.kavalerchik@weizmann.ac.il>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$observers = array(
    array(
        'eventname' => '\mod_assign\event\submission_graded',
        'callback' => '\filter_teamwork\observer::update_team_members_grades',
        'schedule' => 'instant',
    ),
    array(
        'eventname' => '\assignsubmission_onlinetext\event\submission_updated',
        'callback' => '\filter_teamwork\observer::update_team_memebers_submision_status_updated',
        'schedule' => 'instant',
    ),
    array(
        'eventname' => '\assignsubmission_file\event\submission_updated',
        'callback' => '\filter_teamwork\observer::update_team_memebers_submision_status_updated',
        'schedule' => 'instant',
    ),
    array(
        'eventname' => '\mod_assign\event\submission_created',
        'callback' => '\filter_teamwork\observer::update_team_memebers_submision_status_created',
        'schedule' => 'instant',
    ),
    array(
        'eventname' => '\assignsubmission_file\event\assessable_uploaded',
        'callback' => '\filter_teamwork\observer::update_team_memebers_submitted_files_uploaded',
        'schedule' => 'instant',
    ),
);
