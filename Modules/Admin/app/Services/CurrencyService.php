<?php

namespace Modules\Admin\Services;

use App\Models\Currency;

class CurrencyService
{
    public function getAllCurrencies()
    {
        return Currency::all();
    }

    public function storeCurrency(array $data)
    {
        return Currency::create($data);
    }

    public function updateCurrency(Currency $currency, array $data)
    {
        $currency->update($data);
        return $currency;
    }

    public function deleteCurrency(Currency $currency)
    {
        return $currency->delete();
    }

    public function findCurrency(string $id)
    {
        return Currency::findOrFail($id);
    }
}
