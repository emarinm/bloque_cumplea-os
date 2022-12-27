<?php
require_once("classes/colorpicker.php");
require_once("classes/columns_horizontal_position.php");

class block_bcn_birthdays_section_edit_form extends block_edit_form
{
    private $options;
    private $theme;

    function __construct($actionurl, $block, $page)
    {
        global $CFG;
        $this->options = array('subdirs' => 1, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => EDITOR_UNLIMITED_FILES, 'changeformat' => 1, 'context' => $this->block->context, 'trusttext' => false, 'noclean' => true, 'autosave' => false);
        $this->theme = theme_config::load('bcn');
        parent::__construct($actionurl, $block, $page);
        
    }

    protected function specific_definition($mform)
    {

        $this->get_config_general($mform);
        $this->get_config_titles($mform);
        //$this->get_config_content($mform);
        $this->get_config_today_birtdays($mform);
        $this->get_config_next_birtdays($mform);
        
    }

    private function get_config_general($mform)
    {
        GLOBAL $DB;
        

        $profile_fields = $DB->get_records('user_info_field');
        $profile_fields_options = array();
        $profile_fields_options_text = array();
        $profile_fields_options[0] = 'Seleccione';
        $profile_fields_options_text[0] = 'Seleccione';
        foreach ($profile_fields as $pro_field) {

            if ( $pro_field->datatype == 'datetime' ){
                $profile_fields_options[$pro_field->id] = $pro_field->name;
            }elseif ( $pro_field->datatype == 'text') {            
                $profile_fields_options_text[$pro_field->id] = $pro_field->name;
            }
           
        }

        // Section header
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
        // Identify the block
        $mform->addElement('text', 'config_identificador', get_string('identificador', 'block_bcn_birthdays_section'), array("size" => 60));
        $mform->setType('config_identificador', PARAM_TEXT);
        $mform->setDefault('config_identificador', $this->block->instance->id);
        // height size of the block
        $mform->addElement('sizeselector', 'config_block_height', get_string('blockheight', 'block_bcn_birthdays_section'), array("size" => 60));
        $mform->setDefault('config_block_height', '100%');
        $mform->setType('config_block_height', PARAM_RAW);
        //user field to get the birthday date
        $mform->addElement('select', 'config_block_profile_field', get_string('config_block_profile_field', 'block_bcn_birthdays_section'), $profile_fields_options, array('multiple' => false));
        //left line color
        $mform->addElement('select', 'config_block_profile_field_position', get_string('config_block_profile_field_position', 'block_bcn_birthdays_section'), $profile_fields_options_text, array('multiple' => false));
        //left line color
        $title_color = $mform->addElement('text', 'config_block_bg_color', get_string('config_block_bg_color', 'block_bcn_birthdays_section'), array('size' => 40));
        $title_color->setType('color');
        $mform->setDefault('config_block_bg_color', '#ffffff');

        // background image
        $mform->addElement('filemanager', 'config_background_image', get_string('backgroundimage', 'block_bcn_birthdays_section'));
        $mform->setType('config_background_image', PARAM_RAW);
        // button to delete the background image
        $mform->addElement('submit', 'btn_background_image_delete', 'Borrar imágen', array('onclick' => "$(`input[name='background_image_delete']`).val(1)"));
        $mform->setType('btn_background_image_delete', PARAM_RAW);
        // value to delete the background image
        $mform->addElement('hidden', 'background_image_delete');
        $mform->setType('background_image_delete', PARAM_RAW);
    }

    private function get_config_titles($mform)
    {
        // Section texts
        $mform->addElement('header', 'config_header', 'Ajustes del titulo');

        //Habilitar titulo
        $mform->addElement('advcheckbox', 'config_title_enabled', get_string('title_enabled', 'block_bcn_birthdays_section'));
        $mform->setDefault('config_title_enabled', 1);

        $title_color = $mform->addElement('text', 'config_title_text_color', get_string('title_text_color', 'block_bcn_birthdays_section'), array('size' => 40));
        $title_color->setType('color');
        $mform->setDefault('config_title_text_color', $this->theme->settings->site_text_color);

        // Title text
        $mform->addElement('editor', 'config_text_title', get_string('title', 'block_bcn_birthdays_section'), array("size" => 60));
        $mform->setType('config_text_title', PARAM_RAW);       
        $mform->setDefault('config_text_title',  array('text' => get_string('code_title', 'block_bcn_birthdays_section'), 'format' => FORMAT_HTML));

        //Posición del titulo
        $select = $mform->addElement('select', 'config_title_hposition',  get_string('title_hposition', 'block_bcn_birthdays_section'), ContentTutorialColumnsHorizontalPositionBlocks::get_array_values());
        $mform->setDefault('config_title_hposition', 'Izquierda');
        $select->setMultiple(false);
        
        //Ocultar config titulo
        $mform->hideIf('config_text_title', 'config_title_enabled', 'notchecked');
        $mform->hideIf('config_title_position', 'config_title_enabled', 'notchecked');
        $mform->hideIf('config_title_text_color', 'config_title_enabled', 'notchecked');      
    }

    private function get_config_today_birtdays($mform) {
        $opction_carrusel = array (0=> 'Selecciones' , 1 =>'Carrusel manual', 2 => 'Carrusel automático', 3=> 'Formato plano', 4 => 'Elemento Degradado Automático');

        // Section texts
        $mform->addElement('header', 'config_header', get_string('header_todays_birtdays', 'block_bcn_birthdays_section'));

        // Color name todays birthday
        $title_color = $mform->addElement('text', 'config_today_birtdays_name_color', get_string('config_today_birtdays_name_color', 'block_bcn_birthdays_section'), array('size' => 40));
        $title_color->setType('color');
        $mform->setDefault('config_today_birtdays_name_color', $this->theme->settings->site_text_color);
          
        // Color div date todays birthday
        $title_color = $mform->addElement('text', 'config_today_birtdays_date_color', get_string('config_today_birtdays_date_color', 'block_bcn_birthdays_section'), array('size' => 40));
        $title_color->setType('color');
        $mform->setDefault('config_today_birtdays_date_color', "#FFFFFF");
       
        // Color div date todays birthday
        $title_color = $mform->addElement('text', 'config_today_birtdays_date_bg_color', get_string('config_today_birtdays_date_bg_color', 'block_bcn_birthdays_section'), array('size' => 40));
        $title_color->setType('color');
        $mform->setDefault('config_today_birtdays_date_bg_color', $this->theme->settings->secondary_brandcolor);

        //carrusel type
        $select = $mform->addElement('select', 'config_today_birtdays_carrusel',  get_string('config_today_birtdays_carrusel', 'block_bcn_birthdays_section'), $opction_carrusel);
        $mform->setDefault('config_today_birtdays_carrusel', 1);
        $select->setMultiple(false);
    }

    private function get_config_next_birtdays($mform) {
        // Section texts
        $mform->addElement('header', 'config_header', get_string('header_next_birtdays', 'block_bcn_birthdays_section'));
        //Habilitar titulo
        $mform->addElement('advcheckbox', 'config_next_birtdays_title_enabled', get_string('title_enabled', 'block_bcn_birthdays_section'));
        $mform->setDefault('config_next_birtdays_title_enabled', 1);
        
         // Color Title for Next Birtday
        $title_color = $mform->addElement('text', 'config_next_birtdays_title_text_color', get_string('title_text_color', 'block_bcn_birthdays_section'), array('size' => 40));
        $title_color->setType('color');
        $mform->setDefault('config_next_birtdays_title_text_color', $this->theme->settings->site_text_color);

        // Title for Next Birtday
        $mform->addElement('editor', 'config_next_birtdays_title', get_string('title', 'block_bcn_birthdays_section'), array("size" => 60));
        $mform->setType('config_next_birtdays_title', PARAM_RAW);
        // set empty text in html        
        $mform->setDefault('config_next_birtdays_title', array('text' => get_string('code_title_next_bd', 'block_bcn_birthdays_section'), 'format' => FORMAT_HTML));

        //Posición del titulo
        $select = $mform->addElement('select', 'config_next_birtdays_title_hposition',  get_string('title_hposition', 'block_bcn_birthdays_section'), ContentTutorialColumnsHorizontalPositionBlocks::get_array_values());
        $mform->setDefault('config_next_birtdays_title_hposition', 'Izquierda');
        $select->setMultiple(false);
        //color background date
        $title_color = $mform->addElement('text', 'config_next_birtdays_date_bg_color', get_string('config_next_birtdays_bg_date', 'block_bcn_birthdays_section'), array('size' => 40));
        $title_color->setType('color');
        $mform->setDefault('config_next_birtdays_date_bg_color', $this->theme->settings->site_text_color);

        //color date text
        $title_color = $mform->addElement('text', 'config_next_birtdays_date_text_color', get_string('config_next_birtdays_date_text_color', 'block_bcn_birthdays_section'), array('size' => 40));
        $title_color->setType('color');
        $mform->setDefault('config_next_birtdays_date_text_color', "#FFFFFF");
        
        //left line color
        $title_color = $mform->addElement('text', 'config_next_birtdays_leftline_color', get_string('config_next_birtdays_leftline_color', 'block_bcn_birthdays_section'), array('size' => 40));
        $title_color->setType('color');
        $mform->setDefault('config_next_birtdays_leftline_color', $this->theme->settings->site_text_color);

        // height size of the block
        $mform->addElement('text', 'config_next_birtdays_height', get_string('config_next_birtdays_height', 'block_bcn_birthdays_section'), array("size" => 10));
        $mform->setDefault('config_next_birtdays_height', '5');
        $mform->setType('config_next_birtdays_height', PARAM_RAW);
        $mform->addRule('config_next_birtdays_height', get_string('is_numeric', 'block_bcn_birthdays_section'), 'numeric', null, 'client');

        $mform->addElement('selectyesno', 'config_next_birtdays_groupdate', get_string('config_next_birtdays_groupdate', 'block_bcn_birthdays_section'));
        $mform->setType('config_next_birtdays_groupdate', PARAM_RAW);
        $mform->setDefault('config_next_birtdays_groupdate', array('text' => 1));

    }
    /**
     * Load in existing data as form defaults. Usually new entry defaults are stored directly in
     * form definition (new entry form); this function is used to load in data where values
     * already exist and data is being edited (edit entry form).
     *
     * @param mixed $default_values object or array of default values
     */

    function set_data($defaults)
    {        
        $backgroundimage = 'config_background_image';        
        $draftitemidbackgroundimage = file_get_submitted_draft_itemid($backgroundimage);        
        $defaults->{$backgroundimage} = $defaults->config->background_image ?? null;
        
        parent::set_data($defaults);
        
        if ($data = parent::get_data()) {            
            $borrar_bg_image = $data->background_image_delete == 1;

            if ($borrar_bg_image) {
                $this->delete_image($data->config_background_image, $backgroundimage);
            }            
            $draft_exist_draftitemidbackgroundimage = file_get_all_files_in_draftarea($draftitemidbackgroundimage);

            if (!$borrar_bg_image) {
                if (count($draft_exist_draftitemidbackgroundimage) > 0) {
                    file_save_draft_area_files($draftitemidbackgroundimage, $this->block->context->id, 'block_bcn_birthdays_section', $backgroundimage, $data->config_background_image, array('subdirs' => false, 'maxbytes' => 5000000, 'maxfiles' => 1, 'accepted_types' => array('.jpg', '.bmp', '.png', '.gif', '.webp')));
                }
            }
        }

        if (is_object($defaults)) {
            $defaults = (array)$defaults;
        }
        $this->data_preprocessing($defaults);

        parent::set_data(is_array($defaults) ? (object)$defaults : $defaults);
    }
    
    function delete_image($itemid, $filearea)
    {

        $fs = get_file_storage();
        $sort = "itemid, filepath, filename";
        $result = $fs->get_area_files($this->block->context->id, 'block_bcn_birthdays_section', array('config_image', 'config_background_image'), false,  $sort, false);
        foreach ($result as $file) {
            if ($file->get_itemid() === $itemid || $file->get_filearea() === $filearea) {
                try {
                    $file->delete();
                } catch (\Throwable $th) {
                }
            }
        }
    }
    /**
     * Enforce defaults here.
     *
     * @param array $defaultvalues Form defaults
     * @return void
     **/
    public function data_preprocessing(&$defaultvalues)
    {
        $configdata = (array)unserialize(base64_decode($defaultvalues['configdata']));
        $configdata = file_prepare_standard_editor((object)$configdata, 'config_content_column_1', $this->options, $this->block->context, 'block_bcn_birthdays_section', 'column_1', 0);
        $configdata = file_prepare_standard_editor((object)$configdata, 'config_content_column_2', $this->options, $this->block->context, 'block_bcn_birthdays_section', 'column_2', 0);
        $defaultvalues['configdata'] = base64_encode(serialize($configdata));
    }


    public function get_data()
    {
        if ($data = parent::get_data()) {
            $data = file_postupdate_standard_editor($data, 'config_content_column_1', $this->options, $this->block->context, 'block_bcn_birthdays_section', 'column_1', 0);
            $data = file_postupdate_standard_editor($data, 'config_content_column_2', $this->options, $this->block->context, 'block_bcn_birthdays_section', 'column_2', 0);
        }
        return $data;
    }
}
