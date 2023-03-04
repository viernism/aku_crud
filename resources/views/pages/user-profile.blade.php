@extends('layouts.app', ['title' => 'My Profile'])

@section('content')
    <div class="container-fluid px-2 px-md-4">
        <div class="card card-body mx-3 mx-md-4 mt-n5">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="https://yt3.googleusercontent.com/ytc/AL5GRJUcxwD492q8Ej-nOYuJ7_Jgiuj4vUARPgYXfY_Ixw=s900-c-k-c0x00ffffff-no-rj"
                            alt="profile_image" class="w-100 img-border-radius shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <h5 class="mb-1"> Raihan </h5>
                    <p class="mb-0 font-weight-normal text-sm">Creator</p>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 text-end">
                    <button type="button" class="btn btn-primary p-1 mb-0 py-1 actove" data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">
                        <i class="ri-settings-2-line text-lg position-relative"></i>
                        <span class="ms-1">Edit Profile</span>
                    </button>
                </div>
            </div>
            <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-3">Profile Information</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email address</label>
                            <p class="form-control-static">test@email..org</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <p class="form-control-static">Raihan</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <p class="form-control-static"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <p class="form-control-static"></p>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="about" class="form-label">About</label>
                            <p class="form-control-static">"I don't know maybe I'm autistic or something..." Linus Torvalds
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile Modal-->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
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
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            value="test@gmail.com">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="Admin">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="number" name="phone" class="form-control" id="phone">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" name="location" class="form-control" id="location">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="about" class="form-label">About</label>
                                        <textarea class="form-control" id="about" name="about" rows="4"
                                            placeholder="Say something about yourself"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
