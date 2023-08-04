<?php

namespace App\Http\Livewire\Components;

use App\Models\Taxonomies\ProjectCategory;
use Livewire\Component;

class CategoryDropdown extends Component
{
    public $categoryId;
    public $category_name;
    public $label_text, $is_required, $has_error = false;
    public $listeners = [ 'updateCategroyId' => 'selectCategory', 'updatecategoryList' => 'getCategoriesTreeProperty', 'validateError'];
    public $categoriesTree;

    public function render()
    {
        if( empty($this->category_name)){
            $this->category_name = __('general.select');
        }

        $categories_tree = $this->CategoriesTree;
        return view('livewire.components.category-dropdown', compact( 'categories_tree' ));
    }
    
    public function getCategoriesTreeProperty(){
       return ProjectCategory::tree()->get()->toTree();
    }

    public function mount($categroy_id, $label_text, $is_required){
        $this->selectCategory($categroy_id);
        $this->label_text = $label_text;
        $this->is_required = $is_required;
    }

    public function selectCategory($id){
        $category_name =  ProjectCategory::where('id', $id)->pluck('name')->first();
        if($category_name){
            $this->categoryId = $id;
            $this->category_name = $category_name;
        }  else {
            $this->categoryId = null;
            $this->category_name = __('general.select');
        }
    }

    public function updatedcategoryId($id){
        $this->emit('SelectCategoryId', $id);
        $this->selectCategory($id);
     }

    public function validateError($category_req){
        $this->has_error = $category_req;
    }

}
