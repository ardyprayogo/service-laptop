<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\ServiceTypes;
use Illuminate\Support\Facades\Validator;
use DataTables;

class ServiceController extends Controller
{
    //

    public function __construct(Services $service, ServiceTypes $type) {
        $this->service = $service;
        $this->type = $type;
    }

    private function validationRulesType() {
        $rules = [
            'type' => 'required',
            'service_desc' => 'required'
        ];
        return $rules;
    }

    public function index() {
        return view('services/index');
    }

    public function createType(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRulesType());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $this->type->create($input);
            return redirect('service-types')->with('success', 'Type created!');
        }

        return view('service-types/form');
    }

    public function updateType($id, Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRulesType());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $this->type->find($id)->update($input);
            return redirect('service-types')->with('success', 'Type updated!');
        }

        $model = $this->type->find($id);
        return view('service-types/form', compact('model'));
    }

    public function destroyType($id) {
        $model = $this->type->find($id);
        $model->delete();
        return redirect('service-types')->with('success', 'Type deleted!');
    }

    public function indexType() {
        return view('service-types/index');
    }

    public function getServiceTypes() {
        $data = ServiceTypes::all()->where('status', '00');
        return Datatables::of($data)
                            ->addColumn('action', function($row){
                                $btn = '<a href="'.url('service-types/update').'/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                                $btn = $btn.' <a href="'.url('service-types/delete').'/'.$row->id.'" class="btn btn-danger btn-sm">Delete</a>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
    }

    public function getServices() {
        $data = Services::where('ms_services.status', '00')
                            ->join('ms_service_types', 'ms_services.service_type_id', '=', 'ms_service_types.id')
                            ->select('ms_services.*', 'ms_service_types.type')
                            ->get();
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
