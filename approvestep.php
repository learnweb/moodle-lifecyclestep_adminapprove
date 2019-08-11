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
            'SET status = ' . ($action == 'proceed' ? 1 : 2) . ' ' .
            'WHERE id IN (' . implode(',', $ids) . ') ';
    $DB->execute($sql);
}

$mformdata = cache::make('lifecyclestep_adminapprove', 'mformdata');

$mform = new \lifecyclestep_adminapprove\course_filter_form($PAGE->url->out());
if ($mform->is_cancelled()) {
    $mformdata->delete('data');
    redirect($PAGE->url);
}
if ($mformdata->has('data')) {
    $mform->set_data($mformdata->get('data'));
}


echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'lifecyclestep_adminapprove'));

$hasrecords = $DB->record_exists_sql('SELECT a.id FROM {lifecyclestep_adminapprove} a ' .
        'JOIN {tool_lifecycle_process} p ON p.id = a.processid ' .
        'JOIN {tool_lifecycle_step} s ON s.workflowid = p.workflowid AND s.sortindex = p.stepindex ' .
        'WHERE s.id = :sid AND a.status = 0', array('sid' => $stepid));

if ($hasrecords) {
    $courseid = null;
    $coursename = null;
    if ($mform->is_validated()) {
        $data = $mform->get_data();
        $courseid = $data->courseid;
        $coursename = $data->coursename;
        $mformdata->set('data', $data);
    }
    $mform->display();

    echo get_string('courses_waiting', 'lifecyclestep_adminapprove',
            array('step' => $step->instancename, 'workflow' => $workflow->title));
    echo '<form action="" method="post"><input type="hidden" name="sesskey" value="' . sesskey() . '"';

    $table = new lifecyclestep_adminapprove\decision_table($stepid, $courseid, $coursename);
    $table->out(30, false);
    if ($table->totalrows) {
        echo 'Bulk actions:<br>';
        echo html_writer::start_div('singlebutton');
        echo html_writer::tag('button', get_string('proceedselected', 'lifecyclestep_adminapprove'),
                array('type' => 'submit', 'name' => 'act', 'value' => 'proceed', 'class' => 'btn btn-secondary'));
        echo html_writer::end_div() . html_writer::start_div('singlebutton');
        echo html_writer::tag('button', get_string('rollbackselected', 'lifecyclestep_adminapprove'),
                array('type' => 'submit', 'name' => 'act', 'value' => 'rollback', 'class' => 'btn btn-secondary'));
        echo html_writer::end_div();
    }
    echo '</form>';
    $PAGE->requires->js_call_amd('lifecyclestep_adminapprove/init', 'init', array(sesskey(), $PAGE->url->out()));
} else {
    echo get_string('no_courses_waiting', 'lifecyclestep_adminapprove',
            array('step' => $step->instancename, 'workflow' => $workflow->title));
}

echo $OUTPUT->footer();
