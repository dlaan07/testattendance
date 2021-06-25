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
require_login();
if (isguestuser()) {
    print_error('noguest');
}

global $DB;
global $USER;

$id = optional_param('id', 0, PARAM_INT); // Course Module ID, or ...

if ($id) {
    if (!$cm = get_coursemodule_from_id('testattendance', $id)) {
        print_error('invalidcoursemodule');
    }
    if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
        print_error('coursemisconf');
    }
}

$attendance = $DB->get_record('testattendance', array('id' => $cm->instance), '*', MUST_EXIST);
$attendanceid = $attendance->id;
$attendancetimeopen = $attendance->timeopen;
$attendancetimeclose = $attendance->timeclose;

// Check login and get context.
require_login($course, false, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/testattendance:view', $context);

// Setting page properties
$PAGE->set_url('/mod/testattendance/view.php', array('id' => $cm->id));
$PAGE->set_title(get_string('pluginname', 'testattendance'));
$PAGE->set_heading(get_string('pluginname', 'testattendance'));

// Creating URL for report and submission
$reporturl = new moodle_url('/mod/testattendance/report.php', ['attendanceid' => $attendanceid]);
$submissionurl = new moodle_url('/mod/testattendance/submission.php', ['id' => $cm->id, 'attendanceid' => $attendanceid]);

// Outputting the view
echo $OUTPUT->header();

echo $OUTPUT->heading($attendance->name);
echo html_writer::tag('p', $attendance->intro);

if (has_capability('mod/testattendance:report', $context)) {
    $doeslogexist = $DB->record_exists('testattendance_logs', array('attendanceid' => $attendanceid));
    // $doeslogexist = false;
    if ($doeslogexist) {
        echo html_writer::tag('p', 'Absent:');
        echo html_writer::tag('p', 'Present:');
        echo html_writer::tag('a', "View Report", [
            'href' => $reporturl,
            'class' => "btn btn-primary",
        ]);
    } else {
        echo html_writer::tag('p', 'No one has taken this attendance yet.');
    }
}

if (has_capability('mod/testattendance:submit', $context)) {
    $now = time();
    if ($now >= $attendancetimeopen and $now < $attendancetimeopen) {
        echo html_writer::tag('a', "Take attendance", [
            'href' => $submissionurl,
            'class' => "btn btn-primary",
        ]);
    } else {
        echo html_writer::tag('p', 'This attendance has been closed');
        echo html_writer::tag('a', "Take attendance", [
            'href' => $submissionurl,
            'class' => "disabled btn btn-primary",
        ]);
    }
}

echo $OUTPUT->footer();