<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PointSetting;
use Illuminate\Http\Request;

class PointSettingController extends Controller
{
    public function index()
    {
        $settings = PointSetting::all()->pluck('value', 'key')->toArray();
        
        // Ensure default settings exist if first time
        if (empty($settings)) {
            $defaults = [
                'points_per_currency' => '1', // 1 point for every 1 unit
                'currency_per_point' => '0.1', // 1 point = 0.1 currency
                'min_points_to_convert' => '100',
                'points_earning_status' => 'delivered', // points earned when order is delivered
            ];
            
            foreach ($defaults as $key => $val) {
                PointSetting::updateOrCreate(['key' => $key], ['value' => $val]);
            }
            $settings = $defaults;
        }

        return view('admin::settings.points', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'points_per_currency' => 'required|numeric|min:0',
            'currency_per_point' => 'required|numeric|min:0',
            'min_points_to_convert' => 'required|integer|min:0',
            'points_earning_status' => 'required|string',
        ]);

        foreach ($data as $key => $value) {
            PointSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', __('Points settings updated successfully.'));
    }
}
