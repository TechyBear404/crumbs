<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('datetime', function (string $expression) {
            return \Carbon\Carbon::parse($expression)->format('d/m/Y H:i');
        });

        Blade::directive('date', function (string $expression) {
            return \Carbon\Carbon::parse($expression)->format('d/m/Y');
        });

        Blade::directive('currency_euro', function (string $expression) {
            return "<?php echo number_format($expression, 2, ',', '.') . ' €'; ?>";
        });
    }
}
