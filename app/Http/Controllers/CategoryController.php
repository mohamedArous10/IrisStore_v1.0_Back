<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\CategoryRepo;

class CategoryController extends Controller 
{


    /** 
     * Return all categories in database
     * @param CategoryRepo
     * @return JsonResponse
     */
    public function list (CategoryRepo $repo) {
        $categories = $repo->index();
        if($categories > 0) return response()->json(['categories' => $categories] , 200);
        else return response()->json('empty database', 200);
    }



    /** 
     * Insert new category
     * @param CategoryRepo
     * @param Request
     * @return JsonResponse
     */
    public function store (CategoryRepo $repo, Request $request) 
    {
        $validate = $this->validate($request, [
            'name' => 'required|unique:table_categories',
        ]);

        if($validate) {
            $insert = $repo->store($request['name']);
            if($insert) return response()->json('inserted with success', 200);
            else return response()->json('error on insert', 200);
        }

    }


    /** 
     * Edit Category by id
     * @param CategoryRepo
     * @param Integer
     * @return JsonResponse
     */
    public function edit (CategoryRepo $repo, int $id) 
    {
        $category = $repo->edit($id);
        if($category) return response()->json(['category' => $category] ,200);
        else return response()->json('category not found', 200);
    }


    /** 
     * Update category by id
     * @param CategoryRepo
     * @param Request
     * @param Integer
     * @return JsonResponse
     */
    public function update (CategoryRepo $repo, Request $request, int $id) 
    {
        $validate = $this->validate($request, [
            'name' => 'required|unique:table_categories,name,'.$id,
        ]);

        if($validate)  {
            $data = $request->all();
            $data['id'] = $id;
            $update = $repo->update($data);
            if($update) return response()->json('updated with success', 200);
            else return response()->json('error on update', 200);
        }
    }

    /** 
     * Delete category by id
     * @param CategoryRepo 
     * @param Integer
     * @return JsonResponse
     */
    public function delete (CategoryRepo $repo, int $id) {
        $delete = $repo->delete($id);
        if($delete) return response()->json('deleted with success', 200);
        else return response()->json('error on delete', 200);
    }
}