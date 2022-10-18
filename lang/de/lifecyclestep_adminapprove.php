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

$string['pluginname'] = 'Adminbestätigungs-Schritt';
$string['privacy:metadata'] = 'Dieses Subplugin speichert keine persönlichen Daten.';
$string['emailsubject'] = 'Kurs-Lebenszyklus: Es gibt neue Kurse, die auf Bestätigung warten.';
$string['emailcontent'] = 'Es gibt {$a->amount} neue Kurse, die auf Bestätigung warten. Bitte besuchen Sie {$a->url}.';
$string['emailcontenthtml'] = 'Es gibt {$a->amount} neue Kurse, die auf Bestätigung warten. Bitte klicken Sie auf <a href="{$a->url}">diesen Link</a>.';
$string['courseid'] = 'Kurs-ID';
$string['workflow'] = 'Workflow';
$string['proceedselected'] = 'Ausgewählte fortführen';
$string['rollbackselected'] = 'Ausgewählte zurücksetzten';
$string['tools'] = 'Aktionen';
$string['courses_waiting'] = 'Diese Kurse warten derzeit auf Bestätigung im "{$a->step}"-Schritt in dem "{$a->workflow}"-Workflow.';
$string['no_courses_waiting'] = 'Es gibt derzeit keine Kurse, die im "{$a->step}"-Schritt in dem "{$a->workflow}"-Workflow auf Bestätigung warten.';
$string['proceed'] = 'Fortführen';
$string['rollback'] = 'Zurücksetzten';
$string['amount_courses'] = 'Anzahl wartender Kurse';
$string['only_number'] = 'Es sind nur Ziffern erlaubt!';
$string['nothingtodisplay'] = 'Es gibt keine auf Bestätigung wartenden Kurse, die auf diese Filter passen.';
$string['manage-adminapprove'] = 'Adminbestätigungs-Schritte verwalten';
$string['nostepstodisplay'] = 'Es gibt derzeit keine Kurse in Adminbestätigungs-Schritten, die auf Bestätigung warten.';
$string['bulkactions'] = 'Massenaktionen';
$string['proceedall'] = 'Alle fortführen';
$string['rollbackall'] = 'Alle zurücksetzten';
$string['statusmessage'] = 'Statusnachricht';
$string['statusmessage_help'] = 'Statusnachricht, welche dem Lehrer angezeigt wird, wenn ein Prozess eines Kurses den Adminbestätigungs-Schritt bearbeitet.';
