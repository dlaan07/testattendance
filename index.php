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
 * File.
 *
 * @package    core
 * @copyright  2021
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$id = required_param('id', PARAM_INT);

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);
require_login($course);

$PAGE->set_url(new moodle_url('/mod/testattendance/index.php'), array('id' => $id));
$PAGE->set_pagelayout('incourse');


context_course::instance($course->id);
require_capability('mod/attendance:view', $context);

echo $OUTPUT->header();
echo $OUTPUT->heading("Index");
echo "TEST";
echo $OUTPUT->footer();