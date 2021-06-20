<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Repositories\TransactionRepository;
use App\Models\Services;
use Auth;
use DB;
use Carbon\Carbon;


class TransactionController extends Controller
{
    //
    public function __construct(TransactionRepository $repository) {
        $this->repository = $repository;
    }

    private function validationRules() {
        $rules = [
            'customer_id' => 'required',
            'dp' => 'required',
            'laptop' => 'required',
            'case' => 'required',
            'services.*' => 'required',
            'prices.*' => 'required|numeric'
        ];
        return $rules;
    }

    public function index() {
        return view('transaction/index');
    }

    public function view(Request $request, $id) {
        $request = $request->all();
        $header = $this->repository->getTransaction($id);
        $details = $this->repository->getTransactionDetail($id);
        return view('transaction/view', compact('header', 'details'));
    }

    public function create(Request $request) {

        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRules());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $insertTransaction = $this->createTransaction($input);
            if ($insertTransaction['result'])
                return redirect('transaction')->with('success', 'Transaction created!');
        }


        $customers = $this->repository->getOptionCustomers();
        // $services = $this->getOptionServices();
        $services = Services::where('status', '00')->get();
        return view('transaction/form', compact('customers', 'services'));
    }

    public function getTransaction() {
        $data = $this->repository->getAllTransaction();
        return $data;
    }

}
