<?php

namespace App\DataExport;

use Illuminate\Http\Request;

interface DataExportInterface {
    
    function getQuery(Request $request, $interval);

    function makeRow($item);

    function batchSize();
}
