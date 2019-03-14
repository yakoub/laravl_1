<?php

use Illuminate\Database\Seeder;
use App\article;

class Articles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,5) as $item) {
            $article = new article;
            $article->title = "article-{$item}";
            $article->teaser = "teaser-{$item}";
            $article->body = "body-{$item}";
            $article->save();
        }
    }
}
