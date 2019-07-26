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
 * Life Cycle Admin Approve Step AMD Module
 *
 * @package tool_lifecycle_step
 * @subpackage adminapprove
 * @copyright  2019 Justus Dieckmann WWU
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * @module lifecyclestep_adminapprove/init
 */
define(['jquery'], function($) {
    return {
        init: function() {
            $('input[name="checkall"]').click(function() {
                $('input[name="c"]').prop('checked', $('input[name="checkall"]').prop('checked'));
            });

            $('#adminapprove-bulk-proceed').click(function() {
                $('#act').get(0).value = 'proceed';
                $('#adminapprove-action-form').submit();
            });

            $('#adminapprove-bulk-rollback').click(function() {
                $('#act').get(0).value = 'rollback';
                $('#adminapprove-action-form').submit();
            });
        }
    };
});