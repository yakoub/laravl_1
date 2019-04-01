<?php

namespace App\DataExport;

use Illuminate\Http\Request;
use App\article;

class ArticleExport implements DataExportInterface {
    
    function getQuery(Request $request, $interval) {
        $query = article::query();
        if ($interval) {
            $query->whereBetween('created_at', $interval); 
        }
        return $query;
    }

    function makeRow($item) {
        return [$item->id, $item->title, $item->teaser, $item->body];
    }

    function batchSize() {
        return 500;
    }

}
