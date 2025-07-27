@extends('layouts.first')
@section('title')
    @if ($menu->parent)
        {{ $menu->parent->name }}
    @else
        {{ $menu->name }}
    @endif
@endsection
@section('content')
    <div class="page-title dark-background" style="background-image: url('{{ URL::asset('dist/img/page-title-bg.jpg') }}');">
        <div class="container position-relative">
            @if ($menu->parent)
                <h1>{{ $menu->parent->name }}</h1>
            @else
                <h1>{{ $menu->name }}</h1>
            @endif
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('index') }}">Beranda</a></li>
                    @if ($menu->parent)
                        <li><a href="#">{{ $menu->parent->name }}</a></li>
                    @endif
                    <li class="current">{{ $menu->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-lg-12">

                <!-- Blog Details Section -->
                <section id="blog-details" class="blog-details section">
                    <article class="article" data-aos="fade-right" data-aos-delay="100">
                        <h2 class="title">{{ $halaman->judul }}</h2>
                        <div class="meta-top">
                            <ul>
                                <li class="d-flex align-items-center"><i class="bi bi-clock"></i>
                                    <a href="blog-details.html"><time
                                            datetime="2020-01-01">{{ $halaman->created_at->translatedFormat('d F Y, h:s') }}</time></a>
                                </li>
                            </ul>
                        </div>
                        <div class="content">
                            <p>{!! $halaman->konten !!}</p>
                        </div>
                    </article>
                </section>
            </div>
        </div>
    </div>
@endsection
