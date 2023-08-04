<?php

namespace App\Http\Controllers\SearchItem;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Taxonomies\Skill;
use App\Models\Taxonomies\Language;
use App\Http\Controllers\Controller;
use App\Models\Taxonomies\ExpertLevel;
use App\Models\Taxonomies\GigCategory;
use App\Models\Taxonomies\ProjectCategory;

class SearchItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $selected_category      = $request->has('category_id') ? $request->category_id : '';
        $min_price              = $request->has('min_price') && is_numeric( $request->min_price ) ? $request->min_price : '';
        $max_price              = $request->has('max_price') && is_numeric( $request->max_price ) ? $request->max_price : '';
        $gig_listing_layout     = setting('_general.gig_listing_layout');
        $view_type              = !empty( $gig_listing_layout ) ? $gig_listing_layout : 'grid' ;
        $view                   = $view_type == 'grid' ? 'gig-gridview' : 'gig-listview';
        $locations              = Country::select('id','name', 'short_code')->where('status', 'active')->orderBy('name', 'ASC')->get();
        $categories             = GigCategory::whereNull('parent_id')->select('id','name')->get();
        addJsVars([ 
            'isRTL' => setting('_site.rtl')
        ]);
        
        

        return view('front-end.gig.'.$view, compact('locations','categories','selected_category', 'min_price', 'max_price', 'view'));
    }

    /**
     * Display a listing of search sellers.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchSellers(Request $request){
        
        $keyword              = $request->has('keyword') ? clean( $request->keyword ) : '';
        $seller_min_hr_rate   = $request->has('seller_min_hr_rate') ? clean( $request->seller_min_hr_rate ) : '';
        $seller_max_hr_rate   = $request->has('seller_max_hr_rate') ? clean( $request->seller_max_hr_rate ) : '';
        $search_by_hr_rate    = !empty($seller_min_hr_rate) || !empty($seller_max_hr_rate) ? true : false;
        $languages            = Language::select('id','name')->where('status', 'active')->orderBy('name', 'ASC')->get();
        $locations            = Country::select('id','name', 'short_code')->where('status', 'active')->orderBy('name', 'ASC')->get();
        $skills               = Skill::select('id','name')->where('status', 'active')->orderBy('id', 'DESC')->get();
        $seller_types         = setting('_seller.seller_business_types');
        $seller_types         = !empty($seller_types) ? array_column($seller_types, 'business_types') : [];
        $min_hr_rate          = $max_hr_rate = ''; 

        $seller_price_search_range         = setting('_seller.seller_price_search_range');
        if( !empty($seller_price_search_range) ){

            $min_hr_rate = $seller_price_search_range['min'];
            $max_hr_rate = $seller_price_search_range['max'];
        }
        $address_format      = setting('_general.address_format');
        $currency            = setting('_general.currency');
        $date_format         = setting('_general.date_format');
        $per_page_record     = setting('_general.per_page_record');

        $currency_detail      = !empty($currency)           ? currencyList($currency) : array();
        $date_format          = !empty($date_format)        ? $date_format : 'm d, Y';
        $per_page             = !empty($per_page_record)    ? $per_page_record : 10;
        $address_format       = !empty($address_format)     ? $address_format : 'state_country';

        $currency_symbol      = '';

        $english_levels       = [
            'basic'             => __('profile_settings.basic_level'),
            'conversational'    => __('profile_settings.conversational_level'),
            'fluent'            => __('profile_settings.fluent_level'),
            'native'            => __('profile_settings.native_level'),
            'professional'      => __('profile_settings.professional_level'),
        ];

        if(!empty($currency_detail)){
            $currency_symbol   = $currency_detail['symbol']; 
        }

        if( empty($seller_min_hr_rate) ){
            $seller_min_hr_rate    = !empty($min_hr_rate)  ? $min_hr_rate : 1;
        }

        if( empty($seller_max_hr_rate) ){
            $seller_max_hr_rate = !empty($max_hr_rate)  ? $max_hr_rate : 300;
        }
        
        addJsVars([ 
            'isRTL' => setting('_site.rtl')
        ]);
        return view('front-end.sellers.search-sellers', compact(
            'languages','locations','skills','seller_types',
            'date_format','per_page','seller_min_hr_rate',
            'seller_max_hr_rate','keyword','currency_symbol',
            'english_levels','address_format', 'search_by_hr_rate'
        ));
    }


    public function searchProjects(Request $request){

        $keyword            = $request->has('keyword') ? clean( $request->keyword ) : '';
        $category_slug      = $request->has('category') ? clean( $request->category ) : '';
        $project_min_price  = $request->has('project_min_price') ? clean( $request->project_min_price ) : '';
        $project_max_price  = $request->has('project_max_price') ? clean( $request->project_max_price ) : '';
        $search_by_price    = !empty($project_min_price) || !empty($project_max_price) ? true : false;
        $price_search_range = setting('_project.project_price_search_range');
        $min_price          = 1;  // default price
        $max_price          = 1000; // default price
        $filter_class       = 'd-none';
        if( !empty($keyword) || !empty($project_min_price) || !empty($project_max_price) || !empty($category_slug) ){
            $filter_class = '';
        }
        if( !empty($price_search_range) ){
            $min_price = !empty($price_search_range['min']) ? $price_search_range['min'] : 1;
            $max_price = !empty($price_search_range['max']) ? $price_search_range['max'] : 1000;
        }

        if( empty($project_min_price) ){
            $project_min_price    = !empty($min_price) ? $min_price : 1;
        }

        if( empty($project_max_price) ){
            $project_max_price = !empty($max_price)  ? $max_price : 1000;
        }


        $languages          = Language::select('id','name')->where('status', 'active')->orderBy('name', 'ASC')->get();
        $expertise_levels   = ExpertLevel::select('id','name')->where('status', 'active')->orderBy('id', 'DESC')->get();
        $locations          = Country::select('id','name', 'short_code')->where('status', 'active')->orderBy('name', 'ASC')->get();
        $skills             = Skill::select('id','name')->where('status', 'active')->orderBy('id', 'DESC')->get();
        $categories_tree    = ProjectCategory::tree()->get()->toTree()->toArray();
        $categories         = hierarchyTree($categories_tree);
        $category_id        = '';

        addJsVars([
            'categories'    => $categories,
            'isRTL'         => setting('_site.rtl')
        ]);

        if( !empty($category_slug) ){
            $category       = ProjectCategory::select('id')->where('slug','like','%'. $category_slug.'%')->first();
            $category_id    = !empty($category) ? $category->id : '';
        }
        addJsVars(['category_id' => $category_id]);
        
        return view('front-end.projects.search-projects', compact(
            'languages', 'expertise_levels', 'locations', 
            'category_id', 'keyword', 'project_min_price', 
            'project_max_price', 'filter_class','min_price', 
            'max_price', 'search_by_price', 'skills'
        ));
    }
}
