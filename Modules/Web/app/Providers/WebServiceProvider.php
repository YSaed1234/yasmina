<?php

namespace Modules\Web\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class WebServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Web';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'web';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();
        
        \Illuminate\Support\Facades\View::composer(['web::*'], function ($view) {
            $vendorParam = request()->get('vendor_id');
            $currentVendor = null;
            
            if ($vendorParam) {
                $currentVendor = \App\Models\Vendor::where('id', $vendorParam)
                    ->orWhere('slug', $vendorParam)
                    ->first();
            }

            $categoriesQuery = \App\Models\Category::orderBy('rank');
            if ($currentVendor) {
                $categoriesQuery->where('vendor_id', $currentVendor->id);
            } else {
                $categoriesQuery->whereNull('vendor_id');
            }

            $view->with('globalCategories', $categoriesQuery->get());
            $view->with('currentVendor', $currentVendor);
            $view->with('globalVendors', \App\Models\Vendor::where('status', 'active')->orderBy('name')->get());
        });
    }
}
