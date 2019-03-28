<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Exports\Exporter;

class ExportController extends BaseController
{
    public function __invoke(Exporter $expoter) {
    }
}
