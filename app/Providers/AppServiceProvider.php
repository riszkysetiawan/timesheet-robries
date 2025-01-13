<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File; // Untuk membaca file di direktori
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalActivityObserver;
use Illuminate\Support\Facades\View;
use App\Models\CompanyProfile;

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
    public function boot()
    {
        // Iterasi melalui semua model di folder app/Models
        $modelPath = app_path('Models');
        $models = File::allFiles($modelPath);

        foreach ($models as $model) {
            $modelName = 'App\\Models\\' . pathinfo($model->getFilename(), PATHINFO_FILENAME);

            // Pastikan kelas dapat diinstansiasi dan bukan abstract
            if (class_exists($modelName) && is_subclass_of($modelName, Model::class)) {
                // Daftarkan observer ke model
                $modelName::observe(GlobalActivityObserver::class);
            }
        }

        View::composer('*', function ($view) {
            $view->with('logo', CompanyProfile::first());
        });
    }
}
