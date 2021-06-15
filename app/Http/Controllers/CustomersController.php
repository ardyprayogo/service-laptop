<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customers;
use DataTables;

class CustomersController extends Controller
{
    //

    public function __construct(Customers $customer) {
        $this->model = $customer;
    }

    protected function validationRules() {
        $rules = [
            'customer' => 'required',
            'telp' => 'required|numeric', 
            'email' => 'required|email', 
            'address' => 'required|max:150', 
        ];
        return $rules;
    }

    public function index(Request $request) {
        return view('customers/index');
    }

    public function getCustomers(Request $request) {
        $data = $this->model->where('status', '00')->get();
        return Datatables::of($data)
                            ->addColumn('action', function($row){
                                $btn = '<a href="'.url('customers/update').'/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                                $btn = $btn.' <a href="'.url('customers/delete').'/'.$row->id.'" class="btn btn-danger btn-sm">Delete</a>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
    }

    public function create(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRules());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $this->model->create($input);
            return redirect('customers')->with('success', 'Customer created!');
        }

        return view('customers/form');
    }

    public function update($id, Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRules());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $this->model->find($id)->update($input);
            return redirect('customers')->with('success', 'Customer updated!');
        }

        $model = $this->model->find($id);
        return view('customers/form', compact('model'));
    }

    public function destroy($id) {
        $model = $this->model->find($id);
        $model->delete();
        return redirect('customers')->with('success', 'Customer deleted!');
    }

}
