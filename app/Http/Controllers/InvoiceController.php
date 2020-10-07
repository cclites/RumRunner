<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Requests\InvoiceRequest;

class InvoiceController extends Controller
{

    public function index(InvoiceRequest $request){

        if($request->json){
            return Invoice::all();
        }

        return view('invoice', ' Invoice', [], []);
    }

    public function show(InvoiceRequest $request, Invoice $invoice){
        return $invoice;
    }

    public function create(InvoiceUpdateRequest $request){

    }

    public function update(InvoiceUpdateRequest $request, Invoice $invoice){

    }

    public function delete(InvoiceUpdateRequest $request, Invoice $invoice){
        $invoice->delete();
    }
}
