@extends('layouts.app', ['title' => 'My Profile'])

@section('content')
    <div class="container-fluid px-2 px-md-4">
        <div class="card card-body mx-3 mx-md-4 mt-n5">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <form id="profile-image-form" action="{{ route('updateProfileImage') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset(Auth::user()->photo) }}" alt="profile_image"
                                class="w-100 img-border-radius shadow-sm">
                            <div class="text-avatar">
                                <label for="profile_image" class="cursor-pointer">Change Your Picture</label>
                                <input type="file" name="photo" id="profile_image" class="d-none"
                                    onchange="document.getElementById('profile-image-form').submit();">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-auto my-auto">
                    <h5 class="mb-1 text-white">{{ Auth::user()->username }}</h5>
                    <p class="mb-0 font-weight-normal text-sm text-white">Creator</p>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 text-end">
                    <button type="button" class="btn btn-primary mb-0 py-1 actove edit-profile-button" data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">
                        <i class="ri-settings-2-line text-lg position-relative btn-icon"></i>
                        <span class="ms-1 btn-text">Edit Profile</span>
                    </button>
                </div>
            </div>
            <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-3 text-white">Profile Information</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label text-gray-300">Nama</label>
                            <p class="form-control-static text-white">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="mb-3 col-md-6 text-gray-300">
                            <label for="username" class="form-label">Username</label>
                            <p class="form-control-static text-white">{{ Auth::user()->username }}</p>
                        </div>
                        <div class="mb-3 col-md-6 text-gray-300">
                            <label for="email" class="form-label">Email address</label>
                            <p class="form-control-static text-white">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="mb-3 col-md-6 text-gray-300">
                            <label for="phone" class="form-label">Phone</label>
                            <p class="form-control-static text-white">{{ Auth::user()->phone }}</p>
                        </div>
                        <div class="mb-3 col-md-12 text-gray-300">
                            <label for="bio" class="form-label">About</label>
                            <p class="form-control-static text-white">{{ Auth::user()->bio }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Edit Profile Modal-->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your form fields here -->
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-3">Profile Information</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <form action="{{ route('edit.profile') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" id="username"
                                            value="{{ old('username', Auth::user()->username) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            value="{{ old('email', Auth::user()->email) }}">
                                        @error('email')
                                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="number" name="phone" class="form-control" id="phone"
                                            value="{{ old('phone', Auth::user()->phone) }}">
                                        @error('phone')
                                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="bio" class="form-label">About</label>
                                        <input type="text" name="bio" id="bio" class="form-control"
                                            value="{{ old('bio', Auth::user()->bio) }}">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
