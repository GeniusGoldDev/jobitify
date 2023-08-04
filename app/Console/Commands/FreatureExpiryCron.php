<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\Console\Command;

class FreatureExpiryCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feature-expiry:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update feature_expiry date of user profiles and projects';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->removeProjectFeatureExpiry();
        $this->removeProfileFeatureExpiry();
    }

    public function removeProjectFeatureExpiry(){
        $projects = Project::where(['is_featured' => '1'])->whereNotNull('featured_expiry')
        ->whereDate('featured_expiry', '<' ,Carbon::now())->update([
            'is_featured' => '0'
        ]);
    }

    public function removeProfileFeatureExpiry(){
        $projects = Profile::where(['is_featured' => '1'])->whereNotNull('featured_expiry')
        ->whereDate('featured_expiry', '<' ,Carbon::now())->update([
            'is_featured' => '0'
        ]);
    }
}
