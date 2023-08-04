<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class DefaultPageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $truncateValues = [
            'header-block', 'search-talent-block', 'categories-block', 
            'hiring-process-block', 'mobile-app-block', 'footer-block',
            'projects-block', 'opportunities-block', 'terms-condition-block',
            'user-feedback-block', 'professional-block', 'question-search-block',
            'send-question-block'];

        $removeDefaultValues = DB::table('site_settings')->whereIn('setting_type',$truncateValues)->delete();
        
       

        $defaultValues = [
            //---- Header section default setting --- \\
            array(
                'setting_type'  => 'header-block',
                'meta_key'      => 'heading',
                'meta_value'    => json_encode("<h1>Find The<span class='tk-yellow-clr'>Top 1% of Experts</span></h1>
                <strong>To Help Your Business <img src='/images/icons/hand-thumbnail.png' alt='image'> </strong>
                <p>Perspiciatis unde omnis iste natus onate error sit voluptatem accusantium dolore laudantium, totam rem aperiam, eaque ipsa quaeab.</p>"),
            ),
            array(
                'setting_type'  => 'header-block',
                'meta_key'      => 'form_title',
                'meta_value'    => "Explore top notch verified talents",
            ),
            array(
                'setting_type'  => 'header-block',
                'meta_key'      => 'form_content',
                'meta_value'    => "Sed ut perspiciaes undie omnis iste natus error sit voluptatem accusantium doloremque laudane totam",
            ),
            array(
                'setting_type'  => 'header-block',
                'meta_key'      => 'talent_btn_txt',
                'meta_value'    => "I need a talent ",
            ),
            array(
                'setting_type'  => 'header-block',
                'meta_key'      => 'work_btn_txt',
                'meta_value'    => "I’m looking for a work",
            ),
            
            array(
                'setting_type'  => 'header-block',
                'meta_key'      => 'counter_option',
                'meta_value'    => serialize(
                        array(
                        array('heading' => 'Service providers', 'content' => '17M+'),
                        array('heading' => 'User satifaction', 'content' => '98.77%'),
                        array('heading' => 'Recurring users', 'content' => '15.8M+'),
                    )
                ),
            ),
            array(
                'setting_type'  => 'header-block',
                'meta_key'      => 'after_btn_text',
                'meta_value'    => "Start from here",
            ),
            array(
                'setting_type'  => 'header-block',
                'meta_key'      => 'header_background',
                'meta_value'    => 'demo-content/header-background.jpg',
            ),
            //---- Header-v2 section default setting --- \\

            array(
                'setting_type'  => 'search-talent-block',
                'meta_key'      => 'title',
                'meta_value'    => 'We work as an extension to your idea to the reality',
            ),
            array(
                'setting_type'  => 'search-talent-block',
                'meta_key'      => 'sub_title',
                'meta_value'    => 'Our aim is to provide quality',
            ),
            array(
                'setting_type'  => 'search-talent-block',
                'meta_key'      => 'description',
                'meta_value'    => 'At vero eos et accusamus et iusto odio dignis etesimos ducimus quisteba blanditiis praesentium voluptatum deleniti atque.',
            ),
            array(
                'setting_type'  => 'search-talent-block',
                'meta_key'      => 'search_btn_txt',
                'meta_value'    => 'Search a best talent',
            ),
            array(
                'setting_type'  => 'search-talent-block',
                'meta_key'      => 'main_image',
                'meta_value'    => 'demo-content/team.png',
            ),
            array(
                'setting_type'  => 'search-talent-block',
                'meta_key'      => 'card_image',
                'meta_value'    => 'demo-content/card-image.png',
            ),

            //---- Category section default setting --- \\
            array(
                'setting_type'  => 'categories-block',
                'meta_key'      => 'title',
                'meta_value'    => "Let’s make a quick start today",
            ),
            array(
                'setting_type'  => 'categories-block',
                'meta_key'      => 'sub_title',
                'meta_value'    => "Explore our popular categories",
            ),
            array(
                'setting_type'  => 'categories-block',
                'meta_key'      => 'description',
                'meta_value'    => "Atmvero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis aesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sintecti cupiditate non providente",
            ),
            array(
                'setting_type'  => 'categories-block',
                'meta_key'      => 'explore_btn_txt',
                'meta_value'    => "Explore all categories",
            ),

            //---- Hiring process section default setting --- \\
            array(
                'setting_type'  => 'hiring-process-block',
                'meta_key'      => 'heading',
                'meta_value'    => json_encode("<h2>We’re making <span class='tk-yellow-clr'>#hiring process</span> impossible to possible</h2>"),
            ),
            array(
                'setting_type'  => 'hiring-process-block',
                'meta_key'      => 'description',
                'meta_value'    => "Atmvero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis aesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sintecti cupiditate non providente",
            ),
            array(
                'setting_type'  => 'hiring-process-block',
                'meta_key'      => 'talent_btn_txt',
                'meta_value'    => "I need a talent",
            ),
            array(
                'setting_type'  => 'hiring-process-block',
                'meta_key'      => 'video_link',
                'meta_value'    => "https://youtu.be/8OCo08d3VJA",
            ),
            array(
                'setting_type'  => 'hiring-process-block',
                'meta_key'      => 'work_btn_txt',
                'meta_value'    => "I’m looking for a work",
            ),
            array(
                'setting_type'  => 'hiring-process-block',
                'meta_key'      => 'hiring_process_bg',
                'meta_value'    => 'demo-content/hiring-process-bg.jpg',
            ),
            //---- Mobile-app section default setting --- \\
            array(
                'setting_type'  => 'mobile-app-block',
                'meta_key'      => 'heading',
                'meta_value'    => json_encode("<div class='tk-maintitle-two'><span>Take your work on the move</span><h2> <span>Enjoy</span> #ultimate experience</h2></div>"),
            ),
            array(
                'setting_type'  => 'mobile-app-block',
                'meta_key'      => 'description',
                'meta_value'    => "Atmvero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis esentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sintecti cupiditate non providente lorakete animatem.",
            ),
            array(
                'setting_type'  => 'mobile-app-block',
                'meta_key'      => 'app_store_img',
                'meta_value'    => 'demo-content/ios.png',
            ),
            array(
                'setting_type'  => 'mobile-app-block',
                'meta_key'      => 'app_store_url',
                'meta_value'    => '#',
            ),
            array(
                'setting_type'  => 'mobile-app-block',
                'meta_key'      => 'play_store_img',
                'meta_value'    => 'demo-content/android.png',
            ),
            array(
                'setting_type'  => 'mobile-app-block',
                'meta_key'      => 'play_store_url',
                'meta_value'    => '#',
            ),
            array(
                'setting_type'  => 'mobile-app-block',
                'meta_key'      => 'short_desc',
                'meta_value'    => 'This app is compatible with android and iOS devices',
            ),
            array(
                'setting_type'  => 'mobile-app-block',
                'meta_key'      => 'mobile_app_image',
                'meta_value'    => 'demo-content/users.png',
            ),
            array(
                'setting_type'  => 'mobile-app-block',
                'meta_key'      => 'mobile_app_bg',
                'meta_value'    => 'demo-content/mobile-background.jpg',
            ),

            //---- Footer section default setting --- \\
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'description',
                'meta_value'    => 'Similique sunt in culpa qui officia deserunt mala animie idest laborum dolorum fuga harum quidem.',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'logo_image',
                'meta_value'    => 'demo-content/taskup-logo.png',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'mobile_app_heading',
                'meta_value'    => 'Get our mobile app',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'app_store_img',
                'meta_value'    => 'demo-content/ios.png',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'app_store_url',
                'meta_value'    => '#',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'play_store_img',
                'meta_value'    => 'demo-content/android.png',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'play_store_url',
                'meta_value'    => '#',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'category_heading',
                'meta_value'    => 'Top rated categories',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'no_of_category',
                'meta_value'    => '9',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'newsletter_heading',
                'meta_value'    => 'Signup for newsletter',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'phone',
                'meta_value'    => '+00 000 00000000',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'phone_call_availablity',
                'meta_value'    => '(Mon to Sun 9am - 11pm)',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'email',
                'meta_value'    => 'hello@youremailid.co.uk',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'fax',
                'meta_value'    => '+00 000 00000000',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'whatsapp',
                'meta_value'    => '(+00)0 00 00 0000',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'whatsapp_call_availablity',
                'meta_value'    => '(Mon to Sun 9am - 11pm)',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'facebook_link',
                'meta_value'    => 'https://www.facebook.com/',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'twitter_link',
                'meta_value'    => 'https://twitter.com',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'linkedin_link',
                'meta_value'    => 'https://www.linkedin.com/',
            ),
            array(
                'setting_type'  => 'footer-block',
                'meta_key'      => 'dribbble_link',
                'meta_value'    => 'https://dribbble.com/',
            ),
            //---- Footer section default setting --- \\
            array(
                'setting_type'  => 'projects-block',
                'meta_key'      => 'sub_title',
                'meta_value'    => 'Want to start working?',
            ),
            array(
                'setting_type'  => 'projects-block',
                'meta_key'      => 'title',
                'meta_value'    => 'Apply the top rated projects',
            ),
            array(
                'setting_type'  => 'projects-block',
                'meta_key'      => 'explore_btn_txt',
                'meta_value'    => 'Explore all projects',
            ),
            //---- Opportunities section default setting --- \\
            array(
                'setting_type'  => 'opportunities-block',
                'meta_key'      => 'title',
                'meta_value'    => 'Making equal opportunities for everyone every time',
            ),
            array(
                'setting_type'  => 'opportunities-block',
                'meta_key'      => 'tagline_title',
                'meta_value'    => 'Why we’re different from other',
            ),
            array(
                'setting_type'  => 'opportunities-block',
                'meta_key'      => 'description',
                'meta_value'    => 'Accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores molestias excepturi occaecation.',
            ),
            array(
                'setting_type'  => 'opportunities-block',
                'meta_key'      => 'join_us_btn_txt',
                'meta_value'    => 'Join us today',
            ),
            array(
                'setting_type'  => 'opportunities-block',
                'meta_key'      => 'display_image',
                'meta_value'    => 'demo-content/oportuninty.jpg',
            ),
            array(
                'setting_type'  => 'opportunities-block',
                'meta_key'      => 'points',
                'meta_value'    => serialize( array(
                    "Accusantium doloremque laudantium totam rem aperiam.",
                    "Eaque ipsa quae ab illo inventore veritatis et quasi architecton",
                    "Eicta sunt explicaboemo enim ipsam voluptatemuia",
                )),
            ),
            //---- Terms and condition section default setting --- \\
            array(
                'setting_type'  => 'terms-condition-block',
                'meta_key'      => 'page_content',
                'meta_value'    => json_encode('
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tk-project-holder">
                                    <div class="tk-project-head">
                                        <h3>Standard terms and conditions</h3>
                                    </div>
                                    <div class="tk-project-title">
                                        <h4>Why we need this page?</h4>
                                    </div>
                                    <div class="tk-jobdescription">
                                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi eiccaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis estmiet expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnislor ndus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaquerum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat</p>
                                        <p> Dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi occaecati cupiditate non provident, milique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobisat estndi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem ibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hetene asapiente delectusat uteit reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat</p>                        
                                    </div>
                                </div>
                                <div class="tk-project-holder">
                                    <div class="tk-project-title">
                                        <h4>Is it effective to have this general content?</h4>
                                    </div>
                                    <div class="tk-jobdescription">
                                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi eiccaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis estmiet expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnislor ndus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaquerum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat</p>
                                        <ul class="tk-jobdescription_list">
                                            <li>Et harum quidem rerum facilis est et expedita distinctio nam libero tempore cum soluta nobis est eligendi </li>
                                            <li>Eoptio cumque nihil impedit quo minus id quod maxime placeat facere possimus omnis voluptas </li>
                                            <li>Assumenda est omnis dolor ndus temporibus autem quibusdam et aut officiis debitis auterum necessitatibus</li>
                                            <li>Saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae etaque earum rerum</li>
                                            <li>Tenetur a sapiente delectus ut aut reiciendis voluptatibus maiores alias consequature </li>
                                            <li>Perferendis doloribus asperiores repellat</li>
                                        </ul>
                                        <p> Dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi occaecati cupiditate non provident, milique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobisat estndi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem ibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hetene asapiente delectusat uteit reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                '
                ),
            ),
            //---- user reviews section default setting --- \\
            array(
                'setting_type'  => 'user-feedback-block',
                'meta_key'      => 'sub_title',
                'meta_value'    => 'Why we’re different from other',
            ),
            array(
                'setting_type'  => 'user-feedback-block',
                'meta_key'      => 'title',
                'meta_value'    => 'See what our customers saying',
            ),
            array(
                'setting_type'  => 'user-feedback-block',
                'meta_key'      => 'description',
                'meta_value'    => 'Atmvero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis aesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sintecti cupiditate non providente',
            ),
            array(
                'setting_type'  => 'user-feedback-block',
                'meta_key'      => 'feedback_bg',
                'meta_value'    => 'demo-content/user-feedback_bg.jpg',
            ),
            array(
                'setting_type'  => 'user-feedback-block',
                'meta_key'      => 'feedback_users',
                'meta_value'    => serialize(
                    array(
                        array(
                            'image'         => 'demo-content/about-us/img-02.png', 
                            'name'          => 'Erik Gross', 
                            'address'       => 'New York, GA',
                            'rating'        => '5',
                            'description'   => '“Nemo enim ipsam voluptatem quia voluptas sitaes aspernatur aut odit aut fugite.”',
                        ),
                        array(
                            'image'         => 'demo-content/about-us/img-01.png', 
                            'name'          => 'Andre Schmidt', 
                            'address'       => 'Albuquerque, CA',
                            'rating'        => '5',
                            'description'   => '“Nemo enim ipsam voluptatem quia voluptas sitaes aspernatur aut odit aut fugite.”',
                        ),
                        array(
                            'image'         => 'demo-content/about-us/img-07.png', 
                            'name'          => 'Irene Jacobs', 
                            'address'       => 'San Diego, OK',
                            'rating'        => '5',
                            'description'   => '“Nemo enim ipsam voluptatem quia voluptas sitaes aspernatur aut odit aut fugite.”',
                        ),
                        array(
                            'image'         => 'demo-content/about-us/img-02.png', 
                            'name'          => 'Erik Gross', 
                            'address'       => 'New York, GA',
                            'rating'        => '5',
                            'description'   => '“Nemo enim ipsam voluptatem quia voluptas sitaes aspernatur aut odit aut fugite.”',
                        ),
                    )
                ),
            ),
            //---- user professional section default setting --- \\
            array(
                'setting_type'  => 'professional-block',
                'meta_key'      => 'sub_title',
                'meta_value'    => 'Meet our ever green minds',
            ),
            array(
                'setting_type'  => 'professional-block',
                'meta_key'      => 'title',
                'meta_value'    => 'See what our customers saying',
            ),
            array(
                'setting_type'  => 'professional-block',
                'meta_key'      => 'description',
                'meta_value'    => 'Atmvero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis aesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sintecti cupiditate non providente',
            ),
            array(
                'setting_type'  => 'professional-block',
                'meta_key'      => 'team_members',
                'meta_value'    => serialize(
                    array(
                        array(
                            'image'          => 'demo-content/about-us/img-03.jpg', 
                            'name'           => 'Erik Gross', 
                            'designation'    => 'New York, GA',
                            'facebook_link'  => '#',
                            'twitter_link'   => '#',
                            'linkedin_link'  => '#',
                            'twitch_link' => '#',
                            'dribbble_link'  => '#',
                        ),
                        array(
                            'image'          => 'demo-content/about-us/img-04.jpg', 
                            'name'           => 'Francisco Armstrong', 
                            'designation'    => 'Marketing specialist',
                            'facebook_link'  => '#',
                            'twitter_link'   => '#',
                            'linkedin_link'  => '#',
                            'twitch_link' => '#',
                            'dribbble_link'  => '#',
                        ),
                        array(
                            'image'          => 'demo-content/about-us/img-05.jpg', 
                            'name'           => 'Monica Schwartz', 
                            'designation'    => 'Floor manager',
                            'facebook_link'  => '#',
                            'twitter_link'   => '#',
                            'linkedin_link'  => '#',
                            'twitch_link' => '#',
                            'dribbble_link'  => '#',
                        ),
                        array(
                            'image'          => 'demo-content/about-us/img-06.jpg', 
                            'name'           => 'Nathan Hudson', 
                            'designation'    => 'Content manager',
                            'facebook_link'  => '#',
                            'twitter_link'   => '#',
                            'linkedin_link'  => '#',
                            'twitch_link' => '#',
                            'dribbble_link'  => '#',
                        ),
                        
                    )
                ),
            ),

            //---- Question search section default setting --- \\
            array(
                'setting_type'  => 'question-search-block',
                'meta_key'      => 'sub_title',
                'meta_value'    => 'Have question in mind?',
            ),
            array(
                'setting_type'  => 'question-search-block',
                'meta_key'      => 'title',
                'meta_value'    => 'Search from our common FAQs',
            ),
            array(
                'setting_type'  => 'question-search-block',
                'meta_key'      => 'description',
                'meta_value'    => 'Atmvero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis aesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sintecti cupiditate non providente',
            ),
            array(
                'setting_type'  => 'question-search-block',
                'meta_key'      => 'list_title',
                'meta_value'    => "General inquiries FAQ's",
            ),
            array(
                'setting_type'  => 'question-search-block',
                'meta_key'      => 'question_list',
                'meta_value'    => serialize(
                    array(
                        array(
                            'question'  => 'Will I be charged for an exchange?',
                            'answer'    => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi idames est laborum etnale dolorum fuga rerum faciliste. <br> Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possi aermus omnistae voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam etmiaut officiis debitis auit rerum cessitatibue saepe evenietiu et voluptates repudiandae sint etemolestiae nocusandae www.domainurl447.com Itaque earum rerum hic tenetur a sapiente delectus, ut autme reiciendis voluptatibus maiores alias consequatur aeut perferendis doloribus asperiores repellate.',
                        ),
                        array(
                            'question'  => 'What are the returns and exchange requirements?',
                            'answer'    => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi idames est laborum etnale dolorum fuga rerum faciliste. <br> Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possi aermus omnistae voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam etmiaut officiis debitis auit rerum cessitatibue saepe evenietiu et voluptates repudiandae sint etemolestiae nocusandae www.domainurl447.com Itaque earum rerum hic tenetur a sapiente delectus, ut autme reiciendis voluptatibus maiores alias consequatur aeut perferendis doloribus asperiores repellate.',
                        ),
                        array(
                            'question' => 'Do I have to pay customs fees or duty on my package?',
                            'answer'    => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi idames est laborum etnale dolorum fuga rerum faciliste. <br> Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possi aermus omnistae voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam etmiaut officiis debitis auit rerum cessitatibue saepe evenietiu et voluptates repudiandae sint etemolestiae nocusandae www.domainurl447.com Itaque earum rerum hic tenetur a sapiente delectus, ut autme reiciendis voluptatibus maiores alias consequatur aeut perferendis doloribus asperiores repellate.',
                        ),
                        array(
                            'question' => 'Where can I change or cancel my order?',
                            'answer'    => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi idames est laborum etnale dolorum fuga rerum faciliste. <br> Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possi aermus omnistae voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam etmiaut officiis debitis auit rerum cessitatibue saepe evenietiu et voluptates repudiandae sint etemolestiae nocusandae www.domainurl447.com Itaque earum rerum hic tenetur a sapiente delectus, ut autme reiciendis voluptatibus maiores alias consequatur aeut perferendis doloribus asperiores repellate.',
                        ),
                        array(
                            'question'  => 'Are there any return exclusions?',
                            'answer'    => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi idames est laborum etnale dolorum fuga rerum faciliste. <br> Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possi aermus omnistae voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam etmiaut officiis debitis auit rerum cessitatibue saepe evenietiu et voluptates repudiandae sint etemolestiae nocusandae www.domainurl447.com Itaque earum rerum hic tenetur a sapiente delectus, ut autme reiciendis voluptatibus maiores alias consequatur aeut perferendis doloribus asperiores repellate.',
                        ),
                    ),
                )
            ),
            //---- user professional section default setting --- \\
            array(
                'setting_type'  => 'send-question-block',
                'meta_key'      => 'sub_title',
                'meta_value'    => 'Did’nt find your question here?',
            ),
            array(
                'setting_type'  => 'send-question-block',
                'meta_key'      => 'title',
                'meta_value'    => 'Send us your question now',
            ),
            array(
                'setting_type'  => 'send-question-block',
                'meta_key'      => 'description',
                'meta_value'    => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditis aesentium voluptatum deleniti atque lorakes mishiumes anakitum',
            ),
            array(
                'setting_type'  => 'send-question-block',
                'meta_key'      => 'submit_btn_txt',
                'meta_value'    => 'Submit your question',
            ),
        ];
        
        foreach($defaultValues as $value){
            $insert = SiteSetting::create($value);
        }
    }
}
