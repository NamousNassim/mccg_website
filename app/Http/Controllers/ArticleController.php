<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::published()->with('category')
            ->when($request->string('categorie')->toString(), fn ($q, $slug) => $q->whereHas('category', fn ($c) => $c->where('slug', $slug)))
            ->latest('published_at')->paginate(9)->withQueryString();

        return view('articles.index', [
            'articles' => $articles,
            'categories' => Category::whereHas('articles', fn ($query) => $query->published())->get(),
            'seo' => PageSeo::for('articles'),
        ]);
    }

    public function show(Article $article)
    {
        abort_unless($article->status === 'published' && $article->published_at?->isPast(), 404);
        $related = Article::published()->with('category')->whereKeyNot($article->id)->when($article->category_id, fn ($q) => $q->where('category_id', $article->category_id))->take(3)->get();

        return view('articles.show', compact('article', 'related'));
    }
}
