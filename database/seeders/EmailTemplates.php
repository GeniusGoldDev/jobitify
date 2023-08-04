<?php

namespace Database\Seeders;

use DateTime;
use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setEmailTemplates();
    }

    public function setEmailTemplates(){
        EmailTemplate::truncate();
        $emailTemplates = getEmailTemplates();
        $template_list  = [];
        
        foreach($emailTemplates as $key => $record){
            $template = $content    = [];
            $template['type']       = $key;
            $template['status']     = 'active';
            $template['title']      = $record['title'];
            
            foreach($record['roles'] as $role => $fields){
                $template['role'] = $role;
                foreach($fields['fields'] as $variable => $single){
                    if($variable != 'info'){
                        $content[$variable] = str_ireplace('<br>', "\r\n", $single['default']);
                    }
                }
                $template['content'] = serialize($content);
                $template['created_at'] = new DateTime();
                $template['updated_at'] = new DateTime();
                $template_list[] = $template;
            }

        }
        
        EmailTemplate::insert($template_list);
    }
}
