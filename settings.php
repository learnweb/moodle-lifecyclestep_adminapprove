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
 * Settings page which gives an overview over running lifecycle processes.
 *
 * @package lifecyclestep_adminapprove
 * @copyright  2019 Justus Dieckmann WWU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {

    $ADMIN->add('lifecycle_category', new admin_category('lifecyclestep_adminapprove_category',
            get_string('pluginname', 'lifecyclestep_adminapprove')));

    $settings = new admin_settingpage('lifecyclestep_adminapprove',
            get_string('settings:general', 'lifecyclestep_adminapprove'));

    $settings->add(new admin_setting_configtext('lifecyclestep_adminapprove/mailusers',
        get_string('setting:mailusers', 'lifecyclestep_adminapprove'),
        get_string('setting:mailusers:desc', 'lifecyclestep_adminapprove'),
        '',
    ));

    $ADMIN->add('lifecyclestep_adminapprove_category', $settings);

    $ADMIN->add('lifecyclestep_adminapprove_category',
            new admin_externalpage('lifecyclestep_adminapprove_manage',
            get_string('manage-adminapprove', 'lifecyclestep_adminapprove'),
            new moodle_url('/admin/tool/lifecycle/step/adminapprove/index.php')));

}
