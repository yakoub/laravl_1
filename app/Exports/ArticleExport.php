<?php

namespace App\Exports;

use App\article;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArticleExport implements FromQuery, WithMapping, WithHeadings
{
    public function query() {
        return article::query();
    }

    public function headings(): array {
        return ['ID', 'Title', 'Teaser', 'Body'];
    }

    public function map($article): array {
        return array(
            $article->id,
            $article->title,
            $article->teaser,
            $article->body,
        );
    }
}
