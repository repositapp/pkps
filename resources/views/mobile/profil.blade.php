@extends('layouts.mobile')
@section('title')
    Profil
@endsection
@section('content')
    <section class="p-0">
        <div class="container p-0">
            <div
                class="row rounded-4 border osahan-my-account-page border-secondary-subtle g-0 col-lg-8 mx-auto overflow-hidden">
                <div class="col-lg-3 border-bottom bg-white">
                    <div class="nav d-flex justify-content-center my-account-pills" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <button class="nav-link d-flex flex-column active" id="v-pills-my-address-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-my-address" type="button" role="tab"
                            aria-controls="v-pills-my-address" aria-selected="true">
                            <i class="bi bi-person-lock"></i>Akun</button>
                        <a class="nav-link d-flex flex-column" href="javascript:void();"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="lni lni-key"></i>Logout</a>
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                <div class="col-lg-9 bg-light">
                    <div class="tab-content p-3" id="v-pills-tabContent">
                        <!-- my address -->
                        <div class="tab-pane fade show active" id="v-pills-my-address" role="tabpanel" tabindex="0">
                            <div class="row">
                                <div class="col-lg-5">
                                    <!-- form -->
                                    <form action="{{ route('profil.update', $user->id) }}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <!-- input -->
                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}" placeholder="Nama Lengkap">
                                        </div>
                                        <!-- input -->
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}" placeholder="Email Aktif">
                                        </div>
                                        <!-- input -->
                                        <div class="mb-4">
                                            <label class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="telepon" name="telepon"
                                                value="{{ $user->telepon }}" placeholder="Nomor Telepon">
                                        </div>
                                        <!-- input -->
                                        <div class="mb-4">
                                            <label class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Alamat">{{ $user->alamat }}</textarea>
                                        </div>
                                        <!-- input -->
                                        <div class="mb-4">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="{{ $user->username }}" placeholder="Username">
                                        </div>
                                        <!-- input -->
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="************">
                                        </div>
                                        <!-- button -->
                                        <div>
                                            <button type="submit"
                                                class="btn btn-danger fw-bold py-3 px-4 w-100 rounded-4 shadow">
                                                <i class="fa fa-paper-plane"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
