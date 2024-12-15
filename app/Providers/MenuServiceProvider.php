<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewView;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Get the authenticated user's role
        // $role = Auth::user() ?? '';
        // dd($role);
        // Determine the menu file path based on the role
        // $menuFilePath = match ($role) {
        //     'admin', 'superadmin' => base_path('resources/menu/verticalMenu.json'),
        //     'student' => base_path('resources/menu/studentMenu.json'),
        //     'teacher' => base_path('resources/menu/teacherMenu.json'),
        //     default => base_path('resources/menu/verticalMenu.json'),
        // };
        // dd($menuFilePath);
        // Initialize menu data
        // $verticalMenuData = null;


        // Load and decode the JSON file if the path exists
        // if ($menuFilePath && file_exists($menuFilePath)) {
        //     $menuJson = file_get_contents($menuFilePath);
        //     $verticalMenuData = json_decode($menuJson); // Decode as an associative array
        // }

        // Share the menu data with all views

        // $this->app->make('view')->share('menuData', [$verticalMenuData]);
    }
}
