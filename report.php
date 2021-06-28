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

// Check login and get context.
require_login($course, false, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/testattendance:report', $context);

$PAGE->set_url('/mod/testattendance/report.php');
$PAGE->set_title(get_string('pluginname', 'testattendance'));
$PAGE->set_heading(get_string('pluginname', 'testattendance'));

$attendancedata = $DB->get_records('testattendance_logs', array('attendanceid' => $cm->instance), '', '*');

$reporttable = new html_table();

echo $OUTPUT->header();

echo $OUTPUT->heading("REPORT");

$headerfirstname = new html_table_cell('First Name');
$headerlastname = new html_table_cell('Last Name');
$headerstatus = new html_table_cell('Status');
$headertime = new html_table_cell('Time');

$reportheader = new html_table_row();
$reportheader->cells = array($headerfirstname, $headerlastname, $headerstatus, $headertime);

$reporttable->data[] = $reportheader;

$statusnames = ['Absent', 'Present'];
foreach ($attendancedata as $data) {
    $name = $DB->get_record('user', array('id' => $data->userid), 'firstname, lastname');
    $firstname = $name->firstname;
    $lastname = $name->lastname;
    $status = $statusnames[$data->status];
    $time = date("H:i:s", $data->timestamp);

    $reportdata = array($firstname, $lastname, $status, $time);
    $reporttable->data[] = $reportdata;
}
echo html_writer::table($reporttable);

echo $OUTPUT->footer();
