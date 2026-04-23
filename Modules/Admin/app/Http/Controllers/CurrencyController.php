<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\StoreCurrencyRequest;
use Modules\Admin\Http\Requests\UpdateCurrencyRequest;
use Modules\Admin\Services\CurrencyService;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CurrencyController extends Controller implements HasMiddleware
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view currencies|manage currencies', only: ['index']),
            new Middleware('permission:create currencies|manage currencies', only: ['create', 'store']),
            new Middleware('permission:edit currencies|manage currencies', only: ['edit', 'update']),
            new Middleware('permission:delete currencies|manage currencies', only: ['destroy']),
        ];
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $currencies = $this->currencyService->getAllCurrencies($request->all());
        return view('admin::currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin::currencies.create');
    }

    public function store(StoreCurrencyRequest $request)
    {
        $this->currencyService->storeCurrency($request->validated());
        return redirect()->route('admin.currencies.index')->with('success', __('Currency created successfully.'));
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
        return redirect()->route('admin.currencies.index')->with('success', __('Currency updated successfully.'));
    }

    public function destroy(string $id)
    {
        $currency = $this->currencyService->findCurrency($id);
        $this->currencyService->deleteCurrency($currency);
        return redirect()->route('admin.currencies.index')->with('success', __('Currency deleted successfully.'));
    }
}
