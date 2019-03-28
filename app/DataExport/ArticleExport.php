<?php

namespace App\DataExport;

use Illuminate\Http\Request;
use App\Article;

class ArticleExport implements DataExportInterface {
    
    function getQuery(Request $request, $interval) {
        $query = Article::query();
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
