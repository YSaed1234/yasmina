<?php

namespace Modules\Admin\Services;

use App\Models\Currency;

class CurrencyService
{
    public function getAllCurrencies(array $filters = [])
    {
        $query = Currency::with('translations');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereTranslationLike('name', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('symbol', 'like', "%{$search}%");
        }

        return $query->paginate($filters['per_page'] ?? 10);
    }

    public function storeCurrency(array $data)
    {
        $currency = new Currency();
        $currency->code = $data['code'];
        $currency->symbol = $data['symbol'];
        
        foreach (['ar', 'en'] as $locale) {
            if (isset($data[$locale]['name'])) {
                $currency->translateOrNew($locale)->name = $data[$locale]['name'];
            }
        }
        
        $currency->save();
        return $currency;
    }

    public function updateCurrency(Currency $currency, array $data)
    {
        $currency->code = $data['code'] ?? $currency->code;
        $currency->symbol = $data['symbol'] ?? $currency->symbol;
        
        foreach (['ar', 'en'] as $locale) {
            if (isset($data[$locale]['name'])) {
                $currency->translateOrNew($locale)->name = $data[$locale]['name'];
            }
        }
        
        $currency->save();
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
