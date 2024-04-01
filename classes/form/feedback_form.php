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
//namespace local_feedback_form\form;
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class local_feedback_form extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG, $DB;

        $mform = $this->_form; // Don't forget the underscore! 

        $mform->addElement('header', '', get_string('feedbackform', 'local_hubspot'));
        $mform->addElement('text', 'username', get_string('username'), 'maxlength="100" size="12" autocapitalize="none"');
        $mform->setType('username', PARAM_RAW);
        $mform->addRule('username', get_string('missingusername'), 'required', null, 'client');
        
        $mform->addElement('text', 'firstname', get_string('firstname'));
        $mform->setType('firstname', PARAM_RAW);
        $mform->addRule('firstname', get_string('missingfirstname'), 'required', null, 'client');
        
        $mform->addElement('text', 'lastname', get_string('lastname'));
        $mform->setType('lastname', PARAM_RAW);
        $mform->addRule('lastname', get_string('missinglastname'), 'required', null, 'client');
        
        $strrequired = get_string('required');
        $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" size="30" autocomplete="email"');
        $mform->addRule('email', $strrequired, 'required', null, 'client');
        $mform->setType('email', PARAM_RAW_TRIMMED);
        
        
         // Add the form actions.
        $this->add_action_buttons();
    }

    //Custom validation should be added here
    function validation($data, $files) {
        global $USER;
        $errors = parent::validation($data, $files);
        $data = (object)$data;
        if (empty($data->username)) {
            // Might be only whitespace.
            $errors['firstname'] = get_string('required');
        }

        if (empty($data->username)) {
            // Might be only whitespace.
            $errors['lastname'] = get_string('required');
        }
        if (empty($data->username)) {
            // Might be only whitespace.
            $errors['username'] = get_string('required');
        } else if ($data->username !== core_text::strtolower($data->username)) {
            $errors['username'] = get_string('usernamelowercase');
        } else {
            if ($data->username !== core_user::clean_field($data->username, 'username')) {
                $errors['username'] = get_string('invalidusername');
            }
        }

        if (!validate_email($data->email)) {
            $errors['email'] = get_string('invalidemail');
        } 
        return $errors;
    }

}
