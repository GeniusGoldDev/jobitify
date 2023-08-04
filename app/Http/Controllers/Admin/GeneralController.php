<?php

namespace App\Http\Controllers\Admin;
use ScssPhp\ScssPhp\Compiler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    
    public function updateSaas(){

        $theme_pri_color        = setting('_theme.theme_pri_color');
        $theme_sec_color        = setting('_theme.theme_sec_color');
        $theme_footer_bg        = setting('_theme.theme_footer_bg');
        $text_dark_color        = setting('_theme.text_dark_color');
        $text_light_color       = setting('_theme.text_light_color');
        $text_white_color       = setting('_theme.text_white_color');
        $text_yellow_color      = setting('_theme.text_yellow_color');
        $heading_color          = setting('_theme.heading_color');
        $btn_bg_pri_color       = setting('_theme.btn_bg_pri_color');
        $btn_bg_sec_color       = setting('_theme.btn_bg_sec_color');
        $link_color             = setting('_theme.link_color');
        $btn_text_color         = setting('_theme.btn_text_color');
        
        try{

            $compiler = new Compiler();
            $compiler->setSourceMap(Compiler::SOURCE_MAP_FILE);
            $source_scss    = public_path('scss/main.scss');
            $import_path    = public_path('scss/');
            $scss_content   = file_get_contents($source_scss);
            $target_css     = public_path('css/main.css');
            $compiler->addImportPath($import_path);

            $variables  = array(
                '$theme-color'                  => !empty($theme_pri_color) ? $theme_pri_color              : '#3377FF',
                '$secondary-color'              => !empty($theme_sec_color) ? $theme_sec_color              : '#353648',
                '$dark'                         => !empty($text_dark_color) ? $text_dark_color              : '#0A0F26',
                '$text-light'                   => !empty($text_light_color) ? $text_light_color            : '#999999',
                '$heading-font-color'           => !empty($heading_color) ? $heading_color                  : '#0A0F26',
                '$btn_bgcolor'                  => !empty($btn_bg_pri_color) ? $btn_bg_pri_color            : '#FCCF14',
                '$btn-two-bgclr'                => !empty($btn_bg_sec_color) ? $btn_bg_sec_color            : '#0A0F26',
                '$anchor_color'                 => !empty($link_color) ? $link_color                        : '#1DA1F2',
                '$btn_textcolor'                => !empty($btn_text_color) ? $btn_text_color                : '#1C1C1C',
                '$footer-bg'                    => !empty($theme_footer_bg) ? $theme_footer_bg              : '#0A1833',
                '$clr-white'                    => !empty($text_white_color) ? $text_white_color            : '#fff',
                '$primary_color_02_base'        => !empty($text_yellow_color) ? $text_yellow_color          : '#FCCF14',
            );

            $compiler->setSourceMapOptions([
                'sourceMapURL'      => 'main.css.map',
                'sourceMapFilename' => $target_css,
            ]);

            $compiler->addVariables($variables);
            $result  =  $compiler->compileString($scss_content);
            if( !empty($result->getCss()) ){
                file_put_contents(public_path('css/main.css.map'), $result->getSourceMap());
                file_put_contents($target_css, $result->getCss());
            }
        }catch (\Exception $e) {
          $err= $e->getMessage();
        }
    }
}
