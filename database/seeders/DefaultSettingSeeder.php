<?php

namespace Database\Seeders;

use File;
use DateTime;
use App\Models\{
    Menu,
    MenuItem,
};

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Setting\SiteSetting;
use Larabuild\Optionbuilder\Facades\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteSetting::truncate();
        $this->defaultSetting();
        $this->paymentMethods();
        $this->defualtMenu();
    }

    public function defaultSetting(){
        $def_setting = [
            '_dispute' => [
                'buyer_dispute_issues'      => [
                    [
                        'buyer_issues'  => 'The seller is not responding'
                    ],
                    [
                        'buyer_issues'  => 'The seller sent me an unfinished product',
                    ],
                    [
                        'buyer_issues'  => 'Seller is abusive or using unprofessional language',
                    ],
                    [
                        'buyer_issues'  => 'Seller not sure with his/her skills set',
                    ],
                    [
                        'buyer_issues'  => 'Others',
                    ],
                ],
                'seller_dispute_issues'     => [
                    [
                        'seller_issues' => 'The buyer is not responding',
                    ],
                    [
                        'seller_issues' => 'I’m too busy to complete this job',
                    ],
                    [
                        'seller_issues' => 'Due to personal reasons, I can not complete this job',
                    ],
                    [
                        'seller_issues' => 'Buyer requesting unplanned additional work',
                    ],
                    [
                        'seller_issues' => 'Others',
                    ],
                ],
                'buyer_dispute_after_days'  => 3,
            ],
            '_email' => [
                'email_logo'          => [
                    'file_name' => 'logo.png',
                ],
                'sender_name'         => 'TaskUp',
            ],
            '_general' => [
                'file_ext'                  => 'pdf,doc,docx,xls,xlsx,ppt,pptx,csv,jpg,jpeg,gif,png,mp4,mp3,3gp,flv,ogg,wmv,avi,txt',
                'image_file_ext'            => 'jpg,jpeg,gif,png',
                'image_file_size'           => 5, // in MB
                'file_size'                 => 20, // in MB
                'gig_listing_layout'        => 'grid',
                'date_format'               => 'F j, Y',
                'address_format'            => 'city_state_country',
                'per_page_record'           => '10',
                'currency'                  => 'USD',
                'footer_page'               => '1',
                'error_page_footer'         => '1',
                
                'deactive_account_reasons'  => [
                    [
                        'deactive_reason' => 'Not interested anymore'
                    ],
                ]
            ],
            '_project' => [
                'projet_search_min_price'       => 1,
                'project_price_search_range'    => [
                    "min" => 1,
                    "max" => 1000
                ],
                'projet_min_amount'         => 100,
                'maximum_freelancer'        => 5,
                'project_default_status'    => 'pending',
                'project_recomended_opt'    => ['languages','skills'],
                'step2_validation'          => ['duration','category','project_detail'],
                'step3_validation'          => ['expertlevel','skills','languages'],
            ],
            '_proposal' => [
                'default_status'     => 'pending',
                'seller_min_hr_rate' => 1,
                'seller_max_hr_rate' => 1000,
            ],
            '_seller' => [
                'seller_business_types' => [
                    [
                        'business_types'    => 'Agency',
                    ],
                    [
                        'business_types'    => 'Content manager',
                    ],
                    [
                        'business_types'    => 'Creative director',
                    ],
                    [
                        'business_types'    => 'Floor manager',
                    ],
                    [
                        'business_types'    => 'Independent',
                    ],
                    [
                        'business_types'    => 'Marketing specialist',
                    ],
                    [
                        'business_types'    => 'New Rising Talent',
                    ],
                ],
                'seller_price_search_range'    => [
                    "min" => 1,
                    "max" => 300
                ],
                'min_withdrawal_amt'        => 100,
                'seller_banner_img'         => [
                    'file_name' => 'banner_image.jpg',
                ],
                'social_links'              => 'enable',
            ],
            '_site' => [
                'site_name'     => 'TaskUp',
                'site_favicon'  => [
                    'file_name' => 'fav_36x36.png',
                ],
                'site_dark_logo'  => [
                    'file_name' => 'logo.png',
                ],
                'site_lite_logo'  => [
                    'file_name' => 'taskup-logo.png',
                ],
                'auth_bg'       => [
                    'file_name' => 'auth-background.jpg',
                ]
            ],
            '_adsense' => [
                'profile_adsense_code'      => '<img src="'.asset('demo-content/adsense_612x612.png').'" alt="google adsense">',
                'project_adsense_code'      => '<img src="'.asset('demo-content/adsense_844x844.png').'" alt="google adsense">',
                'add_gig_adsense'           => '<img src="'.asset('demo-content/adsense_844x844.png').'" alt="google adsense">',
                'seller_dashboard_adsense'  => '<img src="'.asset('demo-content/adsense_612x612.png').'" alt="google adsense">',

            ]
        ];
        
        
        foreach($def_setting as $section_key => $setting ){
            foreach ($setting as $field => $value) {
                if(in_array( $field, ['email_logo', 'site_dark_logo','site_lite_logo','site_favicon','auth_bg','seller_banner_img'])){
                    $value = uploadDemoImage('','optionbuilder/uploads', $value['file_name'], 'optionbuilder');
                    $value = [ json_encode($value) ];
                }
                
                if (isset($value) && !is_null($value)) {
                    Settings::set($section_key, $field, $value);
                }
            }
        }
    }

    public function paymentMethods(){

        $payment_methods    = [
            'method_type'   => 'others',
        ];

        $record = SiteSetting::create([ 
            'setting_type'  => 'payment',
            'meta_key'      => 'payment_methods',
            'meta_value'    => serialize($payment_methods)
        ]);
    }


    /**
     * Add defualt menues.
     */
    public function defualtMenu(){
        Menu::truncate();
        MenuItem::truncate();
        $menus = [
            [
                'name'          => 'Top menu',
                'location'      => 'header',
                'menu_items'    => [
                    [ // 1
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Home',
                        'route'     => url(''),
                        'type'      => 'page',
                        'sort'      => '0',
                        'class'     => '',
                    ],
                    [ // 2 
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'About us',
                        'route'     => url('about-us'),
                        'type'      => 'page',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [ // 3
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Terms & condition',
                        'route'     => url('terms-condition'),
                        'type'      => 'page',
                        'sort'      => '3',
                        'class'     => '',
                    ],
                    [ // 4
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'FAQ',
                        'route'     => url('faq'),
                        'type'      => 'page',
                        'sort'      => '2',
                        'class'     => '',
                    ],
                    [ // 5
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Pages',
                        'route'     => '#',
                        'type'      => 'custom',
                        'sort'      => '4',
                        'class'     => null,
                    ],
                    [// 6
                        'menu_id'   => '',
                        'parent_id' => '5',
                        'label'     => 'Projects',
                        'route'     => '#',
                        'type'      => 'custom',
                        'sort'      => '0',
                        'class'     => null,
                    ],
                    [// 7
                        'menu_id'   => '',
                        'parent_id' => '6',
                        'label'     => 'Find projects',
                        'route'     => url('search-projects'),
                        'type'      => 'custom',
                        'sort'      => '0',
                        'class'     => null,
                    ],
                    [// 8
                        'menu_id'   => '',
                        'parent_id' => '6',
                        'label'     => 'Project detail',
                        'route'     => url('project/wordpress-website-pages-with-digital-marketing'),
                        'type'      => 'custom',
                        'sort'      => '1',
                        'class'     => null,
                    ],
                    [// 9
                        'menu_id'   => '',
                        'parent_id' => '5',
                        'label'     => 'Talent',
                        'route'     => '#',
                        'type'      => 'custom',
                        'sort'      => '1',
                        'class'     => null,
                    ],
                    [// 10
                        'menu_id'   => '',
                        'parent_id' => '9',
                        'label'     => 'Find talent',
                        'route'     => url('search-sellers'),
                        'type'      => 'custom',
                        'sort'      => '0',
                        'class'     => null,
                    ],
                    [// 11
                        'menu_id'   => '',
                        'parent_id' => '9',
                        'label'     => 'Talent detail',
                        'route'     => url('seller/georgia-baker'),
                        'type'      => 'custom',
                        'sort'      => '1',
                        'class'     => null,
                    ],
                    [ // 12
                        'menu_id'   => '',
                        'parent_id' => '5',
                        'label'     => 'Gigs',
                        'route'     => url('search-projects'),
                        'type'      => 'custom',
                        'sort'      => '2',
                        'class'     => null,
                    ],
                    [ // 13
                        'menu_id'   => '',
                        'parent_id' => '12',
                        'label'     => 'Find gigs',
                        'route'     => url('search-gigs'),
                        'type'      => 'custom',
                        'sort'      => '0',
                        'class'     => null,
                    ],
                    [ // 13
                        'menu_id'   => '',
                        'parent_id' => '12',
                        'label'     => 'Gig detail',
                        'route'     => url('gig-detail/i-will-do-ultimate-seo-service-for-guaranteed-ranking-improvements'),
                        'type'      => 'custom',
                        'sort'      => '1',
                        'class'     => null,
                    ],
                ]
            ],
            [
                'name'          => 'Bottom menu',
                'location'      => 'footer',
                'menu_items'    => [
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'About us',
                        'route'     => url('about-us'),
                        'type'      => 'page',
                        'sort'      => '2',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Terms & condition',
                        'route'     => url('terms-condition'),
                        'type'      => 'page',
                        'sort'      => '0',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'FAQ',
                        'route'     => url('faq'),
                        'type'      => 'page',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                ]
            ]
        ];

        foreach($menus as $key => $menu){
            $check = Menu::where('name', $menu['name'])->exists();
            if(!$check){
                $menue = Menu::create([
                    'name'      => $menu['name'],
                    'location'  => $menu['location'],
                ]);
    
                foreach( $menu['menu_items'] as $items ){
                    MenuItem::create([
                        'menu_id'   => $menue->id,
                        'parent_id' => $items['parent_id'],
                        'label'     => $items['label'],
                        'route'     => $items['route'],
                        'type'      => $items['type'],
                        'sort'      => $items['sort'],
                        'class'     => '',
                    ]);
                }
            }
        }
    }
}
