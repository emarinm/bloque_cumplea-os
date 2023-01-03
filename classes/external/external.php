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

namespace block_bcn_birthdays_section;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');

use block_bcn_birthdays_section\util\certificates;

use external_api;
use external_function_parameters;
use external_value;
use external_multiple_structure;
use external_single_structure;
use stdClass;
use moodle_url;
use html_writer;
use context_system;


/**
 * External class.
 *
 * @package    block_bcn_birthdays_section
 * @copyright  2022 Luis Mora
 * @author     Luis Mora <lmora@bcnschool.cl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external extends external_api
{


    /**
     * External function parameters.
     *
     * @return external_function_parameters
     */


    public static function bcn_birthdays_section_get_config_parameters()
    {
        return new external_function_parameters(
            array(
                'contextid' => new external_value(PARAM_INT, 'context id')
            )
        );
    }

    /**
     * upload file to filearea
     *
     * @param array $params
     * @return stored_file
     */ 
    public static function bcn_birthdays_section_get_config($contextid)
    {
        global $USER, $DB, $CFG;
               
        $tovalidate = array(
            'contextid' => $contextid
        );
        require_once($CFG->dirroot . '/blocks/edit_form.php');
        
        $params = self::validate_parameters(self::bcn_birthdays_section_get_config_parameters(), $tovalidate);

        //$block = $this->find_instance($contextid);
        //$blockcontext = context_block::instance($contextid);
        
        //Get the instance by id
        $instance = $DB->get_record('block_instances', array('id' => $contextid));
        $blockname = 'bcn_birthdays_section';
        $block = block_instance($blockname, $instance);
        //var_dump($block);
        $page = $block->page;
        $editpage = new \moodle_page();
        $editpage->set_pagelayout('admin');
        $editpage->blocks->show_only_fake_blocks(false);
        //$editpage->set_course($this->page->course);
        $editpage->set_context($block->context);
        //var_dump($block->context);
        //var_dump($editpage);
        //die();
        //$editurlbase = str_replace($CFG->wwwroot . '/', '/', $this->page->url->out_omit_querystring());
        $editurlparams = $page->url->params();
        $editurlparams['bui_editid'] = $block->id;
        $editpage->set_url($editurlbase, $editurlparams);
        $editpage->set_block_actions_done();


        $formfile = $CFG->dirroot . '/blocks/' . $block->name() . '/edit_form.php';
        //$formfile =  'C:/xampp/htdocs/moodle/blocks/bcn_birthdays_section/edit_form.php';
        //var_dump($formfile);
        //var_dump($block->name());

        if (is_readable($formfile)) {            
            require_once($formfile);      
            $classname = 'block_' . $block->name() . '_edit_form';
            if (!class_exists($classname)) {                
                $classname = 'block_edit_form';
            }
        } else {
            var_dump('aqui2');
            $classname = 'block_edit_form';
        }
        

        $mform = new $classname($editpage->url, $block, $page);        
        //$mform->set_data($block->instance);

        $retunr_record = $mform->block->page;        
        var_dump($retunr_record);        
        //$rendered = $mform->render();
        //$values = $mform->exportValues();
        
        //$display = $mform->display();        
        //var_dump($display);
        
        die();
        $retunr_record = $rendered;
        
        //print_r($file_record);
        //return json_encode($retunr_record); //$fs->create_file_from_string($file_record, base64_decode($params['filecontent'])));
        return $retunr_record; 
    }

    /**
     * External function return values.
     *
     * @return external_value
     */
    public static function bcn_birthdays_section_get_config_returns()
    {
        return new external_value(PARAM_RAW, 'stored_file');
    }




    
}
