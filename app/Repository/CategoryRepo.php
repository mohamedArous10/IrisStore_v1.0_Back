<?php 

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class CategoryRepo {

    /** 
     * Return list of categories
     * @return Array
     * @return Boolean
     */
    public function index () 
    {
        $categories = DB::select('select * from table_categories');

        if(sizeof($categories) > 0) return $categories;
        else return false;
    }


    /** 
     * Insert new category 
     * @param String
     * @return Boolean
     */
    public function store (string $name) 
    {
        if(!empty($name)) {
            $insert = DB::insert('insert into table_categories (name) values (?)', [$name]);
            if($insert) return true;
            else return false;
        }
        return false;
    }

    /** 
     * Edit category by id
     * @param Integer
     * @return Array
     * @return Boolean
     */
    public function edit (int $id) 
    {
        $category = DB::select('select * from table_categories where id = ?', [$id]);
        if($category) return $category;
        else return false;
    }

    /** 
     * Update category by id
     * @param Array 
     * @return boolean
     */
    public function update (array $data) 
    {
        $data = array_values($data);
        if(sizeof($data) > 0) {

            $update = DB::update('update table_categories set name = ?  where id = ?', $data);
            if($update) return true;
            else return false;
        }
        else return false;
    }


    /** 
     * @param Integer
     * @return Boolean
     */
    public function delete (int $id) {
        $delete = DB::delete('delete table_categories where id = ?', [$id]);
        if($delete) return true;
        else return false;
    }
}