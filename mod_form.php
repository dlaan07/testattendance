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
require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/testattendance/lib.php');

class mod_testattendance_mod_form extends moodleform_mod {
    public function definition() {
        global $CFG;
        $mform =& $this->_form;

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text', 'name',
            get_string('name'),
            array('size' => '48',
            'maxlength' => '255'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        $this->standard_intro_elements();

        //====TIMING=====//
        $mform->addElement('header', 'timing', get_string('timing', 'testattendance'));

        $mform->addElement('date_time_selector', 'timeopen', get_string('timeopen', 'testattendance'));
        $mform->addHelpButton('timeopen', 'timeopenclose', 'testattendance');
        $mform->addRule('timeopen', null, 'required');

        $mform->addElement('date_time_selector', 'timeclose', get_string('timeclose', 'testattendance'));
        $mform->addHelpButton('timeclose', 'timeopenclose', 'testattendance');
        $mform->addRule('timeclose', null, 'required');

        $mform->addElement('duration', 'timetolerance', get_string('timetolerance', 'testattendance'),
                array('optional' => true));
        $mform->addHelpButton('timetolerance', 'timetolerance', 'testattendance');

        // $mform->addElement('duration', 'timelimit', get_string('timelimit', 'quiz'),
        //         array('optional' => true));
        // $mform->addHelpButton('timelimit', 'timelimit', 'quiz');


        // $mform->addElement('header', 'permissions', get_string('permissions', 'testattendance'));

        // $radioarray = array();
        // $radioarray[] = $mform->createElement('radio', 'permissionphoto', '', get_string('yes'), 1, );
        // $radioarray[] = $mform->createElement('radio', 'permissionphoto', '', get_string('no'), 0, );
        // $mform->addGroup($radioarray, 'permissionphoto', get_string('permissionphoto', 'testattendance'), array(' '), true);
        // $mform->addHelpButton('permissionphoto', 'timeopenclose', 'testattendance');

        // $radioarray = array();
        // $radioarray[] = $mform->createElement('radio', 'permissionlocation', '', get_string('yes'), 1, );
        // $radioarray[] = $mform->createElement('radio', 'permissionlocation', '', get_string('no'), 0, );
        // $mform->addGroup($radioarray, 'permissionlocation', get_string('permissionlocation', 'testattendance'), array(' '), true);
        // $mform->addHelpButton('permissionlocation', 'timeopenclose', 'testattendance');

        $this->standard_coursemodule_elements(true);
        $this->add_action_buttons();
    }
}