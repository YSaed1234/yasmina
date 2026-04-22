<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\StoreCurrencyRequest;
use Modules\Admin\Http\Requests\UpdateCurrencyRequest;
use Modules\Admin\Services\CurrencyService;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $currencies = $this->currencyService->getAllCurrencies();
        return view('admin::currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin::currencies.create');
    }

    public function store(StoreCurrencyRequest $request)
    {
        $this->currencyService->storeCurrency($request->validated());
        return redirect()->route('currencies.index')->with('success', 'Currency created successfully.');
    }

    public function edit(string $id)
    {
        $currency = $this->currencyService->findCurrency($id);
        return view('admin::currencies.edit', compact('currency'));
    }

    public function update(UpdateCurrencyRequest $request, string $id)
    {
        $currency = $this->currencyService->findCurrency($id);
        $this->currencyService->updateCurrency($currency, $request->validated());
        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }

    public function destroy(string $id)
    {
        $currency = $this->currencyService->findCurrency($id);
        $this->currencyService->deleteCurrency($currency);
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
}
