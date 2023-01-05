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
 * Life Cycle Admin Approve Step
 *
 * @package lifecyclestep_adminapprove
 * @copyright  2019 Justus Dieckmann WWU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

admin_externalpage_setup('lifecyclestep_adminapprove_manage');

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new \moodle_url("/admin/tool/lifecycle/step/adminapprove/index.php"));
$PAGE->set_title(get_string('pluginname', 'lifecyclestep_adminapprove'));
$PAGE->set_heading(get_string('pluginname', 'lifecyclestep_adminapprove'));

echo $OUTPUT->header();

$table = new lifecyclestep_adminapprove\step_table();
$table->out(100, false);

$PAGE->requires->js_call_amd('lifecyclestep_adminapprove/link-steps', 'init');

echo $OUTPUT->footer();

