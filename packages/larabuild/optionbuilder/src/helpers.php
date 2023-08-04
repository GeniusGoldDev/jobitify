<?php
use Larabuild\Optionbuilder\Facades\Settings;

/**
 * Helper function to sanitize a string value from user input
 *
 * @param string    $string          String to sanitize.
 * @param bool      $keep_linebreak  Not compulsory Whether to keep newlines or not. Default: false.
 * @return string   Sanitized string.
 */

if( !function_exists('sanitizeTextField') ) {
    function sanitizeTextField( $string, $keep_linebreak = false ) {
        if ( is_object( $string ) || is_array( $string ) ) {
            return '';
        }
        $filtered = stripAllTags($string, $keep_linebreak);
        return clean($filtered, ['Attr.EnableID' => true ]);
    }
}

/**
* @param string $string        String containing HTML tags
* @param bool   $remove_breaks Optional. Whether to remove left over line breaks and white space chars
* @return string The processed string.
*/
if( !function_exists('stripAllTags') ) {

   function stripAllTags( $string, $remove_breaks_tag = false ) {

       $string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
       $string = strip_tags( $string, '<h1><h2><h3><h4><h5><6><div><b><strong><i><em><a><ul><ol><li><p><br><span><figure><sup><sub><table><tr><th><td><tbody><iframe><form><capture><label><fieldset><section>' );

       if ( $remove_breaks_tag ) {
           $string = preg_replace( '/[\r\n\t ]+/', ' ', $string );
       }
       return trim( $string );
   }
}

/**
* @return array The processed array.
*/
if( !function_exists('sanitizeArray') ) {

    function sanitizeArray( &$arr ){
        
        foreach( $arr as $key=> &$el ){
            
            if( is_array( $el ) ){
                sanitizeArray( $el );
            }else{
                $el = sanitizeTextField( $el, true );
            }
        }
        return  $arr; 
    }
}

if (!function_exists('setting')) {
    function setting($key) {
        return Settings::get($key);
    }
}

if (!function_exists('getField')) {
    function getField( $field ) {
        return Settings::getField( $field );
    }
}

if( !function_exists('getSectionSetting') ) {
    function getSectionSetting($params= [] , $fields= []) {
        
        return Settings::getSectionSetting($params, $fields);
    }
}

/**
 * Helper function to sanitize a string value from user input
 *
 * @param string    $string          String to sanitize.
 * @param bool      $keep_linebreak  Not compulsory Whether to keep newlines or not. Default: false.
 * @return string   Sanitized string.
 */

if( !function_exists('sanitizeTextField') ) {
    function sanitizeTextField( $string, $keep_linebreak = false ) {
        if ( is_object( $string ) || is_array( $string ) ) {
            return '';
        }
        $filtered = stripAllTags($string, $keep_linebreak);
        return clean($filtered, ['Attr.EnableID' => true ]);
    }
}

/**
* @param string $string        String containing HTML tags
* @param bool   $remove_breaks Optional. Whether to remove left over line breaks and white space chars
* @return string The processed string.
*/
if( !function_exists('stripAllTags') ) {

   function stripAllTags( $string, $remove_breaks_tag = false ) {

       $string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
       $string = strip_tags( $string, '<h1><h2><h3><h4><h5><6><div><b><strong><i><em><a><ul><ol><li><p><br><span><figure><sup><sub><table><tr><th><td><tbody><iframe><form><capture><label><fieldset><section>' );

       if ( $remove_breaks_tag ) {
           $string = preg_replace( '/[\r\n\t ]+/', ' ', $string );
       }
       return trim( $string );
   }
}

/**
* @return array The processed array.
*/
if( !function_exists('sanitizeArray') ) {

    function sanitizeArray( &$arr ){
        
        foreach( $arr as $key=> &$el ){
            
            if( is_array( $el ) ){
                sanitizeArray( $el );
            }else{
                $el = sanitizeTextField( $el, true );
            }
        }
        return  $arr; 
    }
}