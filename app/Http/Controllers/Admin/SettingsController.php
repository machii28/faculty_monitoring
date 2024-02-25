<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

/**
 * Class SettingsController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings', [
            'title' => 'Settings',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'Settings' => false,
            ],
            'page' => 'resources/views/admin/settings.blade.php',
            'controller' => 'app/Http/Controllers/Admin/SettingsController.php',
        ]);
    }
}
