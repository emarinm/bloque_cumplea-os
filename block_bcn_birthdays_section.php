<?php
require_once("classes/columns_horizontal_position.php");

defined('MOODLE_INTERNAL') || die();
class block_bcn_birthdays_section extends block_base
{
    public function init()
    {
        $this->title = get_string('bcn_birthdays_section', 'block_bcn_birthdays_section');
    }

     //Este metodo se ejecuta despues del init y permite poder modificar el titulo una vez que se inicializa.
    public function specialization() {
    }
    
    public function get_content()
    {
        global $DB, $USER, $COURSE, $PAGE, $OUTPUT, $CFG, $arrmonths;       

        if ($this->content !== null) {
            return $this->content;
        }
        $theme = theme_config::load('bcn');

        $PAGE->requires->css("/blocks/bcn_birthdays_section/styles/bcn_birthdays_section.css");        
        $PAGE->requires->css('/blocks/bcn_birthdays_section/styles/slick/slick.css');
        $PAGE->requires->css('/blocks/bcn_birthdays_section/styles/slick/slick-theme.css');
        $PAGE->requires->js_call_amd('block_bcn_birthdays_section/slick');

        $fs = get_file_storage();
        $sort = "itemid, filepath, filename";
        $result = $fs->get_area_files($this->context->id, 'block_bcn_birthdays_section', array('config_background_image'), false,  $sort, false);

        $llaves = array_keys($result);
        if ($llaves != null && count($llaves) > 0) {
            $file = $result[$llaves[0]];
        }

        $urls = new stdClass();
        foreach ($result as $file) {
            if ( $file->get_itemid() == $this->config->background_image) {
                $urls->{$file->get_filearea()} = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename(), false);
            }
        }
        $contenido = [];

        // verify if image is set full by user
        $content_column_1 = file_rewrite_pluginfile_urls($this->config->content_column_1, 'pluginfile.php', $this->context->id, 'block_bcn_birthdays_section', 'column_1', 0);
        $content_column_2 = file_rewrite_pluginfile_urls($this->config->content_column_2, 'pluginfile.php', $this->context->id, 'block_bcn_birthdays_section', 'column_2', 0);

        //GENERAL
        $title_enabled = ($this->config) ? $this->config->title_enabled : 1; 
        $subtitle_enabled = ($this->config) ? $this->config->next_birtdays_title_enabled : 1; 
        $title = ($this->config) ? $this->config->text_title['text'] : get_string('code_title', 'block_bcn_birthdays_section'); 
        $next_birtdays_title = ($this->config) ? $this->config->next_birtdays_title['text'] : get_string('code_title_next_bd', 'block_bcn_birthdays_section');                
                
        $title_hposition = ($this->config) ? $this->config->title_hposition : 'text-left'; 
        $next_birtdays_title_hposition = ($this->config) ? $this->config->next_birtdays_title_hposition : 'text-left';        
        $grouping = ($this->config) ? $this->config->next_birtdays_groupdate : 1; //Grouping by default        
        $block_profile_field_position_id =($this->config) ? $this->config->block_profile_field_position : 0; 
        $title_text_color = ($this->config) ? $this->config->title_text_color : $theme->settings->site_text_color;    
        $block_bg_color = ($this->config->block_bg_color) ? $this->config->block_bg_color : $theme->settings->site_background_color;
        //TODAY BIRTHDAY
        $today_birtdays_date_color = ($this->config) ? $this->config->today_birtdays_date_color : "#FFFFFF";        
        $today_birtdays_carrusel = ($this->config) ? $this->config->today_birtdays_carrusel : 2;             
        $today_birtdays_date_bg_color = ($this->config) ? $this->config->today_birtdays_date_bg_color : $theme->settings->secondary_brandcolor;        
        $today_birtdays_name_color = ($this->config) ? $this->config->today_birtdays_name_color : $theme->settings->site_text_color;    

        //NEXT BIRTHDAY
        $next_birtdays_title_text_color = ($this->config) ? $this->config->next_birtdays_title_text_color : $theme->settings->site_text_color;        
        $next_birtdays_field_id =($this->config) ? $this->config->block_profile_field : 0;         
        $next_birtdays_days = ($this->config) ? $this->config->next_birtdays_height : 5; //By Default 5         
        $next_birtdays_leftline_color = ($this->config) ? $this->config->next_birtdays_leftline_color : $theme->settings->site_text_color;        
        $next_birtdays_date_bg_color = ($this->config) ? $this->config->next_birtdays_date_bg_color : $theme->settings->site_text_color;                
        $next_birtdays_date_text_color = ($this->config) ? $this->config->next_birtdays_date_text_color : "#FFFFFF";        
        //$this->config->next_birtdays_title_hposition
        #464646
        /* filtrando los que no se usan */        
        $icon_1_color = ($this->config) ? $this->config->icon_1_color : $theme->settings->secondary_brandcolor;
        $icon_2_color = ($this->config) ? $this->config->icon_2_color : $theme->settings->secondary_brandcolor;

        //Searching user data, based on configuration
        $today = date("m")*100 + date("d");
        $calendartype = \core_calendar\type_factory::get_calendar_instance();
        $arrmonths = $calendartype->get_months();
        $today_birthdays_json=[]; 
        $next_birthdays_json =[];
        $users =[];
        $mensaje_inicial='';
        $mensaje_inicial_nb='';
        // GET BIRTHDAYs
        if ($next_birtdays_field_id != 0){
            $query_cargo = '';
            $select_cargo = '';
            if ($block_profile_field_position_id != 0){
                $query_cargo = " left join `mdl_user_info_data` uid_cargo on uid_cargo.userid = u.id and uid_cargo.fieldid = $block_profile_field_position_id ";
                $select_cargo = ' , uid_cargo.data as position ';
            }
           
            $users = $DB->get_records_sql(
                "select u.id, CONCAT (u.firstname,' ',u.lastname) as nombre_completo, 
                DAY(FROM_UNIXTIME(uid.data)) as userday, 
                MONTH(FROM_UNIXTIME(uid.data)) as usermonth, 
                MONTH(FROM_UNIXTIME(uid.data))*100 + DAY(FROM_UNIXTIME(uid.data)) as tiempo_us ,
                fechas.fecha_year*10000 + MONTH(FROM_UNIXTIME(uid.data))*100 + DAY(FROM_UNIXTIME(uid.data)) as fecha_user_par
                $select_cargo
                from `mdl_user` u 
                    left join `mdl_user_info_data` uid on uid.userid = u.id and uid.fieldid = $next_birtdays_field_id $query_cargo,                    
                (select gen_date, YEAR(gen_date) as fecha_year, MONTH(gen_date) as fecha_month, DAY(gen_date)  as fecha_day 
                from 
                    (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) gen_date from
                        (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                        (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                        (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                        (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                        (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                where gen_date between CURDATE() and DATE_ADD(CURDATE(), INTERVAL $next_birtdays_days DAY) ) fechas
                where uid.data
                and fechas.fecha_month = MONTH(FROM_UNIXTIME(uid.data))  
                and fechas.fecha_day = DAY(FROM_UNIXTIME(uid.data))
                order by fecha_user_par, u.firstname, u.lastname");

                if ($users == [] ) {
                    $mensaje_inicial = get_string('code_nb_mensage', 'block_bcn_birthdays_section');
                    $mensaje_inicial_nb = get_string('code_today_mensage', 'block_bcn_birthdays_section');
                }                
            }else{
                $mensaje_inicial = get_string('code_notconfigure', 'block_bcn_birthdays_section');
                $mensaje_inicial_nb = get_string('code_notconfigure', 'block_bcn_birthdays_section');
            }           
          
           /* $users = $DB->get_records_sql(
                "select u.id, CONCAT (u.firstname,' ',u.lastname) as nombre_completo, 
                DAY(FROM_UNIXTIME(uid.data)) as userday, 
                MONTH(FROM_UNIXTIME(uid.data)) as usermonth, 
                MONTH(FROM_UNIXTIME(uid.data))*100 + DAY(FROM_UNIXTIME(uid.data)) as tiempo_us ,
                fechas.fecha_year*10000 + MONTH(FROM_UNIXTIME(uid.data))*100 + DAY(FROM_UNIXTIME(uid.data)) as fecha_user_par
                from `mdl_user` u left join `mdl_user_info_data` uid on uid.userid = u.id and uid.fieldid = $next_birtdays_field_id ,
                (select gen_date, YEAR(gen_date) as fecha_year, MONTH(gen_date) as fecha_month, DAY(gen_date)  as fecha_day 
                from 
                    (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) gen_date from
                         (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                         (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                         (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                         (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                         (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                where gen_date between '2022-01-28' and DATE_ADD('2022-01-28', INTERVAL $next_birtdays_days DAY) ) fechas
                where uid.data
                and fechas.fecha_month = MONTH(FROM_UNIXTIME(uid.data))  
                and fechas.fecha_day = DAY(FROM_UNIXTIME(uid.data))
                order by fecha_user_par, u.firstname, u.lastname");    //TESTING */ 
        //var_dump($users);die();
        //$today = 1117; TESTING
        $testsize = 100; //Photo Deflout Size
        // TODAY BIRTHDAY
        $today_birthdays = array_filter($users, function ($u) use ($today) {
            return $u->tiempo_us == $today;
        });
        
        $todays_birthdays= array();
        foreach ($today_birthdays as $clave){
            $user = $DB->get_record('user', array('id' => $clave->id));
            $avataroptions = array('link' => false, 'visibletoscreenreaders' => false);
            $avataroptions['size'] = $testsize;        
            $returnobject= $OUTPUT->user_picture ($user, $avataroptions);

            $position  = $clave->position ? $clave->position : '';

            //echo( $returnobject);            
            $todays_birthdays[] = (object) ['name' => $clave->nombre_completo ,'picture' => $returnobject, 'position' =>  $position ];
            //$next_birthdays_ff[] = (object) ['date' => $clave ,'birthdays' => $valor ];
        }
        if ($today_birthdays != [] && isset($today_birthdays) ){        
            $month_string = $arrmonths[date("m")];        
            $var_name_date = strtoupper(date("d") .' '.get_string('bcn_birthdays_section_article', 'block_bcn_birthdays_section') . ' ' .$month_string);
            //Formatting DATE and Birthday of today's birthday
            //$date_internal->date_text = $var_name_date;
            //$date_internal= array_column($today_birthdays, 'nombre_completo');
             $today_birthdays_json = (object) ['date' => $var_name_date ,'birthdays' => $todays_birthdays  ];
        }else{
           // var_dump('No birthday today');
        }               

        // NEXT BIRTHDAYS FILTERING
        $next_birthdays = array_filter($users, function ($u) use ($today) {
            //var_dump($u->tiempo_us);
            return $u->tiempo_us != $today;
        });
        
        $next_birthdays_ff = array();
                       
        if ($grouping == 0){
            //FORMATING
            foreach ($next_birthdays as $birth){        
                $month_string = $arrmonths[ $birth->usermonth ];        
                $var_name_date = strtoupper($birth->userday .' '.get_string('bcn_birthdays_section_article', 'block_bcn_birthdays_section') . ' ' .$month_string);
                $position  = $birth->position ? $birth->position : '';
                $next_birthdays_ff[] = (object) ['date' => $var_name_date ,'birthdays' => (object) [ 'name' => $birth->nombre_completo , 'position' => $position ] ];                
            }
        }else{
            //first grouping , second formatted
                //FORMATING
                $next_birthdays_formatted = array();   
                $next_birthdays_filtered = array();   

                $next_birthdays_formatted = array_map(function ($u) use ($arrmonths) {
                    $month_string = $arrmonths[ $u->usermonth ];        
                    $var_name_date = strtoupper($u->userday .' '.get_string('bcn_birthdays_section_article', 'block_bcn_birthdays_section') . ' ' .$month_string);
                    $position  = $u->position ? $u->position : '';
                    return [$var_name_date,$u->nombre_completo,$position];
                }, $next_birthdays);
                //GROUPPING            
                foreach ($next_birthdays_formatted as $element) {
                    $next_birthdays_filtered[$element[0]][] = (object) [ 'name' => $element[1] , 'position' => $element[2] ];
                }  
                //FORMATING       
                foreach ($next_birthdays_filtered as $clave => $valor){
                    $next_birthdays_ff[] = (object) ['date' => $clave ,'birthdays' => $valor ];
                }
        }
        
        $next_birthdays_json = $next_birthdays_ff;
        
        $carrusel_1 = false; // carrusel manual
        $carrusel_2 = false; // carrusel automatico
        $carrusel_3 = false; // manual
        $carrusel_4 = false; // Elemento Degradado Automático

        //handled carrusel type
        switch ($today_birtdays_carrusel) {
            case 1:
                $carrusel_1 = true; 
                break;
            case 2:
                $carrusel_2 = true; 
                break;
            case 3:
                $carrusel_3 = true; 
                break;
            case 4:
                $carrusel_4 = true; 
                break;
        }


        $contenido = [
            'idbloque' => $this->instance->id,
            'identificador' => $this->config->identificador,
            'blockheight' => $this->config->block_height,
            'title_enabled' => $title_enabled,
            'subtitle_enabled' => $subtitle_enabled,
            'title' => $title,
            'title_text_color' => $title_text_color,
            'title_hposition' =>   $title_hposition,            
            'customization_enabled' => $this->config->customization_enabled,
            'columns_columns_stylesheet' => $this->config->columns_columns_stylesheet,
            'content_column_1' => $content_column_1,
            'content_column_2' => $content_column_2,            
            'icon_1_color' => $icon_1_color,
            'icon_2_color' => $icon_2_color,
            'next_birtdays_title_text_color' => $next_birtdays_title_text_color,
            'next_birtdays_title' => $next_birtdays_title,
            'today_birthdays_json' => $today_birthdays_json,
            'next_birthdays_json' => $next_birthdays_json,
            'next_birtdays_date_bg_color' => $next_birtdays_date_bg_color,
            'next_birtdays_leftline_color' => $next_birtdays_leftline_color,
            'next_birtdays_date_text_color' => $next_birtdays_date_text_color,
            'block_bg_color' => $block_bg_color,
            'today_birtdays_date_color' => $today_birtdays_date_color,            
            'today_birtdays_date_bg_color' => $today_birtdays_date_bg_color,
            'carrusel_1' => $carrusel_1,
            'carrusel_2' => $carrusel_2,
            'carrusel_3' => $carrusel_3,
            'carrusel_4' => $carrusel_4,
            'today_birtdays_name_color' => $today_birtdays_name_color,            
            'background_image' => isset($urls->config_background_image) ? $urls->config_background_image : null,
            'imageone' => $OUTPUT->image_url('feliz_dia_'.$CFG->lang, 'block_bcn_birthdays_section'),
            'next_birtdays_title_hposition' =>   $next_birtdays_title_hposition,            
            'mensaje_inicial' =>   $mensaje_inicial,            
            'mensaje_inicial_nb' =>   $mensaje_inicial_nb,            
        ];                       

        $this->content =  new stdClass;
        $this->content->text = $OUTPUT->render_from_template('block_bcn_birthdays_section/col2', $contenido);        
        
        return $this->content;
    }
    
    public function formattedjson($v, $k)
    {
        $internal->date = $k;
        $internal->birtdays = $v;
        // key is now $k
        return $internal;
    }
    public function hide_header()
    {
        return true;
    }

    function instance_allow_config()
    {
        return true;
    }

    public function instance_allow_multiple()
    {
        return true;
    }

    public function hide_footer()
    {
        return true;
    }
}
