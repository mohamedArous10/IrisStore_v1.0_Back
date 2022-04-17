<?php 

namespace App\Repository; 

use Illuminate\Support\Facades\DB;


class ProductRepo {


    /** 
     * Return list of products
     * @return array 
     * @return boolean
     */
    public function index () {
        $products = DB::select('select * from table_products');
        if($products) return $products;
        else return false;
    }


    /** 
     * Insert new product 
     * @param Array 
     * @return boolean
     */
    public function store (array $data) 
    {
        if(sizeof($data) > 0 ) {
            $data = array_values($data);
         
            $insert = DB::insert('insert into table_products (name, ref, price, discount, category_id , image, total) values (?, ?, ?, ?, ?, ?, ?)', $data);
            if($insert) return true;
            else return false;
        }
        else return false;
    }



    /** 
     * Edit product by id
     * @param Integer
     * @return Array
     */
    public function edit (int $id) 
    {
        $product = DB::select('select * from table_products where id = ?', [$id]);
        if($product > 0)  return $product;
        else return false;
    }


    /** 
     * Update product by id
     * @param Array
     * @return Boolean
     */
    public function update (array $data) {
        if(sizeof($data) > 0 ) {
            $data = array_values($data);
            $update = DB::update('update table_products set name = ?, ref = ? , price = ? , discount = ?,category_id = ?, image = ?,total =?  where id = ?', $data);
            if($update) return true;
            else return false;
        }
        else return false;
    }


    /** 
     * Delete product by id 
     * @param Integer
     * @return Boolean
     */
    public function delete (int $id) 
    {
        $delete = DB::delete('delete from table_products where id = ?', [$id]);
        if($delete) return true;
        else return false;
    }
}