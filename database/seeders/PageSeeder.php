<?php

namespace Database\Seeders;

use App\Models\SitePage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        SitePage::truncate();

        $pages = [
            [
                'name'      => __('pages.home_page'),
                'title'     => __('pages.home_page_title'),
                'route'     => null,
                'settings'  => json_encode([
                    [
                        "block_id"  => "top-menu-block",
                        "css"       => [],
                        "settings"  => [],
                    ],
                    [
                        "block_id"  => "header-block",
                        "css"       => [],
                        "settings"  => [],
                    ],
                    [
                        "block_id"  => "categories-block",
                        "css"       => [],
                        "settings"  => [
                            "title"             => "Let’s make a quick start today",
                            "sub_title"         => "Explore our popular categories",
                            "explore_btn_txt"   => "Explore all categories",
                            "description"       => "Atmvero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis aesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sintecti cupiditate non providente",
                            "category_ids"      => [ 1, 7, 18, 26, 5, 15, 23, 29 ],
                        ]
                    ],
                    [
                        "block_id"  => "mobile-app-block",
                        "css"       => [],
                        "settings"  => [],
                    ],
                    [
                        "block_id"  => "projects-block",
                        "css"       => [],
                        "settings"  => [
                            "sub_title"         => "Want to start working?",
                            "title"             => "Apply the top rated projects",
                            "explore_btn_txt"   => "Explore all projects",
                            "project_ids"       => [1, 3, 9, 13, 14],
                        ],
                    ],
                    [
                        "block_id"  => "hiring-process-block",
                        "css"       => [],
                        "settings"  => [],
                    ],
                    [
                        "block_id"      => "opportunities-block",
                        "css"           => [
                            'custom_class'  => 'tk-opportunity-main',
                        ],
                        "settings"      => [],
                    ],
                    [
                        "block_id"  => "footer-block",
                        "css"       => [],
                        "settings"  => [
                            "description"               => "Similique sunt in culpa qui officia deserunt mala animie idest laborum dolorum fuga harum quidem.",
                            "mobile_app_heading"        => "Get our mobile app",
                            "app_store_img"             => "demo-content/ios.png",
                            "app_store_url"             => "#",
                            "play_store_img"            => "demo-content/android.png",
                            "logo_image"                => "demo-content/taskup-logo.png",
                            "play_store_url"            => "#",
                            "category_heading"          => "Top rated categories",
                            "category_ids"              => [ 1, 2, 3, 4, 5, 7, 8, 11, 15, 17 ],
                            "newsletter_heading"        => "Signup for newsletter",
                            "phone"                     => "+00 000 00000000",
                            "phone_call_availablity"    => "(Mon to Sun 9am - 11pm)",
                            "email"                     => "hello@youremailid.co.uk",
                            "fax"                       => "+00 000 00000000",
                            "whatsapp"                  => "(+00)0 00 00 0000",
                            "whatsapp_call_availablity" => "(Mon to Sun 9am - 11pm)",
                            "facebook_link"             => "https://www.facebook.com/",
                            "twitter_link"              => "https://twitter.com",
                            "linkedin_link"             => "https://www.linkedin.com/",
                            "dribbble_link"             => "https://dribbble.com/",
                        ]
                    ],
                ]),
                'status'    => 'publish',
            ],
            [
                'name'      => __('pages.aboutus_page'),
                'title'     => __('pages.aboutus_title'),
                'route'     => 'about-us',
                'settings'  => json_encode([
                    [
                        "block_id"      => "top-menu-block",
                        "css"           => [],
                        "settings"      => [],
                    ],
                    [
                        "block_id"      => "search-talent-block",
                        "css"           => [],
                        "settings"      => [],
                    ],
                    [
                        "block_id"      => "hiring-process-block",
                        "css"           => [],
                        "settings"      => [
                                                "heading"           => "<h2>We&rsquo;re making <span class='tk-yellow-clr'>#hiring process</span> impossible to possible</h2>",
                                                "description"       => "Atmvero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis aesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sintecti cupiditate non providente",
                                                "video_link"        => "https://youtu.be/8OCo08d3VJA",
                                                "talent_btn_txt"    => "I'm looking for a talent",
                                                "work_btn_txt"      => "I’m looking for a work",
                                                "hiring_process_bg" => "demo-content/hiring-process-bg.jpg",
                                            ]
                    ],
                    [
                        "block_id"      => "opportunities-block",
                        "css"           => [],
                        "settings"      => [],
                    ],
                    [
                        "block_id"      => "user-feedback-block",
                        "css"           => [],
                        "settings"      => [],
                    ],
                    [
                        "block_id"      => "professional-block",
                        "css"           => [],
                        "settings"      => [],
                    ],
                    [
                        "block_id"      => "footer-block",
                        "css"           => [],
                        "settings"      => [
                            "description"               => "Similique sunt in culpa qui officia deserunt mala animie idest laborum dolorum fuga harum quidem.",
                            "mobile_app_heading"        => "Get our mobile app",
                            "app_store_img"             => "demo-content/ios.png",
                            "app_store_url"             => "#",
                            "play_store_img"            => "demo-content/android.png",
                            "logo_image"                => "demo-content/taskup-logo.png",
                            "play_store_url"            => "#",
                            "category_heading"          => "Top rated categories",
                            "category_ids"              => [ 1, 2, 3, 4, 5, 7, 8, 11, 15, 17 ],
                            "newsletter_heading"        => "Signup for newsletter",
                            "phone"                     => "+00 000 00000000",
                            "phone_call_availablity"    => "(Mon to Sun 9am - 11pm)",
                            "email"                     => "hello@youremailid.co.uk",
                            "fax"                       => "+00 000 00000000",
                            "whatsapp"                  => "(+00)0 00 00 0000",
                            "whatsapp_call_availablity" => "(Mon to Sun 9am - 11pm)",
                            "facebook_link"             => "https://www.facebook.com/",
                            "twitter_link"              => "https://twitter.com",
                            "linkedin_link"             => "https://www.linkedin.com/",
                            "dribbble_link"             => "https://dribbble.com/",
                        ]
                    ]
                ]),
                'status'    => 'publish',
            ],
            [
                'name'      => __('pages.term_condition_page'),
                'title'     => __('pages.term_condition_title'),
                'route'     => 'terms-condition',
                'settings'  => json_encode([
                    [
                        "block_id"  => "top-menu-block",
                        "css"       => [],
                        "settings"  => [],
                    ],
                    [
                        "block_id"  => "terms-condition-block",
                        "css"       => [],
                        "settings"  => [],
                    ],
                    [
                        "block_id"      => "footer-block",
                        "css"           => [],
                        "settings"      => [
                            "description"               => "Similique sunt in culpa qui officia deserunt mala animie idest laborum dolorum fuga harum quidem.",
                            "mobile_app_heading"        => "Get our mobile app",
                            "app_store_img"             => "demo-content/ios.png",
                            "app_store_url"             => "#",
                            "play_store_img"            => "demo-content/android.png",
                            "logo_image"                => "demo-content/taskup-logo.png",
                            "play_store_url"            => "#",
                            "category_heading"          => "Top rated categories",
                            "category_ids"              => [ 1, 2, 3, 4, 5, 7, 8, 11, 15, 17 ],
                            "newsletter_heading"        => "Signup for newsletter",
                            "phone"                     => "+00 000 00000000",
                            "phone_call_availablity"    => "(Mon to Sun 9am - 11pm)",
                            "email"                     => "hello@youremailid.co.uk",
                            "fax"                       => "+00 000 00000000",
                            "whatsapp"                  => "(+00)0 00 00 0000",
                            "whatsapp_call_availablity" => "(Mon to Sun 9am - 11pm)",
                            "facebook_link"             => "https://www.facebook.com/",
                            "twitter_link"              => "https://twitter.com",
                            "linkedin_link"             => "https://www.linkedin.com/",
                            "dribbble_link"             => "https://dribbble.com/",
                        ]
                    ]
                ]),
                'status'    => 'publish',
            ],
            [
                'name'      => __('pages.faq_page'),
                'title'     => __('pages.faq_title'),
                'route'     => 'faq',
                'settings'  => json_encode([
                    [
                        "block_id"      => "top-menu-block",
                        "css"           => [],
                        "settings"      => [],
                    ],
                    [
                        "block_id"      => "question-search-block",
                        "css"           => [],
                        "settings"      => [],
                    ],
                    [
                        "block_id"      => "send-question-block",
                        "css"           => [],
                        "settings"      => [],
                    ],
                    [
                        "block_id"      => "footer-block",
                        "css"           => [],
                        "settings"  => [
                            "description"               => "Similique sunt in culpa qui officia deserunt mala animie idest laborum dolorum fuga harum quidem.",
                            "mobile_app_heading"        => "Get our mobile app",
                            "app_store_img"             => "demo-content/ios.png",
                            "app_store_url"             => "#",
                            "play_store_img"            => "demo-content/android.png",
                            "logo_image"                => "demo-content/taskup-logo.png",
                            "play_store_url"            => "#",
                            "category_heading"          => "Top rated categories",
                            "category_ids"              => [ 1, 2, 3, 4, 5, 7, 8, 11, 15, 17 ],
                            "newsletter_heading"        => "Signup for newsletter",
                            "phone"                     => "+00 000 00000000",
                            "phone_call_availablity"    => "(Mon to Sun 9am - 11pm)",
                            "email"                     => "hello@youremailid.co.uk",
                            "fax"                       => "+00 000 00000000",
                            "whatsapp"                  => "(+00)0 00 00 0000",
                            "whatsapp_call_availablity" => "(Mon to Sun 9am - 11pm)",
                            "facebook_link"             => "https://www.facebook.com/",
                            "twitter_link"              => "https://twitter.com",
                            "linkedin_link"             => "https://www.linkedin.com/",
                            "dribbble_link"             => "https://dribbble.com/",
                        ]
                    ]
                ]),
                'status' => 'publish',
            ],
        ];

        foreach ($pages as $key => $value) {
            SitePage::create($value);
        }
    }
}
