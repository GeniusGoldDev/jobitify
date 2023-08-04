<?php

namespace App\Models;

use App\Models\Search;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, Search;

    protected $guarded = [];
    protected $table = 'menu';

    protected $searchable = [
        'name',
        'location',
    ];


    /**
        * Get the menu_item of the menu.
    */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
