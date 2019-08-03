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

    private $courseid;

    private $coursename;

    public function __construct($stepid, $courseid, $coursename) {
        parent::__construct('lifecyclestep_adminapprove-decisiontable');
        $this->courseid = $courseid;
        $this->coursename = $coursename;
        $this->define_baseurl("/admin/tool/lifecycle/step/adminapprove/approvestep.php?stepid=$stepid");
        $this->define_columns(['checkbox', 'courseid', 'course', 'tools']);
        $this->define_headers(
                array(\html_writer::checkbox('checkall', null, false), get_string('courseid', 'lifecyclestep_adminapprove'),
                        get_string('course'),
                        get_string('tools', 'lifecyclestep_adminapprove')));
        $this->column_nosort = array('checkbox', 'tools');
        $fields = 'm.id, w.displaytitle as workflow, c.id as courseid, c.fullname as course, m.status';
        $from = '{lifecyclestep_adminapprove} m ' .
                'LEFT JOIN {tool_lifecycle_process} p ON p.id = m.processid ' .
                'LEFT JOIN {course} c ON c.id = p.courseid ' .
                'LEFT JOIN {tool_lifecycle_workflow} w ON w.id = p.workflowid ' .
                'LEFT JOIN {tool_lifecycle_step} s ON s.workflowid = p.workflowid AND s.sortindex = p.stepindex';
        $where = 'm.status = 0 AND s.id = :sid ';
        $params = array('sid' => $stepid);
        if ($courseid) {
            $where .= 'AND c.id = :cid ';
            $params['cid'] = $courseid;
        }
        if ($coursename) {
            $where .= "AND c.fullname LIKE :cname ";
            $params['cname'] = '%' . trim($coursename) . '%';
        }
        $this->set_sql($fields, $from, $where, $params);

    }

    public function col_checkbox($row) {
        return \html_writer::checkbox('c[]', $row->id, false);
    }

    public function col_tools($row) {
        $output = \html_writer::start_div('singlebutton');
        $output .= \html_writer::tag('div', get_string('proceed', 'lifecyclestep_adminapprove'),
                array('class' => 'btn btn-secondary adminapprove-action', 'data-action' => 'proceed', 'data-content' => $row->id));
        $output .= \html_writer::end_div();
        $output .= \html_writer::start_div('singlebutton');
        $output .= \html_writer::tag('div', get_string('rollback', 'lifecyclestep_adminapprove'),
                array('class' => 'btn btn-secondary adminapprove-action', 'data-action' => 'rollback', 'data-content' => $row->id));
        $output .= \html_writer::end_div();
        return $output;
    }

    public function print_nothing_to_display() {
        global $OUTPUT;

        // Render button to allow user to reset table preferences.
        echo $this->render_reset_button();

        $this->print_initials_bar();

        echo get_string('nothingtodisplay', 'lifecyclestep_adminapprove');
    }

}