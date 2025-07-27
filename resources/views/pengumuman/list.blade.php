@extends('layouts.first')
@section('title')
    Pengumuman
@endsection
@section('content')
    <div class="page-title dark-background" style="background-image: url('{{ URL::asset('dist/img/page-title-bg.jpg') }}');">
        <div class="container position-relative">
            <h1>Pengumuman</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('index') }}">Beranda</a></li>
                    <li class="current">Pengumuman</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Announcement Section -->
    <section id="services" class="services section">
        <div class="container">
            <div class="row gy-4">
                @foreach ($pengumumans as $pengumuman)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <a href="{{ route('pengumuman.show', $pengumuman->slug) }}">
                            <div class="service-item  position-relative">
                                <h3>{{ $pengumuman->judul }}</h3>
                                <p>{!! implode(' ', array_slice(explode(' ', $pengumuman->body), 0, 20)) !!}...</p>
                                <p class="mt-2 muted">{{ $pengumuman->created_at->translatedFormat('d F Y, h:s') }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- /Announcement Section -->

    <!-- Blog Pagination Section -->
    <section id="blog-pagination" class="blog-pagination section">
        <div class="container">
            <div class="d-flex justify-content-center">
                {{ $pengumumans->links() }}
            </div>
        </div>
    </section>
    <!-- /Blog Pagination Section -->
@endsection
