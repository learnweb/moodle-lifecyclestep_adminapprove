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

namespace lifecyclestep_adminapprove;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once $CFG->libdir . '/tablelib.php';

class decision_table extends \table_sql {

    private $workflowid;

    public function __construct($wid) {
        $this->workflowid = $wid;
        parent::__construct('lifecyclestep_adminapprove-table');
        $this->define_baseurl("/admin/tool/lifecycle/step/adminapprove/index.php?wid=$wid");
        $this->define_columns(['checkbox', 'courseid', 'course', 'tools']);
        $this->define_headers(
            array(\html_writer::checkbox('checkall', null, false), get_string('courseid', 'lifecyclestep_adminapprove'), get_string('course'),
            get_string('tools', 'lifecyclestep_adminapprove')));
        $this->column_nosort = array('checkbox', 'tools');
        $fields = 'm.id, w.displaytitle as workflow, c.id as courseid, c.fullname as course, m.status';
        $from = '{lifecyclestep_adminapprove} m ' .
            'LEFT JOIN {tool_lifecycle_process} p ON p.id = m.processid ' .
            'LEFT JOIN {course} c ON c.id = p.courseid ' .
            'LEFT JOIN {tool_lifecycle_workflow} w ON w.id = p.workflowid ' .
            'LEFT JOIN {tool_lifecycle_step} s ON s.workflowid = p.workflowid AND s.sortindex = p.stepindex';
        $where = 'm.status = 0 AND w.id = :wid';
        $this->set_sql($fields, $from, $where, array('wid' => $wid));

    }

    public function col_checkbox($row) {
        return \html_writer::checkbox('c[]', $row->id, false);
    }

    public function col_tools($row) {
        global $PAGE, $OUTPUT;
        echo $this->baseurl;
        $button1 = new \single_button(new \moodle_url($this->baseurl, array('action'=>'proceed', 'c[]' => $row->id)), 'Proceed');
        $button2 = new \single_button(new \moodle_url($this->baseurl, array('action'=>'rollback', 'c[]' => $row->id)), 'Rollback');
        return $OUTPUT->render($button1) . $OUTPUT->render($button2);
    }

}