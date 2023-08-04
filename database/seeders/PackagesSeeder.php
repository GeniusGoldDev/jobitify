<?php

namespace Database\Seeders;

use DateTime;
use App\Models\Package\Package;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPackages();
    }

    public function createPackages(){
        Package::truncate();
        $package_list = [
            'buyer' => [
                [
                    'title'         => 'Basic',
                    'slug'          => 'basic',
                    'price'         => '100',
                    'options'       => serialize([
                        'type'                  => 'day',
                        'duration'              => '30',
                        'posted_projects'       => '10',
                        'featured_projects'     => '5',
                        'project_featured_days' => '10',
                    ])
                ],
                [
                    'title'         => 'Gold',
                    'slug'          => 'gold',
                    'price'         => '200',
                    'options'       => serialize([
                        'type'                  => 'day',
                        'duration'              => '60',
                        'posted_projects'       => '20',
                        'featured_projects'     => '10',
                        'project_featured_days' => '20',
                    ])
                ],
                [
                    'title'         => 'Platinum',
                    'slug'          => 'platinum',
                    'price'         => '300',
                    'options'       => serialize([
                        'type'                  => 'day',
                        'duration'              => '90',
                        'posted_projects'       => '30',
                        'featured_projects'     => '50',
                        'project_featured_days' => '30',
                    ])
                ],
            ],
            'seller' => [
                [
                    'title'         => 'Basic',
                    'slug'          => 'basic',
                    'price'         => '100',
                    'options'       => serialize([
                        'type'                  => 'day',
                        'duration'              => '30',
                        'credits'               => '100',
                        'profile_featured_days' => '10',
                    ])
                ],
                [
                    'title'         => 'Gold',
                    'slug'          => 'gold',
                    'price'         => '200',
                    'options'       => serialize([
                        'type'                  => 'day',
                        'duration'              => '60',
                        'credits'               => '200',
                        'profile_featured_days' => '20',
                    ])
                ],
                [
                    'title'         => 'Platinum',
                    'slug'          => 'platinum',
                    'price'         => '300',
                    'options'       => serialize([
                        'type'                  => 'day',
                        'duration'              => '90',
                        'credits'               => '300',
                        'profile_featured_days' => '30',
                    ])
                ],
            ]
            ];

        
            $allPackages = [];

            foreach($package_list as $role => $packages){
                foreach($packages as $key => $package){
                    $allPackages[] = [
                        'title'         => $package['title'],
                        'slug'          => $package['slug'],
                        'price'         => $package['price'],
                        'role_id'       => $role == 'buyer' ? 2 : 3,
                        'options'       => $package['options'],
                        'image'         => serialize(uploadDemoImage( 'packages','package', 'package-'.( $key+1 ) .'.png')),
                        'status'        => 'active',
                        'created_at'    => new DateTime(),
                        'updated_at'    => new DateTime()
                    ];
                }
            }

            Package::insert($allPackages);

    }
}
