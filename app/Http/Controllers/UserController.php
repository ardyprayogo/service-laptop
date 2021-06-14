<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class UserController extends Controller
{
    //

    public function index() {
        return view('admin/index');
    }

    public function getUsers(Request $request) {
        $data = User::all()->where('status', '00');
        return Datatables::of($data)
                            ->addColumn('action', function($row){
                                $btn = '<a href="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                                $btn = $btn.' <a href="'.$row->id.'" class="btn btn-danger btn-sm">Delete</a>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
    }
}
