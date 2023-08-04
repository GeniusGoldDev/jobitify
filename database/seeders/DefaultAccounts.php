<?php

namespace Database\Seeders;
use File;
use DateTime;
use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
use App\Models\Education;
use Illuminate\Database\Seeder;
use App\Models\UserAccountSetting;
use Illuminate\Support\Facades\Hash;
use App\Models\Seller\SellerPortfolio;
use App\Models\Seller\SellerSocialLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultAccounts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDefaultRole();
        $this->createDefaultAccount();
    }


    public function createDefaultRole() {
        $roles = ['admin', 'buyer', 'seller'];
        foreach($roles as $role){
            $exist = Role::where( 'name', $role )->exists();
            if(!$exist){
                Role::create([
                    'name'          => $role,
                    'guard_name'    => 'web',
                ]);
            }
        }
    }

    public function createDefaultAccount() {

        User::truncate();
        Profile::truncate();
        Education::truncate();
        UserAccountSetting::truncate();
        SellerPortfolio::truncate();
        SellerSocialLink::truncate();

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

        $users = [
            'admin' => [
                [//1
                    'email'         => 'admin@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Admin',
                    'last_name'     => 'Admin',
                ]
            ],
            'buyer' => [
                [//2
                    'email'         => 'adolfo@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Swinney',
                    'last_name'     => 'Swinney',
                ],
                [//3
                    'email'         => 'anthony@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Anthony',
                    'last_name'     => 'Shao',
                ],
                [//4
                    'email'         => 'antony@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Antony',
                    'last_name'     => 'Clara',
                ],
                [//5
                    'email'         => 'arianne@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Arianne',
                    'last_name'     => 'Kearns',
                ],
                [//6
                    'email'         => 'ava@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Ava',
                    'last_name'     => 'Nguyen',
                ],
            ],
            'seller' => [
                [//7
                    'email'         => 'baker@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Georgia',
                    'last_name'     => 'Baker',
                    'tagline'       => 'I trust information techonology'
                ],
                [//8
                    'email'         => 'beau@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Beau',
                    'last_name'     => 'Simard',
                    'tagline'       => 'Endless possibilities with information techonology'
                ],
                [//9
                    'email'         => 'beverlee@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Beverlee',
                    'last_name'     => 'Bark',
                    'tagline'       => 'information techonology, the real thing'
                ],
                [//10
                    'email'         => 'chan@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Brooklyn',
                    'last_name'     => 'Chan',
                    'tagline'       => 'Endless possibilities with information techonology'
                ],
                [//11
                    'email'         => 'chapman@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Sarah',
                    'last_name'     => 'Chapman',
                    'tagline'       => 'information techonology, the real thing'
                ],
                [//12
                    'email'         => 'dewayne@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Dewayne',
                    'last_name'     => 'Beaudreau',
                    'tagline'       => 'Endless possibilities with information techonology'
                ],
                [//13
                    'email'         => 'dixon@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Judy',
                    'last_name'     => 'Dixon',
                    'tagline'       => 'information techonology, the real thing',
                ],
                [//14
                    'email'         => 'elizbeth@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Elizbeth',
                    'last_name'     => 'Quillen',
                    'tagline'       => "Wed desgin the time is now. Hope It's Wed desgin",
                ],
                [//15
                    'email'         => 'coleman@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Ann',
                    'last_name'     => 'Coleman',
                    'tagline'       => 'information techonology, the real thing'
                ],
                [//16
                    'email'         => 'filomena@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Filomena',
                    'last_name'     => 'Galicia',
                    'tagline'       => "Wed desgin the time is now. Hope It's Wed desgin",
                ],
                [//17
                    'email'         => 'ford@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Steven',
                    'last_name'     => 'Ford',
                    'tagline'       => 'Endless possibilities with information techonology'
                ],
                [//18
                    'email'         => 'gilberte@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Gilberte',
                    'last_name'     => 'Kreger',
                    'tagline'       => 'Endless possibilities with information techonology',
                ],
                [//19
                    'email'         => 'hunter@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Cynthia',
                    'last_name'     => 'Hunter',
                    'tagline'       => "Wed desgin the time is now. Hope It's Wed desgin",
                ],
                [//20
                    'email'         => 'Inocencia@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Inocencia',
                    'last_name'     => 'Langenfeld',
                    'tagline'       => 'information techonology, the real thing',
                ],
                [//21
                    'email'         => 'Isobel@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Isobel',
                    'last_name'     => 'Jones',
                    'tagline'       => 'Endless possibilities with information techonology',
                ],
                [//22
                    'email'         => 'James@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Louis',
                    'last_name'     => 'James',
                    'tagline'       => 'information techonology, the real thing'
                ],
            ],
        ];
        $seller_desc = "Nulla nisl sagittis, sed ulputate consequat pharetra. Leo mollis amet, duis elite musta nibhae quisque uate phaslus necerat scelerse. Sed turpis ullamcorper sed sit a vel pharetra porttitor odio non elit diam cursues Siet non, est curatur odion netus idsit enim consectur hendret mi, eget purus odio pellentes suspende. Sit nunc arcu vestibuum etarcu.\n\nCursus fringilla commodo id aliquam commodo nisle suspendisse aemetneta auctor nonate volutpat ante est tempus enim ipsam voluptatem quiaptas sit aspernatur aut odit aute fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porero quisquam est, qui dolorem ipsum quia dolor sit amet consectetur, adipisci velit, sed quia non numquam eiustam eidi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.\n\nRutrum exercitationem lacus sodales nesciunt hymenaeos explicabo taciti molestias fusce irure perferendis,eget purus odio pellentes suspende.";
        $buyer_desc  = "Rutrum exercitationem lacus sodales nesciunt hymenaeos explicabo taciti molestias fusce irure perferendis,eget purus odio pellentes suspende.";
        $user_languages     = [ 23, 4, 17, 33];
        $user_skills        = range(1, 14);


        $education_list = [
            [
                'deg_title'         => 'Web & Apps Project Manager',
                'deg_start_date'    => '2003-05-03',
                'deg_end_date'      => '2005-05-03',
                'is_ongoing'        => '0',
            ],
            [
                'deg_title'         => 'MBA - Hospital Management',
                'deg_start_date'    => '2010-12-02',
                'deg_end_date'      => '2012-12-02',
                'is_ongoing'        => '0',
            ],
            [
                'deg_title'         => 'BCS - Bachelor Computer Science',
                'deg_start_date'    => '2020-05-03',
                'deg_end_date'      => '2022-05-03',
                'is_ongoing'        => '0',
            ]
        ];

        $image_seq      = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22];
        $seller_types   = setting('_seller.seller_business_types');
        $sellerTypes    = !empty($seller_types) ? array_column($seller_types, 'business_types') : [];

        // Seller portfolios
        $portfolio_record = [
            [
                'title'         => 'Learn all about podcast from this politician.',
                'url'           => 'https://stackoverflow.com',
                'description'   =>  'Duis congue sollicitudin miatie molestie eitaim placerat egetoin diamuis tempuis acinar pretium euin ligula fermentum.',
            ],
            [
                'title'         => '7 things you should know about travel.',
                'url'           => 'https://www.wikipedia.org',
                'description'   => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'
            ],
            [
                'title'         => 'What will travel be like in the next 50 years?',
                'url'           => 'https://www.aliexpress.com',
                'description'   => 'Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature',
            ]
        ];
        $portfolio_iamge = [1,2,3];

        // seller social links
        $social_linsks = [
            [
                'name'  =>  'facebook',
                'url'   =>  'https://www.facebook.com',
            ],
            [
                'name'  =>  'linkedin',
                'url'   =>  'https://linkedin.com',
            ],
            [
                'name'  =>  'twitter',
                'url'   =>  'https://twitter.com'
            ],
            [
                'name'  =>  'dribbble',
                'url'   =>  'https://dribbble.com'
            ],
            [
                'name'  =>  'google',
                'url'   =>  'https://www.google.com',
            ],
            [
                'name'  =>  'twitch',
                'url'   =>  'https://www.twitch.tv'
            ],
            [
                'name'  =>  'instagram',
                'url'   =>  'https://www.instagram.com'
            ]
        ];

        foreach($users as $role_name => $accounts){
            foreach($accounts as $seq_no => $account){
            $checkAccount = User::where('email', $account['email'])->exists();
                if(!$checkAccount){
                    $user = User::create([
                        'email'             => sanitizeTextField($account['email']),
                        'password'          => Hash::make($account['password']),
                        'email_verified_at' => date("Y-m-d H:i:s"),
                        'status'            => 'activated',
                    ]);
                
                    $role_id = getRoleByName($role_name);
                    // create new profile with role
                    $checkprofile = Profile::where('user_id',$user->id)->exists();
                    $addrass = $addresses[rand(0,6)];
                    if(!$checkprofile){
    
                        $file           = $image_seq[$seq_no];
                        $existFile      = public_path().'/demo-content/users/avatar-'.$file.'.jpg';
                        $directoryUrl   = storage_path('/app/public/profiles');

                        if ( !is_dir( $directoryUrl ) ) {
                            File::makeDirectory($directoryUrl, 0777, true);
                        }

                        $newFileName = 'avatar-'.$file.'.jpg';
                        $newFilePath = storage_path('/app/public/profiles/');
                        $fileInfo    = pathinfo($newFilePath.$newFileName);

                        $i = 0;
                        while (file_exists($newFilePath.$newFileName)) {
                            $i++;
                            $newFileName = $fileInfo["filename"] . "-" . $i . "." . $fileInfo["extension"];
                        }

                        File::copy($existFile, $newFilePath.$newFileName);

                        $profile = Profile::create([
                            'user_id'       => $user->id,
                            'first_name'    => $account['first_name'],
                            'last_name'     => $account['last_name'],
                            'slug'          => strtolower($account['first_name'].' '.$account['last_name']),
                            'image'         => 'profiles/'.$newFileName,
                            'role_id'       => $role_id,
                            'tagline'       => !empty($account['tagline']) ? $account['tagline'] : null,
                            'description'   => $role_name == 'buyer' ? $buyer_desc : $seller_desc,
                            'country'       => $addrass['country'],
                            'zipcode'       => $addrass['zipcode'],
                            'address'       => $addrass['address'],
                            'seller_type'   => $sellerTypes[rand(1,6)],
                        ]);

                        $profile->skills()->select('id')->sync($user_skills);
                        $profile->languages()->select('id')->sync($user_languages);

                    }

                    $user->assignRole( $role_id );

                    if( in_array($role_name, ['buyer','seller']) ){
                        // create user account settings
                        $checkAccountSetting = UserAccountSetting::where('user_id',$user->id)->exists();
                        if(!$checkAccountSetting){
                            $UserAccountSetting = new UserAccountSetting();
                            $UserAccountSetting->hourly_rate    = rand(50,80);
                            $UserAccountSetting->verification   = 'approved';
                            $UserAccountSetting->user()->associate($user->id);
                            $UserAccountSetting->save();
                        }

                        if($role_name == 'seller'){
                            $education = [];
                            foreach( $education_list as $single ){
                                $education[] = [
                                    'profile_id'        => $profile->id,
                                    'deg_title'         => $single['deg_title'],
                                    'deg_institue_name' => 'Amento tech',
                                    'deg_description'   => 'Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquaenim ad minim veniamac quis nostrud exercitation ullamco laboris.',
                                    'deg_start_date'    => $single['deg_start_date'],
                                    'deg_end_date'      => $single['deg_end_date'],
                                    'is_ongoing'        => $single['is_ongoing'],
                                    'created_at'        => new DateTime(),
                                    'updated_at'        => new DateTime(),
                                ];
                            }

                            Education::insert($education);

                            // insert seller portfolios
                            foreach($portfolio_record as $index => $single){
                                $attachments    = [];
                                $image_detail   = uploadDemoImage('portfolios','portfolios', 'item-'.( $index + 1 ).'.jpg');
                                $attachments['files'][time().'_'.$index]  = (object) $image_detail; 
                                SellerPortfolio::create([
                                    'profile_id'    => $profile->id,
                                    'title'         => $single['title'],
                                    'url'           => $single['url'],
                                    'description'   => $single['description'],
                                    'attachments'   => serialize($attachments),
                                ]);
                            }

                            // insert social links
                            $records    = [];
                            foreach($social_linsks as $link){
                                $records[] = [
                                    'profile_id'    => $profile->id,
                                    'name'          => $link['name'],
                                    'url'           => $link['url'],
                                    'created_at'    => new DateTime(),
                                    'updated_at'    => new DateTime(),
                                ];
                            }
                            SellerSocialLink::insert($records);
                        }
                    }
                }
            }
        }
    }
}
