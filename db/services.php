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
 * External services.
 *
 * @package    block_bcn_birthdays_section
 * @copyright  2022 Luis Mora
 * @author     Luis Mora <lmora@bcnschool.cl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'block_bcn_birthdays_section_get_config' => [
        'classname' => 'block_bcn_birthdays_section\external',
        'methodname' => 'bcn_birthdays_section_get_config',
        'classpath' => 'blocks/bcn_birthdays_section/classes/external/external.php',
        'description' => 'Get Birthday Section Block Settings',
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE),
        'type' => 'write',
        'ajax' => true
    ]  
];
