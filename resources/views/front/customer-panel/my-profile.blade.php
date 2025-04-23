@extends('front.layouts.app')
@section('styles')

<link rel="stylesheet" href="{{ asset('front-assets/css/account-pages.css') }}">

@endsection

@section('content')

<div class="container-fluid edit-profile-wrapper">
    <div class="row">
        <div class="col-md-4 bg-white">
            @include('front.customer-panel.includes.sidebar')
        </div>
        <div class="col-md-8">
            <div class="customer-edit-profile-fields-main bg-white m-lg-5 m-3 px-lg-5 px-3 py-4">
                <div class="customer-edit-profile-heading">
                    <h5>Your Account</h5>
                </div>
                <form class="customer-profile-fields-inner">
                    <div class="row customer-field-row">
                        <div class="col-lg-6">
                            <div class="customer-field">
                                <label class="f-14px form-label">Title</label>
                                <select class="form-control f-14px">
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="customer-field">
                                <label class="f-14px form-label">First & Middle Name</label>
                                <input class="form-control f-14px" type="text" required placeholder="Enter your first & middle name"/>
                            </div>
                        </div>
                    </div>

                    <div class="row customer-field-row mt-3">
                        <div class="col-lg-6">
                            <div class="customer-field">
                                <label class="f-14px form-label">Last Name</label>
                                <input class="form-control f-14px" type="text" required placeholder="Enter your last name"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="customer-field">
                                <label class="f-14px form-label">Email</label>
                                <input class="form-control f-14px" type="email" required placeholder="Enter your email address"/>
                            </div>
                        </div>
                    </div>

                    <div class="row customer-field-row mt-3">
                        <div class="col-lg-6">
                            <div class="customer-field">
                                <label class="f-14px form-label">Mobile Number</label>
                                <input class="form-control f-14px" type="text" placeholder="+923121234567"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="customer-field">
                                <label class="f-14px form-label">Date of Birth</label>
                                <div class="bd-fields d-flex">
                                    <select class="form-select p-2 f-14px">
                                        <option>Date</option>
                                    </select>
                                    <select class="form-select p-2 f-14px">
                                        <option>Month</option>
                                    </select>
                                    <select class="form-select p-2 f-14px">
                                        <option>Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row customer-field-row mt-3">
                        <div class="col-lg-6">
                            <div class="customer-field">
                                <label class="f-14px form-label">Country</label>
                                <select class="form-control f-14px">
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Dubai">Dubai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="customer-field">
                                <label class="f-14px form-label">State</label>
                                <input class="form-control f-14px" type="text" placeholder="State"/>
                            </div>
                        </div>
                    </div>

                    <div class="row customer-field-row mt-3">
                        <div class="col-lg-6">
                            <div class="customer-field">
                                <label class="f-14px form-label">City</label>
                                <input class="form-control f-14px" type="text" placeholder="City"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="customer-field">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="edit-profile-action-btns text-end mx-lg-5 mx-3 pb-5">
                <button class="button green_btn d-block mb-3" style="margin-left: auto;">Save</button>
                {{-- <a href="" class="color-green text-decoration-none">Delete My Account</a> --}}
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')


@endsection