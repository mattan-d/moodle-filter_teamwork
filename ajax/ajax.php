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

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/filter/teamwork/classes/classAjax.php');

if (!defined('AJAX_SCRIPT')) {
    define('AJAX_SCRIPT', true);
}

require_login();

$context = context_system::instance();
$PAGE->set_context($context);

require_sesskey();

$ajax = new classAjax();
echo $ajax->run();


