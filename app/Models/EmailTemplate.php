<?php

namespace App\Models;

use App\Models\Search;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory, Search;
    protected $guarded =[];

    protected $searchable = [
        'title',
        'type',
        'role',
    ];
}
