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
 * @package   theme_bcn
 * @copyright 2022 Alejandro Burgos (aburgos@bcnschool.cl)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use MyCLabs\Enum\Enum;

final class ContentColumnsPositionBlocks extends Enum
{
    private const Izquierda = 'justify-content-start';
    private const Centro = 'justify-content-center'; 
    private const Derecha = 'justify-content-end';
    private const Between = 'justify-content-between';
    private const Around = 'justify-content-around';
    private const Evenly = 'justify-content-evenly';

    public function get_value()
    {
        return $this->getValue();
    }

    public static function get_array_values()
    {
        return array_flip(ContentColumnsPositionBlocks::toArray());
    }

    public static function get_position_by_id($id)
    {
        foreach (ContentColumnsPositionBlocks::toArray() as $value) {
            if ($id === $value) {
                return new ContentColumnsPositionBlocks($value);
            }
        }
    }
}
