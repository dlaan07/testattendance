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

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot.'/lib/enrollib.php');

function testattendance_add_instance($testattendance) {
    global $DB;
    global $COURSE;

    // Get time now and insert to DB.
    $testattendance->timemodified = time();
    $testattendance->id = $DB->insert_record('testattendance', $testattendance);

    // Get enrolled users.
    $courseid = $COURSE->id;
    $context = context_course::instance($courseid);
    $users = get_enrolled_users($context,  $withcapability = 'mod/testattendance:submit',  $groupid = 0,  $userfields = 'u.id',  $orderby = '',  $limitfrom = 0,  $limitnum = 0);

    // Make all enrolled users attendance default status to absent.
    $dataobjects = array();
    foreach ($users as $user) {
        $data = new stdClass();
        $data->attendanceid = $testattendance->id;
        $data->userid = $user->id;
        $data->status = 0;
        $data->timestamp = null;

        $dataobjects[] = $data;
    }
    $DB->insert_records('testattendance_logs', $dataobjects);

    return $testattendance->id;
}