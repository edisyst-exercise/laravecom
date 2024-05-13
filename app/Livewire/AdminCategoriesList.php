<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoriesList extends Component
{
    use WithPagination;

    public $categoriesPerPage = 5;
    public $subcategoriesPerPage = 3;

    protected $listeners = [
        "updateCategoriesOrdering",
        "deleteCategory",
        "updateSubcategoriesOrdering",
        "updateChildSubcategoriesOrdering",
        "deleteSubcategory",
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
    public function updateSubcategoriesOrdering($positions)
    {
        foreach ($positions as $position) {
            $index = $positions[0];
            $newPosition = $positions[1];
            Subcategory::where('id', $index)->update([
                'ordering' => $newPosition
            ]);
        }
        $this->showToastr('success', 'Aggiornato ordine delle sottocategorie');
    }
    public function updateChildSubcategoriesOrdering($positions)
    {
        foreach ($positions as $position) {
            $index = $positions[0];
            $newPosition = $positions[1];
            Subcategory::where('id', $index)->update([
                'ordering' => $newPosition
            ]);
        }
        $this->showToastr('success', 'Aggiornato ordine delle sottocategorie figlie');
    }

    public function deleteCategory($category_id)
    {
        $category = Category::findOrFail($category_id);
        $path = "images/categories/";
        $image = $category->image;

        //CHECK IF CATEGORY HAS SUBCATEGORIES
        if ($category->subcategories->count() > 0) {
            // Check if there are products related to any subcategories

            // Delete sub categories
            foreach ($category->subcategories as $subcategory) {
                $subcategory = Subcategory::findOrFail($category->id);
                $subcategory->delete();
            }
        }

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
    public function deleteSubcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);

        //Check if the subcategory has childs and delete them
        if ($subcategory->children->count() > 0) {
            // Check if there are products related to any childs

            // If no products are related to child subcategories, delete them
            foreach ($subcategory->children as $child) {
                Subcategory::where('id', $child->id)->delete();
            }

            // Delete subcategory
            $subcategory->delete();
            $this->showToastr('success', 'Sottocategoria eliminata');

        } else {
            // Check if there are products related to this subcategory

            // Delete subcategory
            $subcategory->delete();
            $this->showToastr('success', 'Sottocategoria eliminata');
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
            'categories' => Category::orderBy('ordering', 'asc')
                ->paginate($this->categoriesPerPage, ['*'], 'categoriesPerPage'),
            'subcategories' => Subcategory::where('is_child_of', 0)->orderBy('ordering', 'asc')
                ->paginate($this->subcategoriesPerPage, ['*'], 'subcategoriesPerPage'),
        ]);
    }
}
