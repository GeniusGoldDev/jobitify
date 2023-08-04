<?php

namespace App\Http\Livewire\PageBuilder;

use App\Models\SitePage;
use Livewire\Component;

class BlockStyleSetting extends Component
{
    
    protected $listeners = [ 'getBlockStyleSetting', 'updateBlockStyle', 'resetSetting'];
  
    public $position, $padding, $custom_class, $margin = [];
    public $text_align      = '';
    public $block_id        = '';
    public $block_key       = '';
    public $page_blocks     = [];
    public $page_id         = '';

    public function render(){
        return view('livewire.pagebuilder.block-style-setting');
    }

    public function mount( $page_id, $page_blocks ){

        $this->page_id      = $page_id;
        $this->page_blocks  = $page_blocks;
    } 

    public function getBlockStyleSetting( $params ){

        $this->block_id     = $params['id'];
        $this->block_key    = $params['block_key'];
        $this->custom_class     = !empty($params['settings']['custom_class'])    ? $params['settings']['custom_class'] : '';
        $style                  = !empty($params['settings']['attributes'])   ? $params['settings']['attributes'] : [];
        $padding                = !empty($style['padding'])       ? $style['padding'] : [];
        $margin                 = !empty($style['margin'])        ? $style['margin'] : [];
        $position               = !empty($style['position'])      ? $style['position'] : [];
        $this->text_align       = !empty($style['text_align'])    ? $style['text_align'] : '';
        
        $this->padding['top']      = !empty($padding['top'])    ? $padding['top'] : '';
        $this->padding['right']    = !empty($padding['right'])  ? $padding['right'] : '';
        $this->padding['bottom']   = !empty($padding['bottom']) ? $padding['bottom'] : '';
        $this->padding['left']     = !empty($padding['left'])   ? $padding['left'] : '';
        
        $this->margin['top']      = !empty($margin['top'])      ? $margin['top']   : '';
        $this->margin['right']    = !empty($margin['right'])    ? $margin['right']  : '';
        $this->margin['bottom']   = !empty($margin['bottom'])   ? $margin['bottom'] : '';
        $this->margin['left']     = !empty($margin['left'])     ? $margin['left']   : '';
        
        $this->position['width']        = !empty($position['width'])        ? $position['width'] : '';
        $this->position['height']       = !empty($position['height'])       ? $position['height'] : '';
        $this->position['min_width']    = !empty($position['min_width'])    ? $position['min_width'] : '';
        $this->position['min_height']   = !empty($position['min_height'])   ? $position['min_height'] : '';
        $this->position['max_width']    = !empty($position['max_width'])    ? $position['max_width'] : '';
        $this->position['max_height']   = !empty($position['max_height'])   ? $position['max_height'] : '';

        

    }

    public function resetSetting() {
        $this->block_id = '';
    }

    public function updateBlockStyle( $data ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        parse_str($data, $newRectord);
        $formData = [];

        foreach($newRectord as $property => $record ){
            if(is_array($record)){
                $formData[$property] = SanitizeArray($record);
            } else {
                $formData[$property]   = sanitizeTextField($record, true);
            }
        }

        $page               = SitePage::select('id','settings')->find( $this->page_id );
        $page_settings      = !empty( $page->settings ) ? json_decode($page->settings, true) : [];
        $block_key          = explode('__', $this->block_key);
        $id                 = $block_key[0] ;
        $key                = isset($block_key[1]) ? $block_key[1] : '';
        if( !empty($page_settings[$key]) && $page_settings[$key]['block_id'] == $id ){

            $style       = !empty($page_settings[$key]['css']['attributes']) ? $page_settings[$key]['css']['attributes'] : [];
            $padding     = !empty($style['padding'])       ? $style['padding']      : [];
            $margin      = !empty($style['margin'])        ? $style['margin']       : [];
            $position    = !empty($style['position'])      ? $style['position']     : [];
            $text_align  = !empty($style['text_align'])    ? $style['text_align']   : '';

            $style = [];
            $style['attributes'] = $formData;
            if(isset($style['attributes']['custom_class'])){
                unset($style['attributes']['custom_class']);
            }
            extract($formData);

            $width          = !empty($position['width'])        ? 'width:'.$position['width'].'px;' : ''; 
            $height         = !empty($position['height'])       ? 'height:'.$position['height'].'px;' : ''; 
            $min_width      = !empty($position['min_width'])    ? 'min-width:'.$position['min_width'].'px;' : ''; 
            $min_height     = !empty($position['min_height'])   ? 'min-height:'.$position['min_height'].'px;' : ''; 
            $max_width      = !empty($position['max_width'])    ? 'max-width:'.$position['max_width'].'px;' : ''; 
            $max_height     = !empty($position['max_height'])   ? 'max-height:'.$position['max_height'].'px;' : ''; 

            $padding_top        = !empty($padding['top'])     ? $padding['top'].'px ' : '0px '; 
            $padding_right      = !empty($padding['right'])   ? $padding['right'].'px ' : '0px '; 
            $padding_bottom     = !empty($padding['bottom'])  ? $padding['bottom'].'px ' : '0px '; 
            $padding_left       = !empty($padding['left'])    ? $padding['left'].'px;' : '0px;'; 
            $padding = 'padding:'.$padding_top.$padding_right.$padding_bottom.$padding_left;

            $margin_top        = !empty($margin['top'])     ? $margin['top'].'px ' : '0px '; 
            $margin_right      = !empty($margin['right'])   ? $margin['right'].'px ' : '0px '; 
            $margin_bottom     = !empty($margin['bottom'])  ? $margin['bottom'].'px ' : '0px '; 
            $margin_left       = !empty($margin['left'])    ? $margin['left'].'px;' : '0px;'; 
            $this->text_align  = !empty($text_align)               ? $text_align : ''; 
            $text_align        = !empty($text_align)               ? 'text-align:'.$text_align.';' : ''; 
            $margin = 'margin:'.$margin_top.$margin_right.$margin_bottom.$margin_left;

            $style_css = '{';
            $style_css .= $width;
            $style_css .= $height;
            $style_css .= $min_width;
            $style_css .= $min_height;
            $style_css .= $max_width;
            $style_css .= $max_height;
            $style_css .= $padding;
            $style_css .= $margin;
            $style_css .= $text_align.'}';
            $style['style'] = $style_css;
            $page_settings[$key]['css'] = $style;
            $page_settings[$key]['css']['custom_class'] = !empty($custom_class) ? $custom_class : '';

            $settings = json_encode($page_settings);
            $page->update(['settings' => $settings ]);
            $edit_custom_class = false;
            if( $this->custom_class != $custom_class ) {
                $edit_custom_class = true;
                $this->emit('update-custom-class-'.$this->block_key, ['custom_class' => $custom_class]);
                $this->custom_class = $custom_class;
            }

            $this->dispatchBrowserEvent('updateStyleClass', [
                'class'                 => $this->block_key,
                'style'                 => '.'.$this->block_key.$style_css
            ]);
        }
    }
}
