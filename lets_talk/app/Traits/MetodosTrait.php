<?php

namespace App\Traits;

use App\Clases\PDF\FPDF;
use App\Events\NotificacionEvent;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\File;
use App\Clases\CarbonColombia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

trait MetodosTrait
{
    public function checkDatabaseConnection($rutaPerfil)
    {
        try {
           $pdo = DB::connection()->getPdo();
            return view($rutaPerfil);
        } catch (\Exception $e) {
            return View::make('database_connection');
        }
    }
} // FIN Traits Metodos
