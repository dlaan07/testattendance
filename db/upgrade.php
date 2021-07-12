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


function xmldb_testattendance_upgrade($oldversion) {
    global $CFG;
    global $DB;

    $result = true;
    $dbman = $DB->get_manager();

    if ($oldversion < 2021060900) {

        // Define table testattendance to be created.
        $table = new xmldb_table('testattendance');

        // Adding fields to table testattendance.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('course', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('intro', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('introformat', XMLDB_TYPE_INTEGER, '4', null, null, null, null);
        $table->add_field('timeopen', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('timeclose', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table testattendance.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('course', XMLDB_KEY_FOREIGN, ['course'], 'course', ['id']);

        // Conditionally launch create table for testattendance.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Testattendance savepoint reached.
        upgrade_mod_savepoint(true, 2021060900, 'testattendance');
    }

    if ($oldversion < 2021060900) {

        // Define table testattendance_logs to be created.
        $table = new xmldb_table('testattendance_logs');

        // Adding fields to table testattendance_logs.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('attendanceid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('status', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timestamp', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table testattendance_logs.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('attendanceid', XMLDB_KEY_FOREIGN, ['attendanceid'], 'testattendance', ['id']);
        $table->add_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);

        // Conditionally launch create table for testattendance_logs.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Testattendance savepoint reached.
        upgrade_mod_savepoint(true, 2021060900, 'testattendance');
    }
    if ($oldversion < 2021061000) {

        // Define table testattendance to be created.
        $table = new xmldb_table('testattendance');

        // Adding fields to table testattendance.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('course', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('intro', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('introformat', XMLDB_TYPE_INTEGER, '4', null, null, null, null);
        $table->add_field('timeopen', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timeclose', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table testattendance.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('course', XMLDB_KEY_FOREIGN, ['course'], 'course', ['id']);

        // Conditionally launch create table for testattendance.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Testattendance savepoint reached.
        upgrade_mod_savepoint(true, 2021061000, 'testattendance');
    }
    if ($oldversion < 2021061000) {

        // Define table testattendance_logs to be created.
        $table = new xmldb_table('testattendance_logs');

        // Adding fields to table testattendance_logs.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('attendanceid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('firstname', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $table->add_field('lastname', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $table->add_field('status', XMLDB_TYPE_INTEGER, '1', null, null, null, null);
        $table->add_field('timestamp', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table testattendance_logs.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('attendanceid', XMLDB_KEY_FOREIGN, ['attendanceid'], 'testattendance', ['id']);
        $table->add_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);

        // Conditionally launch create table for testattendance_logs.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Testattendance savepoint reached.
        upgrade_mod_savepoint(true, 2021061000, 'testattendance');
    }

    if ($oldversion < 2021061100) {

        // Define table testattendance to be created.
        $table = new xmldb_table('testattendance');

        // Adding fields to table testattendance.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('course', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('intro', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('introformat', XMLDB_TYPE_INTEGER, '4', null, null, null, null);
        $table->add_field('timeopen', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timeclose', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timetoleranceallow', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timetolerance', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table testattendance.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('course', XMLDB_KEY_FOREIGN, ['course'], 'course', ['id']);

        // Conditionally launch create table for testattendance.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Testattendance savepoint reached.
        upgrade_mod_savepoint(true, 2021061100, 'testattendance');
    }


    return $result;
}