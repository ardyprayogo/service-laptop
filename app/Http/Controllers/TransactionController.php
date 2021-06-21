<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Repositories\TransactionRepository;
use App\Models\Services;
use App\Exports\BasicExcelReport;
use Excel;


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
        return view('transaction/view', compact('header', 'details', 'id'));
    }

    public function print(Request $request, $id) {
        $request = $request->all();
        $header = $this->repository->getTransaction($id);
        $details = $this->repository->getTransactionDetail($id);
        return view('transaction/print', compact('header', 'details', 'id'));
    }

    public function create(Request $request) {

        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRules());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $insertTransaction = $this->repository->createTransaction($input);
            if ($insertTransaction['result'])
                return redirect('transaction')->with('success', 'Transaction - '.$insertTransaction['code'].' created!');
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

    public function getTransactionReport(Request $request) {
        $request = $request->all();
        $data = $this->repository->getReport($request);
        return $data;
    }

    public function finish($id) {
        $finish = $this->repository->finishService($id);
        if ($finish)
            return redirect('transaction')->with('success', 'Transaction finished!');

            return redirect()->back();
    }

    public function report() {
        return view('transaction/report');
    }

    public function export(Request $request) {
        $date = date('Y-m-d');
        $request = $request->all();
        $data = $this->repository->getExcel($request);
        return Excel::download(new BasicExcelReport($data), 'Report-'.$date.'.xlsx');
    }

}
