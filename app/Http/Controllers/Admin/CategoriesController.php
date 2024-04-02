<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

    public function storeCategory (Request $request) {
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
}
