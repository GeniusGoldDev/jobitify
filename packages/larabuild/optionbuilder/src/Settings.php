<?php

namespace Larabuild\Optionbuilder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Settings {

    /** 
     * Storing New & Updating existinsg Settings
     * @param $key of setting
     * @param $value of key
     */
    private function store($section, $key, $value) {

        DB::table(config('optionbuilder.db_prefix') . 'settings')->updateOrInsert(
            [
                'section'   => $section,
                'key'       => $key
            ],
            [
                'section'   => $section,
                'key'       => $key,
                'value'     => $value
            ]
        );
    }

    /**
     * Get The Value of Key Specified
     * @param $key String
     * @return mixed String
     */
    public  function get(string $key = NULL) {

        $settings   = self::getSettings();
        $key        = explode('.', $key);
        $section    = $key[0];
        $key        = !empty($key[1]) ? $key[1] :  '';

        if( empty($key) ) { // return all settings
            $sectionSettings = array();
            if (!empty($settings[$section])) {
                foreach ($settings[$section] as $setting => $value) {
                    $sectionSettings[$setting] = $this->decodeValue($value);
                }
            }
            return $sectionSettings;
        }elseif ( isset($settings[$section][$key]) ) {           //return selected setting
            return $this->decodeValue($settings[$section][$key]);
        }
    }

    private function decodeValue($settingValue) {

        $value = @unserialize($settingValue);
        if ( $value == 'b:0;' || $value !== false ) {
            $temp = [];
            foreach ( $value as $key => $data) {
                if ( is_array($data) ) {
                    $temp[$key] = self::jsonDecodedArr($data);
                }else{
                    if (self::isJSON($data)) {
                        $temp[$key] = json_decode($data, true);
                    } else {
                        $temp[$key] = $data;
                    }
                }
            }
            return $temp;
        }else{
            if (self::isJSON($settingValue)) {
                return (json_decode($settingValue, true));
            } else {
                return $settingValue;
            }
        }
    }

    /**
     * check string is json or not
     * @param $string String
     * @param mixed String $value
     * @return Void
     */
    private function isJSON($string) {

        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    /**
     * get json_decoded array
     * @param $arr Array
     * @param mixed String $value
     * @return Void
     */
    private function jsonDecodedArr(&$arr) {

        foreach ($arr as $key => &$el) {

            if ( is_array($el) ) {
                self::jsonDecodedArr($el);
            } else {
                if ( self::isJSON($el) ) {
                    $el = json_decode($el, true);
                }
            }
        }
        return  $arr;
    }

    /**
     * Set The Value of Key Specified
     * @param $key String
     * @param mixed String $value
     * @return Void
     */
    public  function set(string $section = NULL,  string $key = NULL, array|string $value) {
        if ( is_array($value) ) {
            $value = serialize($value);
        } else {
            $value = $value;
        }
        self::store($section, $key, $value);
        if ( config('cache', true) )
            Cache::forget('optionbuilder__settings');
        return true;
    }

    /**
     * Get settings array
     * @return array
     */
    private function getSettings() {

        if ( config('cache', true) ) {

            return Cache::rememberForever('optionbuilder__settings', function () {
                return $this->fetchSettings();
            });
        } else {
            return $this->fetchSettings();
        }
    }

    /**
     * fetch From DB
     * @return array
     */
    private function fetchSettings() {

        $sections = [];
        $settings =  DB::table(config('optionbuilder.db_prefix') . 'settings')->get();
        if ( !empty($settings) ) {
            foreach ($settings as $single) {
                $sections[$single->section][$single->key] = $single->value;
            }
        }
        return $sections;
    }

    /**
     * reset the section 
     * @param $key String
     * @return Void
     */
    public  function resetSection($key = false) {

        if ( !empty($key) ) {
            DB::table(config('optionbuilder.db_prefix') . 'settings')->whereSection($key)->delete();
        } else {
            DB::table(config('optionbuilder.db_prefix') . 'settings')->truncate();
        }
        if (config('cache', true)) {
            Cache::forget('optionbuilder__settings');
        }
    }

    /**
     * get section fields html
     * @return html
     */
    public function getSectionSetting($params, $fields) {

        $html = '';

        if ( is_array($fields) && !empty($fields) ) {

            $tab_key = !empty($params['tab_key']) ? $params['tab_key'] :  '';
            $html = '<ul class="op-themeform__wrap">';
            foreach ($fields as $field) {

                $field['tab_key']       = $tab_key;
                if ( empty($params['repeater_id']) ) {
                    $id = !empty($field['id']) ? $field['id'] : '';
                    $db_value = self::get($tab_key . '.' . $id);
                    $field['db_value']   = $db_value;
                    if ( !empty($db_value) ) {
                        $field['value']   = $db_value;
                    }
                }else{
                    $field['repeater_id']   = !empty($params['repeater_id']) ? $params['repeater_id'] :  '';
                    $field['index']         = !empty($params['repeater_id']) ? $params['index'] :  '';
                }
                $html .= self::getField($field);
            }
            $html .= '</ul>';
        }
        return $html;
    }

    /**
     * get  field html
     * @return html
     */
    public  function getField( $field ) {

        $html = '';
        if ( !empty($field['type']) ) {

            switch ( $field['type'] ) {

                case 'text':
                case 'password':
                case 'number':
                case 'editor':
                    $html = view('optionbuilder::components.input', $field)->render();
                    break;

                case 'file':
                    $html = view('optionbuilder::components.file', $field)->render();
                    break;

                case 'textarea':
                    $html = view('optionbuilder::components.textarea', $field)->render();
                    break;

                case 'timepicker':
                    $html = view('optionbuilder::components.timepicker', $field)->render();
                    break;

                case 'datepicker':
                    $html = view('optionbuilder::components.datepicker', $field)->render();
                    break;

                case 'colorpicker':
                    $html = view('optionbuilder::components.colorpicker', $field)->render();
                    break;

                case 'info':
                    $html = view('optionbuilder::components.info', $field)->render();
                    break;

                case 'radio':
                    $html = view('optionbuilder::components.radio', $field)->render();
                    break;

                case 'checkbox':
                    $html = view('optionbuilder::components.checkbox', $field)->render();
                    break;

                case 'switch':
                    $html = view('optionbuilder::components.switch', $field)->render();
                    break;

                case 'select':
                    $html = view('optionbuilder::components.select', $field)->render();
                    break;

                case 'range':
                    $html = view('optionbuilder::components.range_slider', $field)->render();
                    break;

                case 'repeater':
                    if( !empty($field['multi']) && $field['multi'] ) {
                        $html = view('optionbuilder::components.multiple-repeater', $field)->render();
                    }else{
                        $html = view('optionbuilder::components.single-repeater', $field)->render();
                    }
                break;
            }
        }
        return $html;
    }
}
