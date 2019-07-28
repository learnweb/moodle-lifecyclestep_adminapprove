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
 * @package tool_lifecycle_step
 * @subpackage adminapprove
 * @copyright  2019 Justus Dieckmann WWU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../../config.php');

require_login(null, false);

require_capability('moodle/site:config', context_system::instance());

$action = optional_param('act', null, PARAM_ALPHA);
$ids = optional_param_array('c', array(), PARAM_INT);
$stepid = required_param('stepid', PARAM_INT);

$step = \tool_lifecycle\manager\step_manager::get_step_instance($stepid);
if (!$step) {
    throw new moodle_exception('Stepid does not correspond to any step.');
}
if ($step->subpluginname !== 'adminapprove') {
    throw new moodle_exception('The given step is not a Admin Approve Step.');
}

$workflow = \tool_lifecycle\manager\workflow_manager::get_workflow($step->workflowid);

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_url(new \moodle_url("/admin/tool/lifecycle/step/adminapprove/approvestep.php?stepid=$stepid"));

if (count($ids) > 0 && ($action == 'proceed' || $action == 'rollback')) {
    $sql = 'UPDATE {lifecyclestep_adminapprove} ' .
        'SET status = ' . ($action == 'proceed' ? 1 : 2) .
        'WHERE id IN (' . implode(',', $ids) . ') ';
    $DB->execute($sql);
}

$mform = new \lifecyclestep_adminapprove\course_filter_form($PAGE->url->out());

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'lifecyclestep_adminapprove'));

$hasrecords = $DB->record_exists_sql('SELECT a.id FROM {lifecyclestep_adminapprove} a ' .
    'JOIN {tool_lifecycle_process} p ON p.id = a.processid ' .
    'JOIN {tool_lifecycle_step} s ON s.workflowid = p.workflowid AND s.sortindex = p.stepindex ' .
    'WHERE s.id = :sid AND a.status = 0', array('sid' => $stepid));

if ($hasrecords) {
    $mform->display();

    echo get_string('courses_waiting', 'lifecyclestep_adminapprove',
        array('step' => $step->instancename, 'workflow' => $workflow->title));
    echo '<form action="" method="post" id="adminapprove-action-form"><input type="hidden" name="act" id="act" value="">';

    $table = new lifecyclestep_adminapprove\decision_table($stepid);
    $table->out(30, false);

    echo '</form>';

    echo 'Bulk actions:<br>';
    echo '<div class="btn btn-secondary m-1" id="adminapprove-bulk-proceed">' . get_string('proceedselected', 'lifecyclestep_adminapprove') . '</div>';
    echo '<div class="btn btn-secondary m-1" id="adminapprove-bulk-rollback">' . get_string('rollbackselected', 'lifecyclestep_adminapprove') . '</div>';

    $PAGE->requires->js_call_amd('lifecyclestep_adminapprove/init', 'init');
} else {
    echo get_string('no_courses_waiting', 'lifecyclestep_adminapprove',
        array('step' => $step->instancename, 'workflow' => $workflow->title));
}

echo $OUTPUT->footer();
