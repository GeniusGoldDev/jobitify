<?php


namespace App\Http\Controllers\Pagebuilder;

use Illuminate\Http\Request;
use App\Models\SitePage;
use App\Http\Controllers\Controller;


class PageBuilderController extends Controller 
{
    public function build(  Request $request ){
        
        $page_url       = '';
        $page_id        = $request['id'];
        $page           = SitePage::select('route', 'status')->findorFail( $page_id );
        $page_url       = !empty($page->route) ? $page->route : '';
        $page_status    = !empty($page->status) ? $page->status : '';
        $page_blocks = [
            'top-menu-block'            => __('pages.top_menu_block'),
            'header-block'              => __('pages.header_block'),
            'categories-block'          => __('pages.category_block'),
            'mobile-app-block'          => __('pages.mob_app_block'),
            'projects-block'            => __('pages.projects_block'),
            'hiring-process-block'      => __('pages.hiring_process_block'),
            'footer-block'              => __('pages.footer_block'),
            'search-talent-block'       => __('pages.search_talent'),
            'professional-block'        => __('pages.seller_section'),
            'opportunities-block'       => __('pages.opportunities_section'),
            'user-feedback-block'       => __('pages.user_response_section'),
            'question-search-block'     => __('pages.ques_srch_block'),
            'send-question-block'       => __('pages.send_quest_block'),
            'terms-condition-block'     => __('pages.terms_condition_block'),
        ];
        return view('admin.pagebuilder', compact('page_blocks', 'page_id', 'page_url', 'page_status'));
    }

    public function uploadImage(Request $request){
        
        $response = isDemoSite();
        if( $response ){

            return response()->json([ 
                'title'     => __('general.demosite_res_title'),
                'type'      => 'error',
                'message'   => __('general.demosite_res_txt')
            ]); 
        }
        $bse64 = explode(',', $request->image); 
        $bse64 = trim($bse64[1]);
        if( ! base64_encode( base64_decode( $bse64, true ) ) === $bse64 ) {
            
            $image_file_ext  = setting('_general.image_file_ext');
            $allowImageExt   = !empty( $image_file_ext ) ?  explode(',', $image_file_ext)  : ['jpg','png'];
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.error_title'),
                'message'   => __('general.invalid_file_type' , ['file_types' => join(',', $allowImageExt) ])
            ]);
            return;
        }
        $data = array();
        $imageData = uploadImage($request->directory, $request->image);
        if( ! empty($imageData['url'] ) ) {
            $data['image'] = $imageData['url'];
        }
        return response()->json(['type' => 'success', 'url' => asset('storage/'.$imageData['url'])]);
        
    } 
}
