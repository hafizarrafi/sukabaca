@extends('layouts.app')

@section('title', 'Hasil Pencarian - Sukabaca')

@section('content')
<div class="px-14 mt-10">

  <h2 class="text-3xl font-bold mb-8">Hasil Pencarian: "{{ $query }}"</h2>

  @if($news->count() > 0)
    <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
      @foreach ($news as $item)
        <a href="{{ route('news.show', $item->id) }}" class="block border border-slate-200 rounded-xl p-4 hover:border-primary hover:shadow-lg transition duration-300 ease-in-out">
          <div class="relative">
            <div class="bg-primary text-white rounded-full w-fit px-4 py-1 font-normal text-sm absolute top-2 left-2 z-10">
              {{ $item->newsCategory->title }}
            </div>
            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="rounded-xl w-full h-40 object-cover mb-3">
          </div>
          <h3 class="font-semibold text-lg mb-2">{{ $item->title }}</h3>
          <p class="text-gray-600 text-sm line-clamp-3">{!! \Illuminate\Support\Str::limit(strip_tags($item->content), 120) !!}</p>
          <p class="text-gray-400 text-xs mt-3">{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</p>
        </a>
      @endforeach
    </div>

    <div class="mt-8">
      {{ $news->links() }}
    </div>
  @else
    <p class="text-center text-gray-500 text-lg mt-20">Maaf, hasil pencarian untuk <span class="font-semibold">"{{ $query }}"</span> tidak ditemukan.</p>
  @endif

</div>
@endsection
