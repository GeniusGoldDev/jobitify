<?php

namespace App\Http\Controllers\Gig;

use App\Models\Gig\Gig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GigCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $slug, Request $request){

        $gig = Gig::select('id', 'author_id', 'title', 'attachments', 'downloadable')->with([
        'addons' => function($query){
            $query->select('addons.id','title','price', 'description');
        },
        'categories' => function($query){
            $query->select('name','category_id', 'category_level');
            $query->orderBy('category_level', 'asc');
        },
        'gig_plans' => function($query){
            $query->select('id','gig_id','title','price', 'delivery_time');
        }])->has('gigAuthor')->withAvg('ratings','rating')->withCount('ratings')->where(['slug' => $slug, 'status' => 'publish'])->firstOrFail();
        
        
        $currency               = setting('_general.currency');
        $currency_detail        = !empty( $currency) ? currencyList($currency) : array();
        $currency_symbol        = '';
        if( !empty($currency_detail['symbol']) ){
            $currency_symbol = $currency_detail['symbol'];
        }
        $gig_plan_id = !empty($request->get('plan_id')) ?  $request->get('plan_id') : $gig->gig_plans[0]->id;
        return view('front-end.gig.gig-cart', compact('gig', 'currency_symbol', 'gig_plan_id'));
    }

}
