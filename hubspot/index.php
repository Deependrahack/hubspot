<?php

// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @package     local_hubspot
 * @category    string
 * @copyright   2024 Deependra Kumar Singh <deepcs20@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../config.php');
require_once($CFG->dirroot . '/local/hubspot/classes/form/feedback_form.php');
require_once 'lib.php';
require_login();
$context = context_system::instance();
$edit = optional_param('edit', -1, PARAM_BOOL);
$PAGE->set_url('/local/hubspot/index.php');
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'local_hubspot'));
$PAGE->set_pagelayout('admin');
global $DB, $PAGE;
$editdata = array();
$mform = new \local_feedback_form(null, array(), 'post');
$mform->set_data((array) $editdata);
if ($mform->is_cancelled()) {
    $url = new moodle_url('/my');
    redirect($url);
} else if ($fromform = $mform->get_data()) {
    global $DB;
    $data = [];
    $data['username'] = $fromform->username;
    $data['firstname'] = $fromform->firstname;
    $data['lastname'] = $fromform->lastname;
    $data['email'] = $fromform->email;
    $response = push_data_hubspot($data);
    $logdata = new \stdClass();
    $logdata->sendrequest = json_encode($response);
    $logdata->response = json_encode($response);
    $logdata->timemodified = time();
    $logdata->timecreated = time();
    $DB->insert_record('hubspot_log', $logdata);
    if(isset($response->id)){
        redirect('#', get_string('contactcreated', 'local_hubspot'));
    }else if(isset($response->message)){
        redirect('#', get_string('contactexits', 'local_hubspot'));
    }else {
        redirect('#', 'Contact site adminstration', '', \core\output\notification::NOTIFY_ERROR);
    }
}
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
