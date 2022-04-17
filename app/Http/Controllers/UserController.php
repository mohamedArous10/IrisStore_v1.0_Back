<?php

namespace App\Http\Controllers;

use App\Repository\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   /** 
    * Return All users from database
    *@param UserRepo
    * @return JsonResponse
    */
    public function list (UserRepo $repo) 
    {
        $users = $repo->index();
        if($users) return response()->json(['users' => $users], 200);
        else return response()->json('empty database', 200);
    }

    /** 
     * Insert new user into database
     * @param Request
     * @param UserRepo
     * @return JsonResponse
     */
    public function store (UserRepo $repo, Request $request) 
    {
        $validate = $this->validate($request, [
            'fullname' => 'required|min:2',
            'email' => 'required|email|unique:table_users',
            'phone' => 'required|min:8|unique:table_users',
             'password' => 'required|min:8', 
             'address' => 'required|min:5'
        ]);

        if($validate) {
            $request['password'] = Hash::make($request['password']);
            $insert = $repo->store($request->all());
            if($insert) return response()->json('inserted with success',200);
            else return response()->json('error on insert', 200);
        }

    }

    /** 
     * Edit user by id
     * @param Integer
     * @param UserRepo
     * @return JsonResponse
     */
    public function edit (UserRepo $repo, int $id) {
        
        $user = $repo->edit($id);
        if($user) return response()->json(['user' => $user], 200);
        else return response()->json('user not found', 404);
    }


    /** 
     * Update user by id
     * @param UserRepo
     * @param Request
     * @param Integer
     * @return JsonResponse
     */
    public function update (UserRepo $repo, Request $request, int $id) 
    {
        $validate = $this->validate($request, [
            'fullname' => 'required|min:2',
            'email' => 'required|email|unique:table_users,email,'.$id,
            'phone' => 'required|min:8|unique:table_users,phone,'.$id,
             'password' => 'required|min:8', 
             'address' => 'required|min:5'
        ]);
        $request['password'] = Hash::make($request['password']);
        $data = $request->all();
        $data['id'] = $id;
        if($validate) {
            $update = $repo->update($data);
            if($update) return response()->json('updated with success', 200);
            else return response()->json('error on update', 200);
        }
    }


    /** 
     * Delete user by id 
     * @param UserRepo
     * @param Integer
     * @return JsonResponse
     */
    public function delete (UserRepo $repo, int $id) 
    {
        $delete = $repo->delete($id);
        if($delete) return response()->json('deleted with success', 200);
        else return response()->json('error on delete', 200);
    }
}
