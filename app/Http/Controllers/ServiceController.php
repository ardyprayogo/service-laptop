<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\ServiceTypes;
use DataTables;

class ServiceController extends Controller
{
    //

    public function index() {
        return view('services/index');
    }

    public function indexType() {
        return view('service-types/index');
    }

    public function getServiceTypes() {
        $data = ServiceTypes::all()->where('status', '00');
        return Datatables::of($data)
                            ->addColumn('action', function($row){
                                $btn = '<a href="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                                $btn = $btn.' <a href="'.$row->id.'" class="btn btn-danger btn-sm">Delete</a>';
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
