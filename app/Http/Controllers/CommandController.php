<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\CommandRepo;
use DateTime;

class CommandController extends Controller 
{
    /** 
     * Return all commands in database
     * @param CommandRrepo
     * @return JsonRepsonse
     */
    public function list (CommandRepo $repo) 
    {
        $commands = $repo->index();
        if($commands) return response()->json(['commands' => $commands], 200);
        else return response()->json('empty database', 200);
    }


    /** 
     * Insert new command
     * @param CommandRepo
     * @param Request
     * @return JsonResponse
     */
    public function store(CommandRepo $repo, Request $request) 
    {
        $request['user_id'] = auth()->user()->id;

        $validate = $this->validate($request, [
            'product_id' => 'required', 
            'quantity' => 'required|min:1', 
            'total' => 'required'
        ]);

        $request['command_date'] = new DateTime('now');

        if($validate) {
            $insert = $repo->store($request->all());
            if($insert) return response()->json('inserted with success', 200);
            else return response()->json('error on insert', 200);
        }


    }


    /** 
     * Edit command by id 
     * @param CommandRepo
     * @param Integer
     * @return JsonResponse
     */
    public function edit (CommandRepo $repo, int $id) 
    {
        $command = $repo->edit($id);
        if($command) return response()->json(['command' => $command], 200);
        else return response()->json('not found', 404);
    }


    /** 
     * Update command by id
     * @param CommandRepo
     * @param Requset
     * @param Integer
     * @return JsonResponse
     */
    public function update (CommandRepo $repo, Request $request, int $id)
    {
        $validate = $this->validate($request, [
            'quantity' => 'required|min:1', 
            'total' => 'required'
        ]);

        if($validate) 
        {
            $data = $request->all();
            $data['id'] = $id;
            $update = $repo->update($data);
            if($update) return response()->json('updated with success', 200);
            else return response()->json('error on update', 200);
        }
    }


    /** 
     * Delete command by id
     * @param CommandRepo
     * @param Integer
     * @return JsonResponse
     */
    public function delete (CommandRepo $repo, int $id) {
        $delete = $repo->delete($id);
        if($delete) return response()->json('deleted with success', 200);
    }
}