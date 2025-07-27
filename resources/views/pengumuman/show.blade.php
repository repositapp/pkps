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
                    <li><a href="{{ url('/pengumuman') }}">Pengumuman</a></li>
                    <li class="current">Detail Pengumuman</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-lg-8">

                <!-- Blog Details Section -->
                <section id="blog-details" class="blog-details section">
                    <article class="article" data-aos="fade-right" data-aos-delay="100">
                        <h2 class="title">{{ $pengumuman->judul }}</h2>
                        <div class="meta-top">
                            <ul>
                                <li class="d-flex align-items-center"><i class="bi bi-folder"></i>
                                    <a href="blog-details.html">{{ $pengumuman->kategori->name }}</a>
                                </li>
                                <li class="d-flex align-items-center"><i class="bi bi-clock"></i>
                                    <a href="blog-details.html"><time
                                            datetime="2020-01-01">{{ $pengumuman->created_at->translatedFormat('d F Y, h:s') }}</time></a>
                                </li>
                                <li class="d-flex align-items-center"><i class="bi bi-person"></i>
                                    <a href="blog-details.html">{{ $pengumuman->author->name }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="post-img">
                            @if ($pengumuman->gambar)
                                <img src="{{ asset('storage/' . $pengumuman->gambar) }}" class="img-fluid"
                                    alt="{{ $pengumuman->kategori->name }}">
                            @else
                                <img src="{{ URL::asset('dist/img/blog/blog-6.jpg') }}" class="img-fluid"
                                    alt="{{ $pengumuman->kategori->name }}">
                            @endif
                        </div>
                        <div class="content">
                            <p>{!! $pengumuman->body !!}</p>
                        </div>
                    </article>
                </section>
            </div>

            <div class="col-lg-4 sidebar">
                <div class="widgets-container" data-aos="fade-left" data-aos-delay="200">
                    <div class="recent-posts-widget widget-item">
                        <h3 class="widget-title">Berita Terbaru</h3>
                        @foreach ($artikels as $a)
                            <div class="post-item">
                                @if ($a->gambar)
                                    <img src="{{ asset('storage/' . $a->gambar) }}" class="img-fluid"
                                        alt="{{ $a->kategori->name }}">
                                @else
                                    <img src="{{ URL::asset('dist/img/blog/blog-recent-1.jpg') }}"
                                        alt="{{ $a->kategori->name }}" class="flex-shrink-0">
                                @endif
                                <div>
                                    <h4><a href="{{ route('berita.show', $a->slug) }}">{{ $a->judul }}</a>
                                    </h4>
                                    <time datetime="2020-01-01"><span style="font-size: 12px;"><i
                                                class="bi bi-folder"></i>{{ $a->kategori->name }}</span>
                                        <br>{{ $a->created_at->translatedFormat('d F Y, h:s') }}
                                    </time>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="recent-posts-widget widget-item">
                        <h3 class="widget-title">Pengumuman Terbaru</h3>
                        @foreach ($pengumumans as $pengumuman)
                            <div class="post-item">
                                <div>
                                    <h4><a
                                            href="{{ route('pengumuman.show', $pengumuman->slug) }}">{{ $pengumuman->judul }}</a>
                                    </h4>
                                    <time
                                        datetime="2020-01-01">{{ $pengumuman->created_at->translatedFormat('d F Y, h:s') }}</time>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
