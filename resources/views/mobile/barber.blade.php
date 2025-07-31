@extends('layouts.mobile')
@section('title')
    Barber
@endsection
@section('content')
    <section class="py-3">
        <div class="container px-3">
            <div class="row row-cols-xl-1 row-cols-lg-1 row-cols-md-1 row-cols-1 g-3 osahan-my-orders">
                @forelse ($barbers as $barber)
                    <div class="col">
                        <div data-bs-toggle="offcanvas" data-bs-target="#viewdetails" aria-controls="viewdetails"
                            class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                            <div class="w-75">
                                <div class="d-flex align-items-start gap-3 osahan-mb-1">
                                    @if ($barber->gambar)
                                        <img class="img-circle" src="{{ asset('storage/' . $barber->gambar) }}"
                                            alt="Logo" width="40">
                                    @else
                                        <img class="img-circle" src="{{ asset('storage/' . $aplikasi->logo) }}"
                                            alt="Logo" width="40">
                                    @endif
                                    <div>
                                        <h6 class="fw-bold mb-1 d-flex align-items-center">
                                            {{ $barber->nama }} </h6>
                                        <p class="text-muted text-truncate mb-0 small">
                                            <strong>Pemilik:</strong> {{ $barber->nama_pemilik }} <br>
                                            <strong>Telepon:</strong> <a
                                                href="tel:{{ $barber->telepon }}">{{ $barber->telepon }}</a> <br>
                                            <strong>Email:</strong> <a
                                                href="mailto:{{ $barber->email }}">{{ $barber->email }}</a> <br>
                                            {{ $barber->alamat }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                <a href="{{ route('barber.detail', $barber->id) }}" class="small"><i
                                        class="lni lni-eye fs-6"></i><br>Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-danger" role="alert">
                        Data barber belum tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
