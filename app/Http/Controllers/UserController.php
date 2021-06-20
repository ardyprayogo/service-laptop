<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DataTables;

class UserController extends Controller
{
    //

    public function __construct(User $user) {
        $this->model = $user;
    }

    protected function validationRules() {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users', 
            'password' => 'required|confirmed|min:8',
            'address' => 'required|max:150', 
        ];
        return $rules;
    }

    public function index() {
        return view('admin/index');
    }

    public function create(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRules());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $this->model->create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'address' => $input['address']
            ]);
            return redirect('user')->with('success', 'User created!');
        }

        return view('admin/form');
    }

    public function update($id, Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRules());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $this->model->find($id)->update([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'address' => $input['address']
            ]);
            return redirect('user')->with('success', 'User updated!');
        }

        $model = $this->model->find($id);
        return view('admin/form', compact('model'));
    }

    public function destroy($id) {
        $model = $this->model->find($id);
        $model->delete();
        return redirect('user')->with('success', 'User deleted!');
    }

    public function getUsers(Request $request) {
        $data = $this->model->where('status', '00')->get();
        return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                $btn = '<a href="'.url('user/update').'/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                                $btn = $btn.' <a href="'.url('user/delete').'/'.$row->id.'" class="btn btn-danger btn-sm">Delete</a>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
    }
}
