<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }
    public function detail($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        $newests = News::orderBy('created_at', 'desc')->get()->take(4);
        return view('pages.news.show', compact('news', 'newests'));
    }
    public function category($slug)
    {
        $category = NewsCategory::where('slug', $slug)->first();
        return view('pages.news.category', compact('category'));
    }
}