<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use DataTables;

class CustomersController extends Controller
{
    //
    public function index() {
        return view('customers/index');
    }

    public function getCustomers(Request $request) {
        $data = Customers::all()->where('status', '00');
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
