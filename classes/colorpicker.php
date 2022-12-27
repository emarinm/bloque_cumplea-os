<?php
require_once($CFG->libdir . "/adminlib.php");

/**
 * Colour picker
 *
 * @copyright 2010 Sam Hemelryk
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_bcn_birthdays_section_setting_configcolourpicker extends admin_setting {

    /**
     * Information for previewing the colour
     *
     * @var array|null
     */
    protected $previewconfig = null;

    /**
     * Use default when empty.
     */
    protected $usedefaultwhenempty = true;

    /**
     *
     * @param string $name
     * @param string $visiblename
     * @param string $description
     * @param string $defaultsetting
     * @param array $previewconfig Array('selector'=>'.some .css .selector','style'=>'backgroundColor');
     */
    public function __construct($name, $visiblename, $description, $defaultsetting, array $previewconfig = null,
            $usedefaultwhenempty = true) {
        $this->previewconfig = $previewconfig;
        $this->usedefaultwhenempty = $usedefaultwhenempty;
        parent::__construct($name, $visiblename, $description, $defaultsetting);
        $this->set_force_ltr(true);
    }

    /**
     * Return the setting
     *
     * @return mixed returns config if successful else null
     */
    public function get_setting() {
        return $this->config_read($this->name);
    }

    /**
     * Saves the setting
     *
     * @param string $data
     * @return bool
     */
    public function write_setting($data) {
        $data = $this->validate($data);
        if ($data === false) {
            return  get_string('validateerror', 'admin');
        }
        return ($this->config_write($this->name, $data) ? '' : get_string('errorsetting', 'admin'));
    }

    /**
     * Validates the colour that was entered by the user
     *
     * @param string $data
     * @return string|false
     */
    protected function validate($data) {
        /**
         * List of valid HTML colour names
         *
         * @var array
         */
         $colornames = array(
            'aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure',
            'beige', 'bisque', 'black', 'blanchedalmond', 'blue',
            'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse',
            'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson',
            'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray',
            'darkgrey', 'darkgreen', 'darkkhaki', 'darkmagenta',
            'darkolivegreen', 'darkorange', 'darkorchid', 'darkred',
            'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray',
            'darkslategrey', 'darkturquoise', 'darkviolet', 'deeppink',
            'deepskyblue', 'dimgray', 'dimgrey', 'dodgerblue', 'firebrick',
            'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro',
            'ghostwhite', 'gold', 'goldenrod', 'gray', 'grey', 'green',
            'greenyellow', 'honeydew', 'hotpink', 'indianred', 'indigo',
            'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen',
            'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan',
            'lightgoldenrodyellow', 'lightgray', 'lightgrey', 'lightgreen',
            'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue',
            'lightslategray', 'lightslategrey', 'lightsteelblue', 'lightyellow',
            'lime', 'limegreen', 'linen', 'magenta', 'maroon',
            'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple',
            'mediumseagreen', 'mediumslateblue', 'mediumspringgreen',
            'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream',
            'mistyrose', 'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive',
            'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod',
            'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip',
            'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple', 'red',
            'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown',
            'seagreen', 'seashell', 'sienna', 'silver', 'skyblue', 'slateblue',
            'slategray', 'slategrey', 'snow', 'springgreen', 'steelblue', 'tan',
            'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'white',
            'whitesmoke', 'yellow', 'yellowgreen'
        );

        if (preg_match('/^#?([[:xdigit:]]{3}){1,2}$/', $data)) {
            if (strpos($data, '#')!==0) {
                $data = '#'.$data;
            }
            return $data;
        } else if (in_array(strtolower($data), $colornames)) {
            return $data;
        } else if (preg_match('/rgb\(\d{0,3}%?\, ?\d{0,3}%?, ?\d{0,3}%?\)/i', $data)) {
            return $data;
        } else if (preg_match('/rgba\(\d{0,3}%?\, ?\d{0,3}%?, ?\d{0,3}%?\, ?\d(\.\d)?\)/i', $data)) {
            return $data;
        } else if (preg_match('/hsl\(\d{0,3}\, ?\d{0,3}%, ?\d{0,3}%\)/i', $data)) {
            return $data;
        } else if (preg_match('/hsla\(\d{0,3}\, ?\d{0,3}%,\d{0,3}%\, ?\d(\.\d)?\)/i', $data)) {
            return $data;
        } else if (($data == 'transparent') || ($data == 'currentColor') || ($data == 'inherit')) {
            return $data;
        } else if (empty($data)) {
            if ($this->usedefaultwhenempty){
                return $this->defaultsetting;
            } else {
                return '';
            }
        } else {
            return false;
        }
    }

    /**
     * Generates the HTML for the setting
     *
     * @global moodle_page $PAGE
     * @global core_renderer $OUTPUT
     * @param string $data
     * @param string $query
     */
    public function output_html($data, $query = '') {
        global $PAGE, $OUTPUT;

        $icon = new pix_icon('i/loading', get_string('loading', 'admin'), 'moodle', ['class' => 'loadingicon']);
        $context = (object) [
            'id' => $this->get_id(),
            'name' => $this->get_full_name(),
            'value' => $data,
            'icon' => $icon->export_for_template($OUTPUT),
            'haspreviewconfig' => !empty($this->previewconfig),
            'forceltr' => $this->get_force_ltr(),
            'readonly' => $this->is_readonly(),
        ];

        $element = $OUTPUT->render_from_template('block_bcn_birthdays_section/setting_configcolorpicker', $context);
        $PAGE->requires->js_init_call('M.util.init_colour_picker', array($this->get_id(), $this->previewconfig));

        return format_admin_setting($this, $this->visiblename, $element, $this->description, true, '',
            $this->get_defaultsetting(), $query);
    }


     /**
     * Returns the fullname prefixed by the plugin
     * @return string
     */
    public function get_full_name() {
        return $this->name;
    }

    /**
     * Returns the ID string based on plugin and name
     * @return string
     */
    public function get_id() {
        return $this->name;
    }

}