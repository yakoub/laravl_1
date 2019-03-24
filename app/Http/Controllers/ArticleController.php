<?php

namespace App\Http\Controllers;

use App\article;
use App\Exports\ArticleExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Exporter;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = article::query()->paginate(10);
        return view('articles', ['articles' => $articles]);
    }

    /**
     * export.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $interval = $request->query('interval', false);
        $batch = $request->query('batch', false);
        $query = article::query();
        if ($interval) {
            $query->whereBetween('created_at', $interval); 
        }
        $max = $query->count(); 
        if ($batch === false) {
            return view('articles.export', ['interval' => $interval, 'max' => $max]);
        }
        $query->offset($batch)->limit(100);
        $batch+=1000;
        return response()->json($batch);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = new article;
        $article->title = $request->input('title');
        $article->teaser = $request->input('teaser');
        $article->body = $request->input('body');
        $article->save();

        return redirect()->route('article.show', ['article' => $article]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(article $article)
    {
        return view('articles.edit', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, article $article)
    {
    error_log('runsssss');
        $article->title = $request->input('title');
        $article->teaser = $request->input('teaser');
        $article->body = $request->input('body');
        $article->save();

        return redirect()->route('article.edit', ['article' => $article]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(article $article)
    {
        //
    }
}
