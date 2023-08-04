<?php

namespace Database\Seeders;
use File;
use DateTime;

use App\Models\Gig\Gig;
use App\Models\Gig\GigPlan;
use App\Models\Gig\GigFaq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultGigs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->defaultGigs();
    }

    /**
     * Create dummy gigs.
     */
    public function defaultGigs(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Gig::truncate();
            DB::table('gig_category_link')->truncate();
            GigPlan::truncate();
            GigFaq::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $gig_desciption = '<div class="tk-text-wrapper">
                            <p>Nulla nisl sagittis, sed ulputate consequat pharetra. Leo mollis amet, duis elite musta nibhae quisque uate phaslus necerat scelerse. Sed turpis ullamcorper sed sit a vel pharetra porttitor odio non elit diam cursues Siet non, est curatur odion netus idsit enim consectur hendret mi, eget purus odio pellentes suspende. Sit nunc arcu vestibuum etarcu. Cursus fringilla commodo id aliquam commodo nisle suspendisse aemetneta auctor nonate volutpat ante est tempus enim ipsam voluptatem quiaptas sit aspernatur aut odit aute fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porero quisquam est, qui dolorem ipsum quia dolor sit amet consectetur, adipisci velit, sed quia non numquam eiustam eidi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                            <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid extmishea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esseam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem antium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto.</p>
                            <ul>
                                <li>Cupiditate non provident, similique sunt in culpame magni dolores eos qui ratione</li>
                                <li>Quiofficia deserunt mollitia animi id est laborum etalorum voluptatem sequite</li>
                                <li>Et harum quidem rerum facilis expedita porero quisquam est, qui dolorem ipsum quia</li>
                                <li>Nam libero tempore cum soluta dolor sit amet consectetur adipisci velitem</li>
                            </ul>
                            <h3>What more can expect</h3>
                            <p>Nemo enim ipsam voluptatem quiaptas sit aspernatur aut odit aut fugit, sed quia consequuntur magniores eos qui ratione voluptatem sequi nesciunt. Neque porero quisquam est, qui dolorem ipsum quia doluor sit amet consectetur, adipisci velit, sed quia non numquam eiustam modi tempora incidunt ut labore etolore magnam aliquam quaerat voluptatem.</p>
                            <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid extmishea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esseam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
                            <p>Nemo enim ipsam voluptatem quiaptas sit aspernatur aut odit aut fugit, sed quia consequuntur magniores eos qui ratione voluptatem sequi nesciunt. Neque porero quisquam est, qui dolorem ipsum quia doluor sit amet consectetur, adipisci velit, sed quia non numquam eiustam modi tempora incidunt ut labore etolore magnam aliquam quaerat voluptatem.</p>
                            <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid extmishea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esseam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
                        </div>';


        $gig_faq_list = [
            [
                'question'	=> 'Apply these 6 secret techniques to improve WordPress development',
                'answer'    => 'Excepteur sint occaecat cupidatat non proident, saeunt in culpa qui officia deserunt mollit anim laborum. Seden utem perspiciatis undesieu omnis voluptatem accusantium doque laudantium, totam rem aiam eaqueiu ipsa quae ab illoion inventore veritatisetm quasitea architecto beataea dictaed quia couuntur magni dolores eos aquist ratione vtatem seque nesnt.',
            ],
            [
                'question'  => '6 enticing ways to improve your WordPress development skills',
                'answer'    => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.",
            ],
            [
                'question'  => 'Top 80 quotes on WordPress development',
                'answer'    => "Excepteur sint occaecat cupidatat non proident, saeunt in culpa qui officia deserunt mollit anim laborum. Seden utem perspiciatis undesieu omnis voluptatem accusantium doque laudantium, totam rem aiam eaqueiu ipsa quae ab illoion inventore veritatisetm quasitea architecto beataea dictaed quia couuntur magni dolores eos aquist ratione vtatem seque nesnt.",
            ],
            [
                'question'  => 'How to make your WordPress development look amazing in 6 days',
                'answer'    => "Excepteur sint occaecat cupidatat non proident, saeunt in culpa qui officia deserunt mollit anim laborum. Seden utem perspiciatis undesieu omnis voluptatem accusantium doque laudantium, totam rem aiam eaqueiu ipsa quae ab illoion inventore veritatisetm quasitea architecto beataea dictaed quia couuntur magni dolores eos aquist ratione vtatem seque nesnt.",
            ],
            [
                'question'  => 'How to something your software projects',
                'answer'    => "Excepteur sint occaecat cupidatat non proident, saeunt in culpa qui officia deserunt mollit anim laborum. Seden utem perspiciatis undesieu omnis voluptatem accusantium doque laudantium, totam rem aiam eaqueiu ipsa quae ab illoion inventore veritatisetm quasitea architecto beataea dictaed quia couuntur magni dolores eos aquist ratione vtatem seque nesnt.",
            ],
            [
                'question'  => 'Is software projects a scam?',
                'answer'    => "Excepteur sint occaecat cupidatat non proident, saeunt in culpa qui officia deserunt mollit anim laborum. Seden utem perspiciatis undesieu omnis voluptatem accusantium doque laudantium, totam rem aiam eaqueiu ipsa quae ab illoion inventore veritatisetm quasitea architecto beataea dictaed quia couuntur magni dolores eos aquist ratione vtatem seque nesnt.",
            ],
        ];

        $gig_plan_list = [
            [
                'title'         => 'Basic',
                'description'   => 'Adipisicing eliate adoems teme atpoir likuie norie acima amtetams.',
                'delivery_time' => rand(1,3),
                'is_featured'   => rand(0,1),
                'options'       => null,
            ],
            [
                'title'         => 'Papular',
                'description'   => 'Adipisicing eliate adoems teme atpoir likuie norie acima amtetams.',
                'delivery_time' => rand(4,5),
                'is_featured'   => rand(0,1),
                'options'       => null,
            ],
            [
                'title'         => 'Premium',
                'description'   => 'Adipisicing eliate adoems teme atpoir likuie norie acima amtetams.',
                'delivery_time' => rand(6,7),
                'is_featured'   => rand(0,1),
                'options'       => null,
            ],
        ];

        $addresses = [
            [
                'country'   => 'United Kingdom',
                'zipcode'   => 'N1',
                'address'   => 'a:5:{s:7:"address";s:13:"London N1, UK";s:3:"lng";d:-0.08813879999999999;s:3:"lat";d:51.5412621;s:27:"administrative_area_level_1";a:2:{s:9:"long_name";s:7:"England";s:10:"short_name";s:7:"England";}s:7:"country";a:2:{s:9:"long_name";s:14:"United Kingdom";s:10:"short_name";s:2:"GB";}}',
            ],
            [
                'country'   => 'United Kingdom',
                'zipcode'   => 'N8',
                'address'   => 'a:5:{s:7:"address";s:13:"London N8, UK";s:3:"lng";d:-0.1236257;s:3:"lat";d:51.5833118;s:27:"administrative_area_level_1";a:2:{s:9:"long_name";s:7:"England";s:10:"short_name";s:7:"England";}s:7:"country";a:2:{s:9:"long_name";s:14:"United Kingdom";s:10:"short_name";s:2:"GB";}}',
            ],
            [
                'country'   => 'United Kingdom',
                'zipcode'   => 'N16',
                'address'   => 'a:5:{s:7:"address";s:14:"London N16, UK";s:3:"lng";d:-0.0764353;s:3:"lat";d:51.5623078;s:27:"administrative_area_level_1";a:2:{s:9:"long_name";s:7:"England";s:10:"short_name";s:7:"England";}s:7:"country";a:2:{s:9:"long_name";s:14:"United Kingdom";s:10:"short_name";s:2:"GB";}}',
            ],
            [
                'country'   => 'United Kingdom',
                'zipcode'   => 'NW5',
                'address'   => 'a:5:{s:7:"address";s:14:"London NW5, UK";s:3:"lng";d:-0.1441111;s:3:"lat";d:51.5543545;s:27:"administrative_area_level_1";a:2:{s:9:"long_name";s:7:"England";s:10:"short_name";s:7:"England";}s:7:"country";a:2:{s:9:"long_name";s:14:"United Kingdom";s:10:"short_name";s:2:"GB";}}',
            ],
            [
                'country'   => 'United Kingdom',
                'zipcode'   => 'NW6',
                'address'   => 'a:5:{s:7:"address";s:14:"London NW6, UK";s:3:"lng";d:-0.1970833;s:3:"lat";d:51.5437594;s:27:"administrative_area_level_1";a:2:{s:9:"long_name";s:7:"England";s:10:"short_name";s:7:"England";}s:7:"country";a:2:{s:9:"long_name";s:14:"United Kingdom";s:10:"short_name";s:2:"GB";}}',
            ],
            [
                'country'   => 'United Kingdom',
                'zipcode'   => 'W2',
                'address'   => 'a:5:{s:7:"address";s:13:"London W2, UK";s:3:"lng";d:-0.1703541;s:3:"lat";d:51.5096281;s:27:"administrative_area_level_1";a:2:{s:9:"long_name";s:7:"England";s:10:"short_name";s:7:"England";}s:7:"country";a:2:{s:9:"long_name";s:14:"United Kingdom";s:10:"short_name";s:2:"GB";}}',
            ],
            [
                'country'   => 'United Kingdom',
                'zipcode'   => 'W10',
                'address'   => 'a:5:{s:7:"address";s:14:"London W10, UK";s:3:"lng";d:-0.2146099;s:3:"lat";d:51.52269709999999;s:27:"administrative_area_level_1";a:2:{s:9:"long_name";s:7:"England";s:10:"short_name";s:7:"England";}s:7:"country";a:2:{s:9:"long_name";s:14:"United Kingdom";s:10:"short_name";s:2:"GB";}}',
            ],

        ];
        $gigs = [
            [ //1
                'author_id'         => 7,
                'title'             => 'I Will write REST APi in react for website',
                'attachments'       => [ 1,2,3,4 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '1',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '2',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '2',	
                        'category_level'    => '2',	
                    ]
                ],
            ],
            [ // 2
                'author_id'         => 7,
                'title'             => 'I Will Manage Shopify E-commerce Store',
                'attachments'       => [ 3,4,5,6 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '8',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '9',	
                        'category_level'    => '2',	
                    ]
                ],
            ],
            [ // 3
                'author_id'         => 7,
                'title'             => 'I Will Setup 7 Figure Shopify Website Shopify Store',
                'attachments'       => [ 4,5,6,7 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '15',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '16',	
                        'category_level'    => '1',	
                    ],
                ],
            ],
            [ // 4
                'author_id'         => 7,
                'title'             => 'I Will Do Automation To Drop Shipping For Website',
                'attachments'       => [ 6,7,8,9 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '1',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '2',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '3',	
                        'category_level'    => '2',	
                    ],
                    [
                        'category_id'       => '4',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 5
                'author_id'         => 8,
                'title'             => 'I Will Redesign Shopify Dropshipping Store To Boost Sales',
                'attachments'       => [ 9,10,11,12 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '1',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '2',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '3',	
                        'category_level'    => '2',	
                    ],
                    [
                        'category_id'       => '4',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 6
                'author_id'         => 8,
                'title'             => 'I Will Make Professional Excel And Google Sheets',
                'attachments'       => [ 13,14,15, 1],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '8',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '9',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 7
                'author_id'         => 8,
                'title'             => 'I Will Edit And Master Your Audiobook For Acx',
                'attachments'       => [ 1, 2, 3, 4],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '1',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '2',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '3',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 8
                'author_id'         => 8,
                'title'             => 'I Will Provide Pro SEO Report, Competitor Website Audit And Analysis',
                'attachments'       => [ 5, 6, 7, 8 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '8',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '9',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 9
                'author_id'         => 9,
                'title'             => 'I Will Create, Fix, Customize, Your WordPress Website',
                'attachments'       => [ 9, 10, 11, 12 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '1',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '2',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '3',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 10
                'author_id'         => 9,
                'title'             => 'I Will Create Automated Shopify Dropshipping Store',
                'attachments'       => [ 13,14,15,1 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '8',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '9',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 11
                'author_id'         => 9,
                'title'             => 'I Will Test Your Applications Or Websites For Usability',
                'attachments'       => [ 2, 3, 4, 5 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '8',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '9',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 12
                'author_id'         => 9,
                'title'             => 'I Will Write And Publish A Guest Post On Da 80 Dofollow Post',
                'attachments'       => [ 6, 7, 8, 9 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '1',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '2',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '3',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 13
                'author_id'         => 10,
                'title'             => 'I Will Write Article And Do Content Writting',
                'attachments'       => [ 10, 11, 12, 13 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '8',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '9',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 14
                'author_id'         => 10,
                'title'             => 'I Will Do Embedded C Coding For Tiva C And Other Microcontrollers',
                'attachments'       => [ 14,15,1,2 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '15',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '16',	
                        'category_level'    => '1',	
                    ],
                ],
            ],
            [ // 15
                'author_id'         => 10,
                'title'             => 'I Will upgrade, Secure Your WordPress Website',
                'attachments'       => [ 3, 4, 5, 6 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '17',	
                        'category_level'    => '0',	
                    ],
                ],
            ],
            [ // 16
                'author_id'         => 10,
                'title'             => 'I will convert PSD to HTML for WordPress theme',
                'attachments'       => [ 7, 8, 9, 10 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 17
                'author_id'         => 11,
                'title'             => 'I Will Develop Ios And Android Mobile App Using React Native',
                'attachments'       => [ 3, 4, 5, 6 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 18
                'author_id'         => 11,
                'title'             => 'I can create informative website with contents',
                'attachments'       => [ 7, 8, 9, 10 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 19
                'author_id'         => 11,
                'title'             => 'Programming & TechVideo & Animation I Will Make A Hybrid Application With Android, Php',
                'attachments'       => [ 11, 12, 13, 14 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 20
                'author_id'         => 11,
                'title'             => 'Programming & TechVideo & Animation I Will Make A Hybrid Application With Android, Php',
                'attachments'       => [ 1, 2, 3, 4 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 21
                'author_id'         => 12,
                'title'             => 'I Will Be Your Ios Developer And Update Old Apps',
                'attachments'       => [ 5, 6, 7, 8 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 22
                'author_id'         => 12,
                'title'             => 'I will do professional cinematic travel or youtube video editing',
                'attachments'       => [ 9, 10, 11, 12 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 23
                'author_id'         => 12,
                'title'             => 'I will do a warm, deep, mature, rich, smooth, american accent, english, male voiceover',
                'attachments'       => [ 13, 14, 15, 1 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 24
                'author_id'         => 12,
                'title'             => 'I will assess the SSL or tls used on your website or IP address',
                'attachments'       => [ 13, 14, 15, 1 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 25
                'author_id'         => 13,
                'title'             => 'I will professionally edit any video',
                'attachments'       => [ 13, 14, 15, 1 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 26
                'author_id'         => 13,
                'title'             => 'I will professionally edit your youtube video',
                'attachments'       => [ 3, 4, 5, 6 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 27
                'author_id'         => 13,
                'title'             => 'I will migrate your website to google cloud service',
                'attachments'       => [ 13, 14, 15, 1 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 28
                'author_id'         => 13,
                'title'             => 'I will do vulnerability scanning for network or website',
                'attachments'       => [ 3, 4, 5, 6 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 29
                'author_id'         => 14,
                'title'             => 'I will create opening and end credits sequence for movie',
                'attachments'       => [ 7, 8, 9, 10 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 30
                'author_id'         => 14,
                'title'             => 'I will convert figma to wordpress with elementor pro',
                'attachments'       => [ 11, 12, 13, 14 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 31
                'author_id'         => 14,
                'title'             => 'I will create your responsive wix editor x website',
                'attachments'       => [ 15, 1, 2, 3 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 32
                'author_id'         => 14,
                'title'             => 'I will do build and design your wordpress business website',
                'attachments'       => [ 4, 5, 6, 7 ],
                'downloadable'      => null,
                'is_featured'       => 3,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 33
                'author_id'         => 15,
                'title'             => 'I will build a modern wordpress website with a unique web design',
                'attachments'       => [ 8, 9, 10, 11 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 34
                'author_id'         => 15,
                'title'             => 'I will create wix website design,redesign wix website',
                'attachments'       => [ 12, 13, 14, 15 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 35
                'author_id'         => 15,
                'title'             => 'I will develop responsive wordpress website design or modern wordpress website',
                'attachments'       => [ 1, 2, 3, 4 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 36
                'author_id'         => 15,
                'title'             => 'I will manual web scraping, data mining, data collection for accuracy',
                'attachments'       => [ 5, 6, 7, 8 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 37
                'author_id'         => 16,
                'title'             => 'I will scrape a website and return the results in a excel file',
                'attachments'       => [ 9, 10, 11, 12 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 38
                'author_id'         => 16,
                'title'             => 'I will give professional power bi support, dax and power query',
                'attachments'       => [ 13, 14, 15, 1 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 39
                'author_id'         => 16,
                'title'             => 'I will do everything in excel macro vba, formulas, database',
                'attachments'       => [ 2, 3, 4, 5 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 40
                'author_id'         => 16,
                'title'             => 'I will do web scraping with python scrapy or selenium',
                'attachments'       => [ 6, 7, 8, 9 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 41
                'author_id'         => 17,
                'title'             => 'I will organize, clean and merge data',
                'attachments'       => [ 10, 11, 12, 13 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 42
                'author_id'         => 17,
                'title'             => 'I will do web scraping, data mining any website up to 100k records in 1 day',
                'attachments'       => [ 14, 15, 1, 2 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 43
                'author_id'         => 17,
                'title'             => 'I will optimize website SEO service on wordpress, shopify, wix for google top ranking',
                'attachments'       => [ 3, 4, 5, 6 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 44
                'author_id'         => 17,
                'title'             => 'I will optimize your website with SEO',
                'attachments'       => [ 7, 8, 9, 10 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 45
                'author_id'         => 18,
                'title'             => 'I will white hat seo link building service manual backlink strategy for google top rank',
                'attachments'       => [ 11, 12, 13, 14 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 46
                'author_id'         => 18,
                'title'             => 'I will do ultimate SEO service for guaranteed ranking improvements',
                'attachments'       => [ 15, 1, 2, 3 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 47
                'author_id'         => 18,
                'title'             => 'I will do monthly SEO backlinks service with white hat link building',
                'attachments'       => [ 4, 5, 6, 7 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 48
                'author_id'         => 18,
                'title'             => 'I will be your web3 project nft crypto senior advisor',
                'attachments'       => [ 8, 9, 10, 11 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 49
                'author_id'         => 19,
                'title'             => 'I will create over 1000 united kingdom UK backlinks',
                'attachments'       => [ 12, 13, 14, 15 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 50
                'author_id'         => 19,
                'title'             => 'I will do high quality dofollow SEO backlinks high da authority link building service',
                'attachments'       => [ 1, 2, 3, 4 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 51
                'author_id'         => 19,
                'title'             => 'I will be your nft discord moderator, admin and manager',
                'attachments'       => [ 5, 6, 7, 8 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 52
                'author_id'         => 19,
                'title'             => 'I will advertise and promote your discord server to over 100k users',
                'attachments'       => [ 9, 10, 11, 12 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 53
                'author_id'         => 20,
                'title'             => 'I will chat in your nft discord chat,discord manager,discord chatter, discord chat',
                'attachments'       => [ 13, 14, 15, 1 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 54
                'author_id'         => 20,
                'title'             => 'I will be your telegram admin, mod and nft discord community manager',
                'attachments'       => [ 1, 2, 3, 4 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 55
                'author_id'         => 20,
                'title'             => 'I will be your discord moderator and community manager',
                'attachments'       => [ 5, 6, 7, 8 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 56
                'author_id'         => 20,
                'title'             => 'I will promote your discord project via mass dm advertising',
                'attachments'       => [ 9, 10, 11, 12 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 57
                'author_id'         => 21,
                'title'             => 'I will manage your facebook page and group professionally',
                'attachments'       => [ 13, 14, 15, 1 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 58
                'author_id'         => 21,
                'title'             => 'I will record a neutral, articulate, clear british rp voice for you',
                'attachments'       => [ 2, 3, 4, 5 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 59
                'author_id'         => 21,
                'title'             => 'I will voice act male video game, anime and cartoon characters',
                'attachments'       => [ 6, 7, 8, 9 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 60
                'author_id'         => 21,
                'title'             => 'I will record professional french voice over',
                'attachments'       => [ 10, 11, 12, 13 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 61
                'author_id'         => 22,
                'title'             => 'I will record a professional female voice over',
                'attachments'       => [ 14, 15, 1, 2 ],
                'downloadable'      => null,
                'is_featured'       => 0,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
            [ // 62
                'author_id'         => 22,
                'title'             => 'I will do a 200 word professional north american male voice over',
                'attachments'       => [ 3, 4, 5, 6 ],
                'downloadable'      => null,
                'is_featured'       => 1,
                'featured_expiry'   => null,
                'status'            => 'publish',
                'gig_category_link' => [
                    [
                        'category_id'       => '7',	
                        'category_level'    => '0',	
                    ],
                    [
                        'category_id'       => '11',	
                        'category_level'    => '1',	
                    ],
                    [
                        'category_id'       => '13',	
                        'category_level'    => '2',	
                    ],
                ],
            ],
        ];

        foreach( $gigs as $key => $gig ){
            $files = $gig['attachments'];
            $attachments = [];
            $gig_id= $key+1;

            foreach($files as $file){

                $existFile      = public_path().'/demo-content/posts/post-'.$file.'.jpg';
                $directoryUrl   = storage_path('/app/public/gigs/'.$gig_id);

                if ( !is_dir( $directoryUrl ) ) {
                    File::makeDirectory($directoryUrl, 0777, true);
                }

                $newFileName = 'post-'.$file.'.jpg';
                $newFilePath = storage_path('/app/public/gigs/'.$gig_id.'/');
                $fileInfo    = pathinfo($newFilePath.$newFileName);

                $i = 0;
				while (file_exists($newFilePath.$newFileName)) {
					$i++;
					$newFileName = $fileInfo["filename"] . "-" . $i . "." . $fileInfo["extension"];
				}

                File::copy($existFile, $newFilePath.$newFileName);
                $uploadedFilePath = 'gigs/'.$gig_id.'/'.$newFileName;

                $attachments['files'][time().'_'.$gig_id.$file] = (object) array(
                    'file_name' => $newFileName,
                    'file_path' => $uploadedFilePath,
                    'mime_type' => 'image/jpg',
                );
            }

            $gig['attachments'] = !empty($attachments) ? serialize($attachments) : null;
            $addrass = $addresses[rand(0,6)];
            $gigInfo = Gig::create([
                'author_id'         => $gig['author_id'],
                'title'             => $gig['title'],
                'slug'              => $gig['title'],
                'country'           => $addrass['country'],
                'zipcode'           => $addrass['zipcode'],
                'address'           => $addrass['address'],
                'description'       => json_encode($gig_desciption),
                'attachments'       => $gig['attachments'],
                'downloadable'      => $gig['downloadable'],
                'is_featured'       => $gig['is_featured'],
                'featured_expiry'   => $gig['featured_expiry'],
                'status'            => $gig['status'],
            ]);

            $gig_plans = [];
            foreach($gig_plan_list as $plan){

                $price = rand(450,650);
                if( $plan['title'] == 'Papular' ){
                    $price = rand(700,800);
                } elseif ( $plan['title'] == 'Premium') {
                    $price = rand(580,950);
                }

                $gig_plans[] = [
                    'gig_id'        => $gigInfo->id,
                    'title'         => $plan['title'],
                    'description'   => $plan['description'],
                    'price'         => $price,
                    'delivery_time' => $plan['delivery_time'],
                    'is_featured'   => $plan['is_featured'],
                    'options'       => $plan['options'],
                    'created_at'    => new DateTime(),
                    'updated_at'    => new DateTime(),
                ];
            }
            GigPlan::insert($gig_plans);

            // insert categories
            $gig_category_link = [];
            foreach($gig['gig_category_link'] as $plan){
                $gig_category_link[] = [
                    'gig_id'            => $gigInfo->id,	
                    'category_id'       => $plan['category_id'],	
                    'category_level'    => $plan['category_level'],
                    'created_at'        => new DateTime(),
                    'updated_at'        => new DateTime(),	
                ];
            }
            DB::table('gig_category_link')->insert($gig_category_link);

            // insert FAQs 
            $gig_faqs   =   [];
            foreach($gig_faq_list as $faq){
                $gig_faqs[] = [
                    'gig_id'        => $gigInfo->id,
                    'question'      => $faq['question'],
                    'answer'        => json_encode($faq['answer']),
                    'created_at'    => new DateTime(),
                    'updated_at'    => new DateTime(),	
                ];
            }
            
            GigFaq::insert($gig_faqs);
        }
    }
}
