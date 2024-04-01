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
 * Plugin administration pages are defined here.
 *
 * @package     local_hubspot
 * @category    admin
 * @copyright   2024 Deependra Kumar Singh <deepcs20@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settingspage = new admin_settingpage('local_hubspot_settings', new lang_string('pluginname', 'local_hubspot'));
    $ADMIN->add('localplugins', $settingspage);
    $name = 'local_hubspot/hubspot_accesstoken';
    $title = get_string('hubspot_accesstoken', 'local_hubspot');
    $description = get_string('hubspot_accesstoken_desc', 'local_hubspot');
    $default = "";
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_RAW);
    $settingspage->add($setting);
    $name = 'local_hubspot/hubspot_endpointurl';
    $title = get_string('hubspot_endpointurl', 'local_hubspot');
    $description = get_string('hubspot_endpointurl_desc', 'local_hubspot');
    $default = "";
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_RAW);
    $settingspage->add($setting);
}
