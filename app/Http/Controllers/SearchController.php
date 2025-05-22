<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            // Jika keyword kosong, kembalikan koleksi kosong agar hasil pencarian tidak muncul
            $news = collect(); 
        } else {
            // Cari berita dengan judul atau isi mengandung keyword
            $news = News::where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('content', 'like', '%' . $query . '%');
            })->paginate(10);
        }

        return view('search-result', compact('news', 'query'));
    }
}
