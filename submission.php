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

require_once(__DIR__ . '/../../config.php');

$id = optional_param('id', 0, PARAM_INT); // Course Module ID, or ...

if ($id) {
    if (!$cm = get_coursemodule_from_id('testattendance', $id)) {
        print_error('invalidcoursemodule');
    }
    if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
        print_error('coursemisconf');
    }
}

// // Check login and get context.
// require_login($course, false, $cm);
// $context = context_module::instance($cm->id);
// require_capability('mod/testattendance:view', $context);

$PAGE->set_url('/mod/testattendance/submission.php');
$PAGE->set_title(get_string('pluginname', 'testattendance'));
$PAGE->set_heading(get_string('pluginname', 'testattendance'));

echo $OUTPUT->header();

echo $OUTPUT->heading("SUBMISSION");

echo $OUTPUT->footer();
