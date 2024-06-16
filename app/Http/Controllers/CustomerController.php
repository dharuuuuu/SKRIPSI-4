<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Exports\Customers_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\Customer\TagihanChart;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', Customer::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');

        $customers = Customer::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('no_telepon', 'LIKE', "%{$search}%")
                    ->orWhere('alamat', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.customers.index', compact('customers', 'search'));
    }


    public function diagram(TagihanChart $tagihan)
    {
        return view('masterdata.customers.diagram', [
            'tagihan' => $tagihan->build(),
        ]);
    } 


    public function create(Request $request): View
    {
        $this->authorize('create', Customer::class);

        return view('masterdata.customers.create');
    }


    public function store(CustomerStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Customer::class);

        $validated = $request->validated();

        $customer = Customer::create($validated);

        return redirect()
            ->route('customers.index', $customer)
            ->withSuccess(__('crud.common.created'));
    }

 
    public function show(Request $request, Customer $customer): View
    {
        $this->authorize('view', $customer);

        return view('masterdata.customers.show', compact('customer'));
    }


    public function edit(Request $request, Customer $customer): View
    {
        $this->authorize('update', $customer);

        return view('masterdata.customers.edit', compact('customer'));
    }


    public function update(
        CustomerUpdateRequest $request,
        Customer $customer
    ): RedirectResponse {
        $this->authorize('update', $customer);

        $validated = $request->validated();

        $customer->update($validated);

        return redirect()
            ->route('customers.edit', $customer)
            ->withSuccess(__('crud.common.saved'));
    }


    public function destroy(
        Request $request,
        Customer $customer
    ): RedirectResponse {
        $this->authorize('delete', $customer);

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Customers_Export_Excel, 'Customers - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $customers = Customer::all();

        $pdf = PDF::loadView('PDF.customers', compact('customers'))->setPaper('a4', 'landscape');;

        return $pdf->download('Customers - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
