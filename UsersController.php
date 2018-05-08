<?php

namespace App\Http\Controllers;

use App\crud_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller{

    //create user
    public function create(Request $request){

        //validate fields
        //if fields don't have empty or null
        if(($request->name OR $request->email OR $request->telephone) == null){

            return redirect()->back()->with('error','Error! All fields are required.');

        }else{

            //create an object, get the information form and save the new user
            $new_user = new crud_users();
            $new_user->name = $request->name;
            $new_user->email = $request->email;
            $new_user->telephone = $request->telephone;
            $new_user->save();

            if($new_user){

                return redirect()->back()->with('success','Success! A new user was added ;).');

            }else{

                return redirect()->back()->with('error','Error! There was an error in record :/.');

            }

        }

    }

    //view edit user
    public function viewEdit($id){

        $user_pass = DB::select('SELECT * FROM users WHERE id = '.$id); //get the first user with this 'id'
        return view('modal-edit', compact('user_pass', $user_pass)); //redirect for the modal 'edit' with the values, there will be done the edition

    }

    //update user
    public function edit(Request $request){

        //validate fields
        //if fields don't have empty or null
        if(($request->name OR $request->email OR $request->telephone) == null){

            return redirect()->back()->with('error','Error! All fields are required.');

        }else{

            //query for update user
            $upt_user = crud_users::find($request->id)->update(['name'=>$request->name,'email'=>$request->email,'telephone'=>$request->telephone]);

            if($upt_user){

                return redirect()->back()->with('success','Success! User updated ;).');

            }else{

                return redirect()->back()->with('error','Error! There was an error in record :/.');

            }

        }

    }

    //delete user
    public function delete($id){

        //search for param and delete, if 'ok' return the message in view...
        $del_user = crud_users::find($id)->delete();

        if($del_user){

            return response()->json(array('status'=>'success'));

        }else{

            return response()->json(array('status'=>'danger','errorMessage'=>'Error! There was an error :/.'));

        }

    }

}
