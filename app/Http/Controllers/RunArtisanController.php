<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RunArtisanController extends Controller
{
    public function artisanMigrate(Request $request)
    {
        Artisan::call($request->command);
    }
}
