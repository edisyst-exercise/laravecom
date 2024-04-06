<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class AdminCategoriesList extends Component
{
    protected $listeners = [
        "updateCategoriesOrdering",
        "deleteCategory"
    ];

    public function updateCategoriesOrdering($positions)
    {
        foreach ($positions as $position) {
            $index = $positions[0];
            $newPosition = $positions[1];
            Category::where('id', $index)->update([
                'ordering' => $newPosition
            ]);
        }
        $this->showToastr('success', 'Aggiornato ordine delle categorie');
    }

    public function deleteCategory($category_id)
    {
        $category = Category::findOrFail($category_id);
        $path = "images/categories/";
        $image = $category->image;
        //CHECK IF CATEGORY HAS SUBCATEGORIES
        //DELETE CATEGORY IMAGE
        if (File::exists(public_path($path . $image)) ) {
            File::delete($path . $image);
        }
        //DELETE CATEGORY FROM DB
        $delete = $category->delete();

        if ($delete) {
            $this->showToastr('success', 'Categoria eliminata');
        } else {
            $this->showToastr('error', 'Non ho potuto eliminare la categoria');
        }
    }



    public function showToastr($type, $message)
    {
        return $this->dispatch('showToastr', [
            "type"      => $type,
            "message"   => $message,
        ]);
    }

    public function render()
    {
        return view('livewire.admin-categories-list', [
            'categories' =>Category::orderBy('ordering', 'asc')->get(),
            'subcategories' =>Subcategory::orderBy('ordering', 'asc')->get(),
        ]);
    }
}
