<?php 

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class CommandRepo 
{
    /** 
     * Return all commands in database
     * @return array
     * @return bool
     */
    public function index () 
    {
        $commands = DB::select('select * from table_commands ');
        if($commands>0) return $commands;
        else return false;
    }



    /** 
     * Insert new command
     * @param array
     * @return boolean
     */
    public function store(array $data) 
    {
        if(sizeof($data) > 0)  {
            $insert = DB::insert('insert into table_commands (user_id, product_id, quantity, total, command_date) values (?, ?, ?, ?, ?)', $data);
            if($insert) return true;
            else return false;
        }
        else return false;
    }


    /** 
     * Edit command by id
     * @param Integer
     * @return array
     */
    public function edit (int $id)
    {
        $command = DB::select('select * from table_commands where id = ?', [$id]);
        if($command) return $command;
        else return false;
    }





    /** 
     * Update command by id
     * @param Array
     * @return boolean
     */
    public function update (array $data) 
    {
        if(sizeof($data) > 0) {
            $update = DB::update('update table_commands set quantity = ?, total = ?, command_date = ? where id = ?', $data);
            if($update) return true;
            else return false;
        }
        else return false;
    }


    /** 
     * Delete command by id
     * @param Integer
     * @return boolean
     */
    public function delete (int $id) 
    {
        $delete = DB::delete('delete from  commands where id = ?', [$id]);
        if($delete) return true;
        else return false;
    }
}