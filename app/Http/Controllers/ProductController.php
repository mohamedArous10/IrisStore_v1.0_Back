<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ProductRepo;

class ProductController extends Controller 
{


    /** 
     * Return all product in database
     * @param ProductRepo
     * @return JsonResponse
     */
    public function list (ProductRepo $repo) 
    {
        $products = $repo->index();
        if($products > 0) return response()->json(['products' => $products], 200);
        else return response()->json('empty database', 200);
    }   


    /** 
     * Edit product by id 
     * @param ProductRepo
     * @param Integer
     * @return JsonResponse
     */
    public function edit (ProductRepo $repo, int $id) 
    {
        $product = $repo->edit($id);
        if($product) return response()->json(['product' => $product], 200);
        else return response()->json('product not found', 200);
    }



    /** 
     * Insert new product
     * @param Request
     * @param ProductRepo
     * @return JsonResponse
     */
    public function store (Request $request, ProductRepo $repo) 
    {
        $validate = $this->validate($request, [
            'name' => 'required|min:2',
             'ref' => 'required|unique:table_products',
            'price' => 'required',
            'category_id' => 'required|min:1'
        ]);

        if($validate) {

            $imag_path = $this->fileUpload($request);
    
            $data = $request->all();
            $data['total'] = $data['price'] - $data['discount'];
            $data['image'] = $imag_path;
         
            $insert = $repo->store($data);
            if($insert) return response()->json('inserted with success', 200);
            else return response()->json('error on insert', 200);
        }
    }



    /** 
     * Update product by id 
     * @param Request
     * @param ProductRepo
     * @param Intger
     * @return JsonResponse
     */
    public function update (Request $request, ProductRepo $repo, int $id) 
    {
        $validate = $this->validate($request, [
            'name' => 'required|min:2',
            'ref' => 'required|unique:table_products,ref,'.$id,
           'price' => 'required',
           'category_id' => 'required|min:1'

        ]);

        if($validate) {

            $imag_path = $this->fileUpload($request);
            $data = $request->all();
            $data['total'] = $data['price'] - $data['discount'];
            $data['image'] = $imag_path;
            $data['id'] = $id;

            $update = $repo->update($data);
            if($update) return response()->json('updated with success', 200);
            else return response()->json('error on upload', 200);
        }
    }





    /** 
     * Delete product by id
     * @param ProductRepo
     * @param Integer
     * @return JsonResponse
     */
    public function delete (ProductRepo $repo, int $id) 
    {
        $delete = $repo->delete($id);
        if($delete) return response()->json('deleted with success', 200);
        else return response()->json('error on delete', 200);
    }




    /** 
     * Upload product image 
     */
    public function fileUpload($request) {


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = '/storage/images';
            $image->storeAs('public', $name);
            $image->move($destinationPath, $name);
            
            $img_destination =  'public/'.$name;
            return $img_destination;
        }
    }
}