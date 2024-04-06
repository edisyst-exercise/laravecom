<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoriesController extends Controller
{
    public function catSubcatList(Request $request)
    {
        $data = [
            'pageTitle' => "Categories Management",
        ];
        return view('back.pages.admin.cat-subcat-list', $data);
    }

    public function addCategory(Request $request)
    {
        $data = [
            'pageTitle' => "Add Category",
        ];
        return view('back.pages.admin.add-category', $data);
    }

    public function storeCategory (Request $request)
    {
        //VALIDATE
        $request->validate([
            'name'  => 'required|min:5|unique:categories,name',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg',
        ],[
            'name.required'  => ':Attribute is required',
            'name.min'       => ':Attribute must contain at least 5 chars',
            'name.unique'    => ':Attribute already exists',
            'image.required' => ':Attribute is required',
            'image.image'    => ':Attribute must be an image',
            'image.mimes'    => ':Attribute must be png,jpg,jpeg,svg',
        ]);
        //SAVE CATEGORY
        if ($request->hasFile('image')){
            $path = 'images/categories/';
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            if (!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path));
            }
            //UPLOAD CATEGORY IMAGE
            $upload = $file->move(public_path($path), $filename);

            if ($upload) {
                //SAVE CATEGORY INTO DB
                $category = new Category();
                $category->name = $request->name;
                $category->image = $filename;
                $saved = $category->save();

                if ($saved) {
                    return redirect()->route('admin.manage-categories.add-category')
                        ->with('success', 'Nuova categoria <b>' .ucfirst($request->name). '</b> inserita');
                } else {
                    return redirect()->route('admin.manage-categories.add-category')
                        ->with('fail', 'Non ho salvato la categoria. Riprova più tardi');
                }
//                return redirect()->route('admin.manage-categories.add-category')
//                    ->with('success', 'Nuova categoria inserita');
            } else {
                return redirect()->route('admin.manage-categories.add-category')
                    ->with('fail', 'Non son riuscito a caricare la foto');
            }
        }
    }

    public function editCategory(Request $request)
    {
        $id = $request->id;
        $category= Category::findOrFail($id);
        $data = [
            'pageTitle' => 'Edit Category',
            'category'  => $category,
        ];
        return view('back.pages.admin.edit-category', $data);
    }



    public function updateCategory(Request $request)
    {
        $id = $request->id;
        $category= Category::findOrFail($id);

        //VALIDATE
        $request->validate([
            'name'  => 'required|min:5|unique:categories,name,' .$id, //serve per poter salvare anche con lo stesso name
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
        ],[
            'name.required'  => ':Attribute is required',
            'name.min'       => ':Attribute must contain at least 5 chars',
            'name.unique'    => ':Attribute already exists',
//            'image.required' => ':Attribute is required',
            'image.image'    => ':Attribute must be an image',
            'image.mimes'    => ':Attribute must be png,jpg,jpeg,svg',
        ]);

        //UPDATE CATEGORY INFO
        $category->name = $request->name;
        $category->slug = null;
        $saved = $category->save();

        //UPDATE IMAGE CATEGORY
        if ($request->hasFile('image')){
            $path = 'images/categories/';
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $old_image = $category->image;

            //FORSE QUESTO LO POSSO LASCIARE PER GESTIRE IL CASO IN CUI UNA CATEGORIA NON ABBIA IMAGE IN CREAZIONE
//            if (!File::exists(public_path($path))) {
//                File::makeDirectory(public_path($path));
//            }
            //UPDATE CATEGORY IMAGE
            $upload = $file->move(public_path($path), $filename);

            if ($upload) {
                //DELETE OLD IMAGE
                if (File::exists(public_path($path.$old_image))) {
                    File::delete(public_path($path.$old_image));
                }
                //SAVE CATEGORY INTO DB
                $category->image = $filename;
                $saved = $category->save();
            } else {
                return redirect()->route('admin.manage-categories.edit-category', ['id'=>$id])
                    ->with('fail', 'Non son riuscito a caricare la foto');
            }
        }

        //REDIRECT AFTER UPDATE CATEGORY
        if ($saved) {
            return redirect()->route('admin.manage-categories.edit-category', ['id'=>$id])
                ->with('success', 'La categoria <b>' .ucfirst($request->name). '</b> è stata modificata');
        } else {
            return redirect()->route('admin.manage-categories.add-category')
                ->with('fail', 'Non ho salvato la categoria. Riprova più tardi');
        }
    }

    public function addSubcategory(Request $request)
    {
        $independent_subcategories = Subcategory::where('is_child_of', 0)->get();
        $categories = Category::all();

        $data = [
            'pageTitle' => "Add Category",
            'categories' => $categories,
            'subcategories' => $independent_subcategories,
        ];

        return view('back.pages.admin.add-subcategory', $data);
    }

    public function storeSubcategory (Request $request)
    {
        //VALIDATE
        $request->validate([
            'name'             => 'required|min:5|unique:subcategories,name',
            'parent_category'  => 'required|exists:categories,id',
        ],[
            'name.required'  => ':Attribute is required',
            'name.min'       => ':Attribute must contain at least 5 chars',
            'name.unique'    => ':Attribute already exists',
            'parent_category.required'    => ':Attribute is required',
            'parent_category.exists'    => ':Attribute must exists in categories table',
        ]);

        //SAVE SUBCATEGORY INTO DB
        $subcategory = new Subcategory();
        $subcategory->name = $request->name;
        $subcategory->is_child_of = $request->is_child_of;
        $subcategory->category_id = $request->parent_category;
        $saved = $subcategory->save();

        if ($saved) {
            return redirect()->route('admin.manage-categories.add-subcategory')
                ->with('success', 'Nuova sottocategoria <b>' .ucfirst($request->name). '</b> inserita');
        } else {
            return redirect()->route('admin.manage-categories.add-subcategory')
                ->with('fail', 'Non ho salvato la sottocategoria. Riprova più tardi');
        }
    }



}
