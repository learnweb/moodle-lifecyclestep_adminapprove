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
 * Lang Strings for Admin Approve Step
 *
 * @package tool_lifecycle_step
 * @subpackage adminapprove
 * @copyright  2019 Justus Dieckmann WWU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Admin Approve Step';
$string['emailsubject'] = 'Lifecycle: There are new courses waiting for confirmation.';
$string['emailcontent'] = 'There are {$a->amount} new courses waiting for confirmation. Please visit {$a->url}.';
$string['emailcontenthtml'] = 'There are {$a->amount} new courses waiting for confirmation. Please visit <a href="{$a->url}">this link</a>.';
$string['courseid'] = 'Course id';
$string['markedas'] = 'Marked as';
$string['workflow'] = 'Workflow';
$string['proceedselected'] = 'Proceed selected';
$string['rollbackselected'] = 'Rollback selected';
$string['tools'] = 'Tools';
$string['courses_waiting'] = 'These courses are currently waiting for approval in the "{$a->step}" Step in the "{$a->workflow}" Workflow.';
$string['no_courses_waiting'] = 'There are currently no courses waiting for approval in the "{$a->step}" Step in the "{$a->workflow}" Workflow.';