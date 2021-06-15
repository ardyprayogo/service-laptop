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

    private function validationRules() {
        $rules = [
            'service_type_id' => 'required',
            'service' => 'required',
            'price' => 'required|numeric',
            'desc' => 'required'
        ];
        return $rules;
    }

    public function index() {
        return view('services/index');
    }

    public function create(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRules());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $this->service->create($input);
            return redirect('services')->with('success', 'Service created!');
        }

        $types = $this->getOptionTypes();
        return view('services/form',compact('types'));
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

    public function update($id, Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRules());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $this->service->find($id)->update($input);
            return redirect('services')->with('success', 'Service updated!');
        }

        $model = $this->service->find($id);
        $types = $this->getOptionTypes();
        return view('services/form', compact('model', 'types'));
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

    public function destroy($id) {
        $model = $this->service->find($id);
        $model->delete();
        return redirect('services')->with('success', 'Service deleted!');
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
                                $btn = '<a href="'.url('services/update').'/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                                $btn = $btn.' <a href="'.url('services/delete').'/'.$row->id.'" class="btn btn-danger btn-sm">Delete</a>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
    }

    private function getOptionTypes() {
        $types = $this->type->where('status', '00')->get();
        $type_options = [];
        foreach ($types as $type) {
            $type_options[$type->id] = $type->type;
        }
        return $type_options;
    }
}
