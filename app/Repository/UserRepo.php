<?php 

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class UserRepo  {


    /**
     * @OA\Get(
     *   tags={"Tag"},
     *   path="path",
     *   summary="Insert new user ",
     *   @OA\Parameter(ref="#/components/parameters/id"),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */

     /**
      * @return Array
      * @return Null
      * Return list of users 
      */
    public function index ()  {

        // fetch users from database
        $users = DB::select('select * from table_users order by id desc');

        // verfiy records
        if($users > 0) {
            return $users;
        }
        else return null;

    }


    /** 
     * @param Array 
     * @return Boolean 
     */
    public function store ( array $data)  {
        if($data >0 ) {
           $data = array_values($data);

           $insert = DB::insert('insert into table_users (fullname, email, phone, password, address) values (?, ?, ?, ?, ?)', $data);
           if($insert) return true;
           else return false;
        }
    }

    /** 
     * @param int
     * @return array
     * @return bool
     */
    public function edit(int $id)
    {
        $user = DB::select('select * from table_users where id = ?', [$id]);
        if($user) return $user;
        else return false;
    }
    /**
     * @param Array
     * @return Boolean
     */
    public function update (array $data) {
        if(sizeof($data) >0) {
            $data = array_values($data);

            $update = DB::update('update table_users set fullname = ?, email =? , phone = ?, password= ?, address = ? where id = ?', $data);
            if($update) return true;
            else return false;
        }
    }
        
    /** 
     * @param Integer
     * @return bool
     */
    public function delete (int $id)  
    {   

        $delete = DB::delete('delete from table_users where id = ?', [$id]);
        if($delete) return true;
        else return false;
    }



}