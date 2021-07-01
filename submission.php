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
require_once($CFG->dirroot . '/mod/testattendance/classes/form/submission_form.php');

$attendanceid = required_param('attendanceid', PARAM_INT); // Course Module ID, or ...
$id = optional_param('id', 0, PARAM_INT); // Attendance Module ID, or ...

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
require_capability('mod/testattendance:submit', $context);

global $USER;
global $DB;

$PAGE->set_url('/mod/testattendance/submission.php');
$PAGE->set_title(get_string('pluginname', 'testattendance'));
$PAGE->set_heading(get_string('pluginname', 'testattendance'));

// Check for existing attendance.

$doesattendanceexist = $DB->record_exists('testattendance_logs', array('userid' => $USER->id));

$previouslog = $DB->get_record('testattendance_logs', array('userid' => $USER->id, 'attendanceid' => $attendanceid), 'id, timestamp', MUST_EXIST);



//Instantiate simplehtml_form
$formparameters = ['id' => $id, 'attendanceid' => $attendanceid];
$mform = new submission_form(null, $formparameters);

$viewurl = new moodle_url('/mod/testattendance/view.php', array('id' => $id, 'attendanceid' => $attendanceid));

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    // Handle form cancel operation, if cancel button is present on form.
    redirect($viewurl);
} else if ($fromform = $mform->get_data()) {
    if ($doesattendanceexist and is_null($previouslog->timestamp)) {
        $record = new stdClass();
        $record->id = $previouslog->id;
        $record->status = 1;
        $record->timestamp = time();

        $DB->update_record('testattendance_logs', $record);
    }
    redirect($viewurl, 'You have taken this attendance');
}

echo $OUTPUT->header();
echo $OUTPUT->heading("SUBMISSION");
$mform->display();
echo $OUTPUT->footer();

// if ($doesattendanceexist and is_null($previouslog->timestamp)) {
//     // Update attendance log to DB.
//     $record = new stdClass();
//     $record->id = $previouslog->id;
//     $record->status = 1;
//     $record->timestamp = time();

//     $DB->update_record('testattendance_logs', $record);
// }

// echo $OUTPUT->header();

// echo $OUTPUT->heading("SUBMISSION");

// if ($doesattendanceexist and is_null($previouslog->timestamp)) {
//     echo html_writer::tag('p', 'You haven\'t taken this attendance yet, click the button below to submit your attendance now.');
//     echo html_writer::tag('a', 'Submit attendance', [
//         'href' => '',
//         'class' => 'btn btn-primary',
//     ]);
// } else {
//     echo html_writer::tag('p', 'You have already taken this attendance. Click the button below to remove your attendance.');
//     echo html_writer::tag('p', 'WARNING! YOU CANNOT RETRIEVE YOUR DATA BACK!');
//     echo html_writer::tag('a', 'Delete attendance', [
//         'href' => '',
//         'class' => 'btn btn-danger',
//     ]);
// }
// echo html_writer::tag('a', 'Back', [
//         'href' => new moodle_url('/mod/testattendance/view.php', ['id' => $id]),
//         'class' => 'btn btn-secondary',
// ]);
// echo $OUTPUT->footer();