@extends('front.layouts.app')
@section('styles')
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <style>
        .gj-datepicker .gj-icon {
            display: none;
        }

        .error-main.gj-textbox-md {
            border: 1px solid red !important;
        }

        .gj-textbox-md {
            border: 1px solid #ced4da !important;
        }

        .stops-filter-options .filter-label:hover {
            cursor: pointer !important;
        }
        .flight-brand-info.text-center {
            grid-column: 1/-1 !important;
        }
    </style>
@endsection

@section('content')
    @php
        $display = '';
        if(request()->is('checkout') || request()->is('about') || request()->is('contact')){
            $display = "d-none d-md-block d-lg-block d-xl-block d-xxl-block";
        }
    @endphp
    <!-- checkout step 2 main section -->
    <div class="flight-checkout-step-1 container-small mt-4">
        <div class="row">
            <div class="col-md-8 flight-confimation-wrapper mb-5">
                
                <div class="flight-confimation-header mb-3">
                    <h5 class="confimation-title">
                        Contact Details
                    </h5>
                </div>

                <form action="{{ route('payment') }}" method="POST">
                    @csrf
                    <div class="flight-book-contact-details p-4 bg-white mb-3">
                        <div class="flight-book-cstmr-input-fields">
                            <div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    @if(auth()->check())
                                        <div class="form-group d-none">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" value="{{ old('first_name', auth()->user()->first_name) }}" name="first_name" required="" placeholder="Enter First Name">
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" value="{{ old('first_name') }}" name="first_name" required="" placeholder="Enter First Name">
                                        </div>
                                    @endif
                                    @error('first_name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    @if(auth()->check())
                                        <div class="form-group d-none">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" value="{{ old('last_name', auth()->user()->last_name) }}" name="last_name" required="" placeholder="Enter Last Name">
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" value="{{ old('last_name') }}" name="last_name" required="" placeholder="Enter Last Name">
                                        </div>
                                    @endif
                                    @error('last_name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <label>Mobile Number</label>
                                    <div class="form-group" x-data>
                                        @if(auth()->check())
                                            <input class="form-control w-100 rounded" name="phone" value="{{ old('phone', auth()->user()->phone) }}" id="signup-phone" x-mask="9999 9999999" placeholder="0345 1234567"/>
                                        @else
                                            <input class="form-control w-100 rounded" name="phone" value="{{old('phone')}}" id="signup-phone" x-mask="9999 9999999" placeholder="0345 1234567"/>
                                        @endif
                                    </div>
                                    @error('phone')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <span class="f-14px">e.g +923012345678</span>
                            </div>
                            <div class="flight-book-email-input-wrapper">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <label>Email</label>
                                    <div class="form-group">
                                        @if(auth()->check())
                                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" name="email" readonly placeholder="Enter Email">
                                        @else
                                            <input type="email" class="form-control" value="{{old('email')}}" name="email" required="" placeholder="Enter Email">
                                        @endif
                                    </div>
                                    @error('email')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <span class="flight-book-email-input f-14px">your ticked will emailed here.</span>
                            </div>
                        </div>

                        <div class="flight-booking-contact-checkbox mt-4 f-14px">
                            <label
                                class="ant-checkbox-wrapper ant-checkbox-wrapper-checked ant-checkbox-wrapper-in-form-item">
                                <input id="contactDetailForm_isConsent" class="ant-checkbox-input" type="checkbox"
                                    checked="">
                                <span class="ant-typography _3hyVd2NuIeZBwcBjzgYCc7">I agree to receive travel related
                                    information and deals</span>
                            </label>
                        </div>
                    </div>

                    @php
                        $i = 0;
                    @endphp
                    @if (@$query['adults'])
                        @for ($a = 0; $a < $query['adults']; $a++)
                            <div class="flight-confimation-addons">
                                <div class="confimation-title">
                                    <h5>Traveler Details for Adult {{ $a + 1 }}</h5>
                                </div>
                            </div>

                            <div class="customer-personal-info-wrapper">
                                <div class="customer-personal-info p-4 bg-white">

                                    <div class="gender-title mb-1">
                                        <label class="mb-2">Title</label>
                                        <div class="gender-title-options f-14px w-100">
                                            <label>
                                                <input name="passengers[{{ $i }}][passenger_title]" type="radio" value="Mr" checked>
                                                <span>Mr</span>
                                            </label>
                                            <label>
                                                <input name="passengers[{{ $i }}][passenger_title]" type="radio" value="Mrs">
                                                <span>Mrs</span>
                                            </label>
                                            <label>
                                                <input name="passengers[{{ $i }}][passenger_title]" type="radio" value="Ms">
                                                <span>Ms</span>
                                            </label>
                                        </div>
                                        @if($errors->has('passengers.'.$i.'.passenger_title'))
                                            <span class="error">{{ $errors->first('passengers.'.$i.'.passenger_title') }}</span>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <label>First Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="passengers[{{ $i }}][name]" value="{{old('passengers.'.$i.'.name')}}" required="">
                                            </div>
                                            @if($errors->has('passengers.'.$i.'.name'))
                                                <span class="error">{{ $errors->first('passengers.'.$i.'.name') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 ">
                                            <label>Last Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="passengers[{{ $i }}][sur_name]" value="{{old('passengers.'.$i.'.sur_name')}}" required="">
                                            </div>
                                            @if($errors->has('passengers.'.$i.'.sur_name'))
                                                <span class="error">{{ $errors->first('passengers.'.$i.'.sur_name') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3">
                                            <label>DOB</label>
                                            <div class="date-input date-from mb-0 date-return-active">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                    <path d="M3.9375 0C4.08668 0 4.22976 0.0592632 4.33525 0.164752C4.44074 0.270242 4.5 0.413316 4.5 0.5625V1.125H13.5V0.5625C13.5 0.413316 13.5593 0.270242 13.6648 0.164752C13.7702 0.0592632 13.9133 0 14.0625 0C14.2117 0 14.3548 0.0592632 14.4602 0.164752C14.5657 0.270242 14.625 0.413316 14.625 0.5625V1.125H15.75C16.3467 1.125 16.919 1.36205 17.341 1.78401C17.7629 2.20597 18 2.77826 18 3.375V15.75C18 16.3467 17.7629 16.919 17.341 17.341C16.919 17.7629 16.3467 18 15.75 18H2.25C1.65326 18 1.08097 17.7629 0.65901 17.341C0.237053 16.919 0 16.3467 0 15.75V3.375C0 2.77826 0.237053 2.20597 0.65901 1.78401C1.08097 1.36205 1.65326 1.125 2.25 1.125H3.375V0.5625C3.375 0.413316 3.43426 0.270242 3.53975 0.164752C3.64524 0.0592632 3.78832 0 3.9375 0V0ZM1.125 4.5V15.75C1.125 16.0484 1.24353 16.3345 1.4545 16.5455C1.66548 16.7565 1.95163 16.875 2.25 16.875H15.75C16.0484 16.875 16.3345 16.7565 16.5455 16.5455C16.7565 16.3345 16.875 16.0484 16.875 15.75V4.5H1.125Z"
                                                        fill="#333333" />
                                                </svg>
                                                <input type="date" class="form-control to-date pl-5 dob" value="{{old('passengers.'.$i.'.dob')}}" name="passengers[{{ $i }}][dob]" readonly="true"
                                                    autocomplete="off" required="" tabindex="4">
                                            </div>
                                            @if($errors->has('passengers.'.$i.'.dob'))
                                                <span class="error">{{ $errors->first('passengers.'.$i.'.dob') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                            <label>Gender</label>
                                            <div class="form-group">
                                                <select name="passengers[{{ $i }}][passenger_gender]"
                                                    class="form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option @if(old('passengers.'.$i.'.passenger_gender') == 'M') selected @endif value="M">Male</option>
                                                    <option @if(old('passengers.'.$i.'.passenger_gender') == 'F') selected @endif  value="F">Female</option>
                                                </select>
                                            </div>
                                            @if($errors->has('passengers.'.$i.'.passenger_gender'))
                                                <span class="error">{{ $errors->first('passengers.'.$i.'.passenger_gender') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                            <label>Nationality</label>
                                            <div class="form-group">
                                                <select name="passengers[{{ $i }}][nationality]" class="form-control" required>
                                                    <option value="">Select Country</option>
                                                    @foreach (Countries() as $country)
                                                        <option @if(old('passengers.'.$i.'.nationality') == $country->code) selected @endif value="{{ $country->code }}">{{ substr($country->name, 0, 35) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if($errors->has('passengers.'.$i.'.nationality'))
                                                <span class="error">{{ $errors->first('passengers.'.$i.'.nationality') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 ">
                                            <label>Passport</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{old('passengers.'.$i.'.document_number')}}" name="passengers[{{ $i }}][document_number]" required="">
                                            </div>
                                            @if($errors->has('passengers.'.$i.'.document_number'))
                                                <span class="error">{{ $errors->first('passengers.'.$i.'.document_number') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 ">
                                            <label>Passport Expiry</label>
                                            <div class="date-input date-from mb-0 date-return-active">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none">
                                                    <path d="M3.9375 0C4.08668 0 4.22976 0.0592632 4.33525 0.164752C4.44074 0.270242 4.5 0.413316 4.5 0.5625V1.125H13.5V0.5625C13.5 0.413316 13.5593 0.270242 13.6648 0.164752C13.7702 0.0592632 13.9133 0 14.0625 0C14.2117 0 14.3548 0.0592632 14.4602 0.164752C14.5657 0.270242 14.625 0.413316 14.625 0.5625V1.125H15.75C16.3467 1.125 16.919 1.36205 17.341 1.78401C17.7629 2.20597 18 2.77826 18 3.375V15.75C18 16.3467 17.7629 16.919 17.341 17.341C16.919 17.7629 16.3467 18 15.75 18H2.25C1.65326 18 1.08097 17.7629 0.65901 17.341C0.237053 16.919 0 16.3467 0 15.75V3.375C0 2.77826 0.237053 2.20597 0.65901 1.78401C1.08097 1.36205 1.65326 1.125 2.25 1.125H3.375V0.5625C3.375 0.413316 3.43426 0.270242 3.53975 0.164752C3.64524 0.0592632 3.78832 0 3.9375 0V0ZM1.125 4.5V15.75C1.125 16.0484 1.24353 16.3345 1.4545 16.5455C1.66548 16.7565 1.95163 16.875 2.25 16.875H15.75C16.0484 16.875 16.3345 16.7565 16.5455 16.5455C16.7565 16.3345 16.875 16.0484 16.875 15.75V4.5H1.125Z" fill="#333333" />
                                                </svg>
                                                <input type="date" class="form-control to-date pl-5 passport_expiry"
                                                    name="passengers[{{ $i }}][document_expiry_date]"  value="{{old('passengers.'.$i.'.document_expiry_date')}}" readonly="true" autocomplete="off" required="" tabindex="4">
                                            </div>
                                            @if($errors->has('passengers.'.$i.'.document_expiry_date'))
                                                <span class="error">{{ $errors->first('passengers.'.$i.'.document_expiry_date') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="passengers[{{ $i }}][passenger_type]"value="ADT">
                                    <input type="hidden" name="passengers[{{ $i }}][document_type]" value="P">
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endfor
                    @endif
                    {{-- /*@dump($query) --}}
                    @if (@$query['children'])
                        @for ($a = 0; $a < $query['children']; $a++)
                            <div class="flight-confimation-addons">
                                <div class="confimation-title">
                                    <h5>Traveler Details for Child {{ $a + 1 }}</h5>
                                </div>
                            </div>

                            <div class="customer-personal-info-wrapper">
                                <div class="customer-personal-info p-4 bg-white">

                                    <div class="gender-title mb-1">
                                        <label class="mb-2">Title</label>
                                        <div class="gender-title-options f-14px w-100">
                                            <label>
                                                <input name="passengers[{{ $i }}][passenger_title]"
                                                    type="radio" value="Mr" checked>
                                                <span>Mr</span>
                                            </label>
                                            <label>
                                                <input name="passengers[{{ $i }}][passenger_title]"
                                                    type="radio" value="Mrs">
                                                <span>Mrs</span>
                                            </label>
                                            <label>
                                                <input name="passengers[{{ $i }}][passenger_title]"
                                                    type="radio" value="Ms">
                                                <span>Ms</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <label>First Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    name="passengers[{{ $i }}][name]" required="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 ">
                                            <label>Last Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    name="passengers[{{ $i }}][sur_name]" required="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3">
                                            <label>DOB</label>
                                            <div class="date-input date-from mb-0 date-return-active">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none">
                                                    <path
                                                        d="M3.9375 0C4.08668 0 4.22976 0.0592632 4.33525 0.164752C4.44074 0.270242 4.5 0.413316 4.5 0.5625V1.125H13.5V0.5625C13.5 0.413316 13.5593 0.270242 13.6648 0.164752C13.7702 0.0592632 13.9133 0 14.0625 0C14.2117 0 14.3548 0.0592632 14.4602 0.164752C14.5657 0.270242 14.625 0.413316 14.625 0.5625V1.125H15.75C16.3467 1.125 16.919 1.36205 17.341 1.78401C17.7629 2.20597 18 2.77826 18 3.375V15.75C18 16.3467 17.7629 16.919 17.341 17.341C16.919 17.7629 16.3467 18 15.75 18H2.25C1.65326 18 1.08097 17.7629 0.65901 17.341C0.237053 16.919 0 16.3467 0 15.75V3.375C0 2.77826 0.237053 2.20597 0.65901 1.78401C1.08097 1.36205 1.65326 1.125 2.25 1.125H3.375V0.5625C3.375 0.413316 3.43426 0.270242 3.53975 0.164752C3.64524 0.0592632 3.78832 0 3.9375 0V0ZM1.125 4.5V15.75C1.125 16.0484 1.24353 16.3345 1.4545 16.5455C1.66548 16.7565 1.95163 16.875 2.25 16.875H15.75C16.0484 16.875 16.3345 16.7565 16.5455 16.5455C16.7565 16.3345 16.875 16.0484 16.875 15.75V4.5H1.125Z"
                                                        fill="#333333" />
                                                </svg>
                                                <input type="date" class="form-control to-date pl-5 dob"
                                                    name="passengers[{{ $i }}][dob]" readonly="true"
                                                    autocomplete="off" required="" tabindex="4">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                            <label>Gender</label>
                                            <div class="form-group">
                                                <select name="passengers[{{ $i }}][passenger_gender]"
                                                    class="form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                            <label>Nationality</label>
                                            <div class="form-group">
                                                <select name="passengers[{{ $i }}][nationality]" class="form-control" required>
                                                    <option value="">Select Country</option>
                                                    @foreach (Countries() as $country)
                                                        <option value="{{ $country->code }}">{{ substr($country->name, 0, 35) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 ">
                                            <label>Passport</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    name="passengers[{{ $i }}][document_number]"
                                                    required="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 ">
                                            <label>Passport Expiry</label>
                                            <div class="date-input date-from mb-0 date-return-active">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none">
                                                    <path
                                                        d="M3.9375 0C4.08668 0 4.22976 0.0592632 4.33525 0.164752C4.44074 0.270242 4.5 0.413316 4.5 0.5625V1.125H13.5V0.5625C13.5 0.413316 13.5593 0.270242 13.6648 0.164752C13.7702 0.0592632 13.9133 0 14.0625 0C14.2117 0 14.3548 0.0592632 14.4602 0.164752C14.5657 0.270242 14.625 0.413316 14.625 0.5625V1.125H15.75C16.3467 1.125 16.919 1.36205 17.341 1.78401C17.7629 2.20597 18 2.77826 18 3.375V15.75C18 16.3467 17.7629 16.919 17.341 17.341C16.919 17.7629 16.3467 18 15.75 18H2.25C1.65326 18 1.08097 17.7629 0.65901 17.341C0.237053 16.919 0 16.3467 0 15.75V3.375C0 2.77826 0.237053 2.20597 0.65901 1.78401C1.08097 1.36205 1.65326 1.125 2.25 1.125H3.375V0.5625C3.375 0.413316 3.43426 0.270242 3.53975 0.164752C3.64524 0.0592632 3.78832 0 3.9375 0V0ZM1.125 4.5V15.75C1.125 16.0484 1.24353 16.3345 1.4545 16.5455C1.66548 16.7565 1.95163 16.875 2.25 16.875H15.75C16.0484 16.875 16.3345 16.7565 16.5455 16.5455C16.7565 16.3345 16.875 16.0484 16.875 15.75V4.5H1.125Z"
                                                        fill="#333333" />
                                                </svg>
                                                <input type="date" class="form-control to-date pl-5 passport_expiry"
                                                    name="passengers[{{ $i }}][document_expiry_date]"
                                                    readonly="true" autocomplete="off" required="" tabindex="4">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="passengers[{{ $i }}][passenger_type]"
                                        value="CNN">
                                    <input type="hidden" name="passengers[{{ $i }}][document_type]"
                                        value="P">
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endfor
                    @endif
                    @if (@$query['infants'])
                        @for ($a = 0; $a < $query['infants']; $a++)
                            <div class="flight-confimation-addons">
                                <div class="confimation-title">
                                    <h5>Traveler Details for Infants {{ $a + 1 }}</h5>
                                </div>
                            </div>

                            <div class="customer-personal-info-wrapper">
                                <div class="customer-personal-info p-4 bg-white">

                                    <div class="gender-title mb-1">
                                        <label class="mb-2">Title</label>
                                        <div class="gender-title-options f-14px w-100">
                                            <label>
                                                <input name="passengers[{{ $i }}][passenger_title]"
                                                    type="radio" value="Mr" checked>
                                                <span>Mr</span>
                                            </label>
                                            <label>
                                                <input name="passengers[{{ $i }}][passenger_title]"
                                                    type="radio" value="Mrs">
                                                <span>Mrs</span>
                                            </label>
                                            <label>
                                                <input name="passengers[{{ $i }}][passenger_title]"
                                                    type="radio" value="Ms">
                                                <span>Ms</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <label>First Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    name="passengers[{{ $i }}][name]" required="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 ">
                                            <label>Last Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    name="passengers[{{ $i }}][sur_name]" required="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3">
                                            <label>DOB</label>
                                            <div class="date-input date-from mb-0 date-return-active">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none">
                                                    <path
                                                        d="M3.9375 0C4.08668 0 4.22976 0.0592632 4.33525 0.164752C4.44074 0.270242 4.5 0.413316 4.5 0.5625V1.125H13.5V0.5625C13.5 0.413316 13.5593 0.270242 13.6648 0.164752C13.7702 0.0592632 13.9133 0 14.0625 0C14.2117 0 14.3548 0.0592632 14.4602 0.164752C14.5657 0.270242 14.625 0.413316 14.625 0.5625V1.125H15.75C16.3467 1.125 16.919 1.36205 17.341 1.78401C17.7629 2.20597 18 2.77826 18 3.375V15.75C18 16.3467 17.7629 16.919 17.341 17.341C16.919 17.7629 16.3467 18 15.75 18H2.25C1.65326 18 1.08097 17.7629 0.65901 17.341C0.237053 16.919 0 16.3467 0 15.75V3.375C0 2.77826 0.237053 2.20597 0.65901 1.78401C1.08097 1.36205 1.65326 1.125 2.25 1.125H3.375V0.5625C3.375 0.413316 3.43426 0.270242 3.53975 0.164752C3.64524 0.0592632 3.78832 0 3.9375 0V0ZM1.125 4.5V15.75C1.125 16.0484 1.24353 16.3345 1.4545 16.5455C1.66548 16.7565 1.95163 16.875 2.25 16.875H15.75C16.0484 16.875 16.3345 16.7565 16.5455 16.5455C16.7565 16.3345 16.875 16.0484 16.875 15.75V4.5H1.125Z"
                                                        fill="#333333" />
                                                </svg>
                                                <input type="date" class="form-control to-date pl-5 dob"
                                                    name="passengers[{{ $i }}][dob]" readonly="true"
                                                    autocomplete="off" required="" tabindex="4">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                            <label>Gender</label>
                                            <div class="form-group">
                                                <select name="passengers[{{ $i }}][passenger_gender]"
                                                    class="form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                            <label>Nationality</label>
                                            <div class="form-group">
                                                <select name="passengers[{{ $i }}][nationality]" class="form-control" required>
                                                    <option value="">Select Country</option>
                                                    @foreach (Countries() as $country)
                                                        <option value="{{ $country->code }}">{{ substr($country->name, 0, 35) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 ">
                                            <label>Passport</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    name="passengers[{{ $i }}][document_number]"
                                                    required="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 ">
                                            <label>Passport Expiry</label>
                                            <div class="date-input date-from mb-0 date-return-active">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none">
                                                    <path
                                                        d="M3.9375 0C4.08668 0 4.22976 0.0592632 4.33525 0.164752C4.44074 0.270242 4.5 0.413316 4.5 0.5625V1.125H13.5V0.5625C13.5 0.413316 13.5593 0.270242 13.6648 0.164752C13.7702 0.0592632 13.9133 0 14.0625 0C14.2117 0 14.3548 0.0592632 14.4602 0.164752C14.5657 0.270242 14.625 0.413316 14.625 0.5625V1.125H15.75C16.3467 1.125 16.919 1.36205 17.341 1.78401C17.7629 2.20597 18 2.77826 18 3.375V15.75C18 16.3467 17.7629 16.919 17.341 17.341C16.919 17.7629 16.3467 18 15.75 18H2.25C1.65326 18 1.08097 17.7629 0.65901 17.341C0.237053 16.919 0 16.3467 0 15.75V3.375C0 2.77826 0.237053 2.20597 0.65901 1.78401C1.08097 1.36205 1.65326 1.125 2.25 1.125H3.375V0.5625C3.375 0.413316 3.43426 0.270242 3.53975 0.164752C3.64524 0.0592632 3.78832 0 3.9375 0V0ZM1.125 4.5V15.75C1.125 16.0484 1.24353 16.3345 1.4545 16.5455C1.66548 16.7565 1.95163 16.875 2.25 16.875H15.75C16.0484 16.875 16.3345 16.7565 16.5455 16.5455C16.7565 16.3345 16.875 16.0484 16.875 15.75V4.5H1.125Z"
                                                        fill="#333333" />
                                                </svg>
                                                <input type="date" class="form-control to-date pl-5 passport_expiry"
                                                    name="passengers[{{ $i }}][document_expiry_date]"
                                                    readonly="true" autocomplete="off" required="" tabindex="4">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="passengers[{{ $i }}][passenger_type]"
                                        value="INF">
                                    <input type="hidden" name="passengers[{{ $i }}][document_type]"
                                        value="P">
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endfor
                    @endif
                    <div class="ant-row mt-3 text-end">
                        <input type="hidden" name="ref_key" value="{{ $ref_key }}">
                        <div class="ant-col ant-col-24">
                            <button type="submit" class="green_btn w-30">
                                <span>Submit</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4 right-flight-summary">

                <div class="bg-white booking-reviews-part f-14px p-3 mb-3">
                    <div class="reliable-part d-flex gap-2 align-items-center">
                        <div class="ant-image" style="width: 40px; height: 40px;">
                            <img alt="" class="ant-image-img"
                                src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTMzLjg2MzMgNi42MzY3MkwyMC41ODk4IDIuMTEzMjhDMjAuNDI5NyAyLjA1ODU5IDIwLjIxNDggMi4wMzEyNSAyMCAyLjAzMTI1QzE5Ljc4NTIgMi4wMzEyNSAxOS41NzAzIDIuMDU4NTkgMTkuNDEwMiAyLjExMzI4TDYuMTM2NzIgNi42MzY3MkM1LjgxMjUgNi43NDYwOSA1LjU0Njg4IDcuMTIxMDkgNS41NDY4OCA3LjQ2NDg0VjI2LjMwODZDNS41NDY4OCAyNi42NTIzIDUuNzY5NTMgMjcuMTA1NSA2LjAzOTA2IDI3LjMyMDNMMTkuNTAzOSAzNy44MTI1QzE5LjY0MDYgMzcuOTE4IDE5LjgxNjQgMzcuOTcyNyAxOS45OTYxIDM3Ljk3MjdDMjAuMTc1OCAzNy45NzI3IDIwLjM1NTUgMzcuOTE4IDIwLjQ4ODMgMzcuODEyNUwzMy45NTMxIDI3LjMyMDNDMzQuMjIyNyAyNy4xMDk0IDM0LjQ0NTMgMjYuNjU2MiAzNC40NDUzIDI2LjMwODZWNy40NjQ4NEMzNC40NTMxIDcuMTIxMDkgMzQuMTg3NSA2Ljc1IDMzLjg2MzMgNi42MzY3MlpNMzEuNjQwNiAyNS41NTg2TDIwIDM0LjYyODlMOC4zNTkzOCAyNS41NTg2VjguODU1NDdMMjAgNC44ODY3MkwzMS42NDA2IDguODU1NDdWMjUuNTU4NloiIGZpbGw9IiMwQTU0OUMiLz4KPHBhdGggZD0iTTguMzU5MzggOC44NTYwOFYyNS41NTkyTDIwIDM0LjYyOTVMMzEuNjQwNiAyNS41NTkyVjguODU2MDhMMjAgNC44ODczM0w4LjM1OTM4IDguODU2MDhaTTI0LjcxODggMTIuODEzMUgyNi44NzVDMjcuMTI4OSAxMi44MTMxIDI3LjI3NzMgMTMuMTAyMiAyNy4xMjg5IDEzLjMwOTJMMTguODI0MiAyNC43NDI4QzE4Ljc2NTggMjQuODIyNyAxOC42ODk0IDI0Ljg4NzcgMTguNjAxMiAyNC45MzI1QzE4LjUxMjkgMjQuOTc3MyAxOC40MTU0IDI1LjAwMDcgMTguMzE2NCAyNS4wMDA3QzE4LjIxNzQgMjUuMDAwNyAxOC4xMTk5IDI0Ljk3NzMgMTguMDMxNiAyNC45MzI1QzE3Ljk0MzQgMjQuODg3NyAxNy44NjcgMjQuODIyNyAxNy44MDg2IDI0Ljc0MjhMMTIuODcxMSAxNy45NDU5QzEyLjcyMjcgMTcuNzM4OSAxMi44NzExIDE3LjQ0OTggMTMuMTI1IDE3LjQ0OThIMTUuMjgxM0MxNS40ODQ0IDE3LjQ0OTggMTUuNjcxOSAxNy41NDc1IDE1Ljc4OTEgMTcuNzA3NkwxOC4zMTY0IDIxLjE4ODFMMjQuMjEwOSAxMy4wNzA5QzI0LjMyODEgMTIuOTEwOCAyNC41MTk1IDEyLjgxMzEgMjQuNzE4OCAxMi44MTMxWiIgZmlsbD0iI0U3RUVGNSIvPgo8cGF0aCBkPSJNMTUuNzg3NSAxNy43MDdDMTUuNjcwNCAxNy41NDY5IDE1LjQ4MjkgMTcuNDQ5MiAxNS4yNzk3IDE3LjQ0OTJIMTMuMTIzNUMxMi44Njk2IDE3LjQ0OTIgMTIuNzIxMSAxNy43MzgzIDEyLjg2OTYgMTcuOTQ1M0wxNy44MDcxIDI0Ljc0MjJDMTcuODY1NSAyNC44MjIxIDE3Ljk0MTkgMjQuODg3MSAxOC4wMzAxIDI0LjkzMTlDMTguMTE4NCAyNC45NzY3IDE4LjIxNTkgMjUuMDAwMSAxOC4zMTQ5IDI1LjAwMDFDMTguNDEzOSAyNS4wMDAxIDE4LjUxMTQgMjQuOTc2NyAxOC41OTk3IDI0LjkzMTlDMTguNjg3OSAyNC44ODcxIDE4Ljc2NDMgMjQuODIyMSAxOC44MjI3IDI0Ljc0MjJMMjcuMTI3NCAxMy4zMDg2QzI3LjI3NTggMTMuMTAxNiAyNy4xMjc0IDEyLjgxMjUgMjYuODczNSAxMi44MTI1SDI0LjcxNzJDMjQuNTE4IDEyLjgxMjUgMjQuMzI2NiAxMi45MTAyIDI0LjIwOTQgMTMuMDcwM0wxOC4zMTQ5IDIxLjE4NzVMMTUuNzg3NSAxNy43MDdaIiBmaWxsPSIjMEE1NDlDIi8+Cjwvc3ZnPgo="
                                width="40" height="40" style="height: 40px;">
                        </div>
                        <span class="ant-typography text-base font-secondary line-height-24">Pakistan's most reliable
                            booking platform!</span>
                    </div>
                    <div class="booking-review-stars">
                    </div>
                </div>

                <div class="bg-white mb-3 sign-in-for-booking f-14px {{ $display }}">
                    <div class="p-4">
                        <div class="d-flex mb-4">
                            <div class=" me-3">
                                <div class="ant-image" style="width: 90px; height: 70px;">
                                    <img src="{{asset('assets/fonts/users-with-bags.png')}}" alt="">
                                </div>
                            </div>
                            <div class="ant-col ant-col-15">
                                <span class="ant-typography ant-typography-secondary card-content"> Sign In to book faster
                                    using Passenger Quick Pick and exclusive vouchers!</span>
                            </div>
                        </div>
                        <div class="ant-row">
                            <div class="ant-col ant-col-24">
                                <button type="button" class="green_btn w-100">
                                    <span>Start</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                // dd($result);
                    $CurrencyCode = $result['Flights'][0]['Fares'][0]['Currency'];
                    $TotalPrice = $result['Flights'][0]['Fares'][0]['TotalFare'];
                @endphp
                <div class="flight-summary-wrapper checkout-booking-confirm">
                    <div class="flight-summary-header">Price Summary</div>
                    {{-- @dd($result['Flights'][0]['Fares'][0]['PassengerFares']) --}}
                    @foreach ($result['Flights'][0]['Fares'][0]['PassengerFares'] as $key => $fare)
                        <div
                            class="flight-passenger-price-summary p-3 d-flex justify-content-between align-items-center f-14px">
                            <span class="flight-booked-airline-and-passenger">Pakistan Airline ({{ $fare['PaxType'] }} x
                                {{ $fare['Quantity'] }})</span>
                            <span class="flight-booked-price">{{ $CurrencyCode }}
                                {{ $fare['BasePrice'] * $fare['Quantity'] }}</span>
                        </div>
                    @endforeach

                    <div class="flight-passenger-price-summary p-3 d-flex justify-content-between align-items-center">
                        <span class="flight-booked-airline-and-passenger">Price you pay</span>
                        <span class="flight-booked-price">{{ $CurrencyCode }} {{ $TotalPrice }}</span>
                    </div>
                </div>
                <div class="booking-card-trigger mt-4 f-14px d-flex align-items-center gap-1">
                    Your Bookings <i class="fa fa-angle-down"></i>
                </div>
                {{-- @dd($result) --}}
                @foreach ($result['Flights'] as $offer)
                    @php
                        $stops = count($offer['Segments']) - 1;
                        // $totalDuration = $offer['TotalDuration'];
                        $totalDuration = str_replace(["Hours", "Minutes"], ["H", "M"], $offer['TotalDuration']);
                    @endphp
                    @foreach ($offer['Segments'] as $segKey => $segment)
                        @php
                            $originCode = $offer['Segments'][0]['Departure']['LocationCode'];
                            $destinationCode = $segment['Arrival']['LocationCode'];
                            $departure_date = date('d M Y', strtotime($offer['Segments'][0]['Departure']['DepartureDateTime']));
                            $departure_date2 = date('d M', strtotime($offer['Segments'][0]['Departure']['DepartureDateTime']));
                            $arrival_date = date('d M Y', strtotime($segment['Arrival']['ArrivalDateTime']));
                            $arrival_date2 = date('d M', strtotime($segment['Arrival']['ArrivalDateTime']));
                            $dapartTime = date('H:i', strtotime($offer['Segments'][0]['Departure']['DepartureDateTime']));
                            $arrtivelTime = date('H:i', strtotime($segment['Arrival']['ArrivalDateTime']));
                            $flightCode = $segment['OperatingAirline']['Code'];

                            $airName = AirlineNameByAirlineCode($flightCode);
                            $airName = strlen($airName) > 20 ? substr($airName, 0, 13) . '...' : $airName;
                            // $duration = $segment['Duration'];
                            // $duration = str_replace(['PT', 'H'], ['', 'H '], $duration);

                            $Baggage = $offer['Fares'][0]['BaggagePolicy'];
                            $cabin = $segment['Cabin'];
                            // ---------------------------------------
                            $layover = null;
                            if ($segKey > 0) {
                                $currentDeparture = new DateTime($segment['Departure']['DepartureDateTime']);
                                $previousArrival = new DateTime($offer['Segments'][$segKey - 1]['Arrival']['ArrivalDateTime']);
                                $layover = $currentDeparture->diff($previousArrival)->format('%H:%I');
                            }
                        @endphp
                    @endforeach
                    <div class="result-flight-item mb-3 mt-3 flight-confirmation-card flight-booking-card">
                        <div class="booked-flight-date f-12px">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="_1MZrIK28AE8HVj289UBgZw st-svg-icon ">
                                <g>
                                    <path
                                        d="M20.9062 1.87524H18.75V0.750244C18.75 0.336057 18.4142 0.000244141 18 0.000244141C17.5858 0.000244141 17.25 0.336057 17.25 0.750244V1.87524H6.75V0.750244C6.75 0.336057 6.41423 0.000244141 6 0.000244141C5.58577 0.000244141 5.25 0.336057 5.25 0.750244V1.87524H3.09375C1.38783 1.87524 0 3.26307 0 4.96899V20.9065C0 22.6124 1.38783 24.0002 3.09375 24.0002H20.9062C22.6122 24.0002 24 22.6124 24 20.9065V4.96899C24 3.26307 22.6122 1.87524 20.9062 1.87524ZM22.5 20.9065C22.5 21.7867 21.7865 22.5002 20.9062 22.5002H3.09375C2.21353 22.5002 1.5 21.7867 1.5 20.9065V8.48462C1.5 8.3552 1.60495 8.25024 1.73438 8.25024H22.2656C22.395 8.25024 22.5 8.3552 22.5 8.48462V20.9065Z"
                                        fill="black"></path>
                                </g>
                                <defs>
                                    <clipPath>
                                        <rect width="24" height="24" fill="white"
                                            transform="translate(0 0.000244141)"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                            {{-- <span>Monday 13 Nov, 2023</span> --}}
                            <span>{{ $departure_date }}</span>
                        </div>
                        <div class="flight-item-wrapper">
                            <div class="flight-details">
                                <div class="flight-brand-info text-center">
                                    <div class="flight-brand-img">
                                        <img src="{{ asset('assets/airlines/' . $flightCode . '.png') }}" />
                                    </div>
                                    <div class="flight-brand-name f-12px">{{ $airName }}</div>
                                </div>
                                <div class="flight-details-location align-items-center justify-content-center d-flex flex-column">
                                    <div
                                        class="one-time-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                        <span
                                            class="flight-details-location-name">{{ CityNameByAirportCode($originCode) }}
                                            ({{ $originCode }})</span>
                                        <span class="flight-details-location-time f-14px">{{ $departure_date2 }}
                                            {{ $dapartTime }}</span>
                                    </div>
                                    <div style="display: none !important;"
                                        class="return-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                        <span
                                            class="flight-details-location-name">{{ CityNameByAirportCode($originCode) }}
                                            ({{ $originCode }})</span>
                                        <span class="flight-details-location-time f-14px">{{ $departure_date2 }}
                                            {{ $dapartTime }}</span>
                                    </div>
                                </div>
                                <div
                                    class="flight-details-duration ps-3 pe-3 justify-content-center d-flex flex-column align-items-center">
                                    <div
                                        class="onetime-flight-duration w-100 d-flex flex-column justify-content-center align-content-center">
                                        <div
                                            class="flight-details-duration-badges justify-content-center  gap-1 d-flex flex-row align-items-center">
                                            <span class="flight-details-duration-lowest me-2">
                                                <span class="low-fare-tag">Lowest fare</span>
                                            </span>
                                            <span class="flight-details-duration-hours f-12px d-flex flex-nowrap">
                                                @if ($stops <= 1)
                                                    {{ $stops }} Stop
                                                @else
                                                    {{ $stops }} Stops
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flight-details-duration-widget d-flex align-items-center gap-1 w-100">
                                            <span class="flight-details-duration-flight-icon">
                                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                                    fill-rule="evenodd" clip-rule="evenodd">
                                                    <path
                                                        d="M20.012 18v2h-20v-2h20zm3.973-13.118c.154 1.349-.884 2.615-1.927 3.491-.877.735-9.051 6.099-9.44 6.307-1.756.936-3.332 1.306-4.646 1.32-1.36.014-2.439-.354-3.144-.872l-4.784-3.977 3.742-2.373 4.203 1.445.984-.578-4.973-3.645 3.678-2.124 7.992 1.545c.744-.445 1.482-.9 2.225-1.348 1.049-.623 2.056-1.055 3.387-1.055 1.321 0 2.552.52 2.703 1.864zm-4.341.512c-.419.192-3.179 1.882-3.615 2.144l-8.01-1.55-.418.241 5.288 3.307-4.683 2.876-4.214-1.448-.69.395c.917.729 1.787 1.522 2.751 2.186 1.472.962 4.344.22 5.685-.663.9-.592 7.551-4.961 8.436-5.582.605-.431 1.797-1.414 1.824-2.152l.001-.004c-.644-.287-1.716-.041-2.355.25z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <div class="seprator"></div>
                                            <span class="flight-details-duration-flight-icon">
                                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                                    fill-rule="evenodd" clip-rule="evenodd">
                                                    <path
                                                        d="M24.012 20h-20v-2h20v2zm-2.347-5.217c-.819 1.083-2.444 1.284-3.803 1.2-1.142-.072-10.761-1.822-11.186-1.939-1.917-.533-3.314-1.351-4.276-2.248-.994-.927-1.557-1.902-1.676-2.798l-.724-4.998 3.952.782 2.048 2.763 1.886.386-1.344-4.931 4.667 1.095 4.44 5.393 2.162.51c1.189.272 2.216.653 3.181 1.571.957.911 1.49 2.136.673 3.214zm-3.498-2.622c-.436-.15-3.221-.781-3.717-.892l-4.45-5.409-.682-.164 1.481 4.856-5.756-1.193-2.054-2.773-.772-.19.486 2.299c.403 1.712 2.995 3.155 4.575 3.439 1.06.192 8.89 1.612 9.959 1.773.735.105 2.277.214 2.805-.302l.003-.002c-.268-.652-1.214-1.213-1.878-1.442z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div
                                            class="flight-details-duration-hours justify-content-center gap-1 align-items-center d-flex flex-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 14 14" fill="none">
                                                <path
                                                    d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z"
                                                    fill="#333333"></path>
                                            </svg>
                                            <div class="hour d-flex f-12px flex-nowrap">
                                                <div>{{ $totalDuration }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: none !important;"
                                        class="return-flight-duration w-100 d-flex flex-column justify-content-center align-content-center">
                                        <div
                                            class="flight-details-duration-badges justify-content-center gap-1 d-flex flex-row align-items-center">
                                            <span class="flight-details-duration-lowest me-2">
                                                <span class="low-fare-tag">Lowest fare</span>
                                            </span>
                                            <span class="flight-details-duration-hours f-12px d-flex flex-nowrap">1 stop at
                                                JED</span>
                                        </div>
                                        <div class="flight-details-duration-widget d-flex align-items-center gap-1 w-100">
                                            <span class="flight-details-duration-flight-icon">
                                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                                    fill-rule="evenodd" clip-rule="evenodd">
                                                    <path
                                                        d="M20.012 18v2h-20v-2h20zm3.973-13.118c.154 1.349-.884 2.615-1.927 3.491-.877.735-9.051 6.099-9.44 6.307-1.756.936-3.332 1.306-4.646 1.32-1.36.014-2.439-.354-3.144-.872l-4.784-3.977 3.742-2.373 4.203 1.445.984-.578-4.973-3.645 3.678-2.124 7.992 1.545c.744-.445 1.482-.9 2.225-1.348 1.049-.623 2.056-1.055 3.387-1.055 1.321 0 2.552.52 2.703 1.864zm-4.341.512c-.419.192-3.179 1.882-3.615 2.144l-8.01-1.55-.418.241 5.288 3.307-4.683 2.876-4.214-1.448-.69.395c.917.729 1.787 1.522 2.751 2.186 1.472.962 4.344.22 5.685-.663.9-.592 7.551-4.961 8.436-5.582.605-.431 1.797-1.414 1.824-2.152l.001-.004c-.644-.287-1.716-.041-2.355.25z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <div class="seprator"></div>
                                            <span class="flight-details-duration-flight-icon">
                                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                                    fill-rule="evenodd" clip-rule="evenodd">
                                                    <path
                                                        d="M24.012 20h-20v-2h20v2zm-2.347-5.217c-.819 1.083-2.444 1.284-3.803 1.2-1.142-.072-10.761-1.822-11.186-1.939-1.917-.533-3.314-1.351-4.276-2.248-.994-.927-1.557-1.902-1.676-2.798l-.724-4.998 3.952.782 2.048 2.763 1.886.386-1.344-4.931 4.667 1.095 4.44 5.393 2.162.51c1.189.272 2.216.653 3.181 1.571.957.911 1.49 2.136.673 3.214zm-3.498-2.622c-.436-.15-3.221-.781-3.717-.892l-4.45-5.409-.682-.164 1.481 4.856-5.756-1.193-2.054-2.773-.772-.19.486 2.299c.403 1.712 2.995 3.155 4.575 3.439 1.06.192 8.89 1.612 9.959 1.773.735.105 2.277.214 2.805-.302l.003-.002c-.268-.652-1.214-1.213-1.878-1.442z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div
                                            class="flight-details-duration-hours justify-content-center gap-1 align-items-center d-flex flex-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 14 14" fill="none">
                                                <path
                                                    d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z"
                                                    fill="#333333"></path>
                                            </svg>
                                            <div class="hour d-flex f-12px flex-nowrap">
                                                <div>10h</div>
                                            </div>
                                            <div class="minutes d-flex f-12px flex-nowrap">
                                                <div>55m</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="flight-details-location d-flex flex-column align-items-center justify-content-center">
                                    <div
                                        class="one-time-flight-info text-center  d-flex flex-column justify-content-center align-items-center">
                                        <span
                                            class="flight-details-location-name">{{ CityNameByAirportCode($destinationCode) }}
                                            ({{ $destinationCode }})</span>
                                        <span class="flight-details-location-time f-14px">{{ $arrtivelTime }}
                                            {{ $arrival_date2 }}</span>
                                    </div>
                                    <div style="display: none !important;" class="return-flight-info text-center">
                                        <span
                                            class="flight-details-location-name">{{ CityNameByAirportCode($destinationCode) }}
                                            ({{ $destinationCode }})</span>
                                        <span class="flight-details-location-time">{{ $arrival_date2 }}
                                            {{ $arrtivelTime }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="flight-details-popup-wrapper">
                            <div class="flight-details-popup-overlay"></div>
                            <div class="flight-details-popup-inner">
                                <div class="details-popup-close">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"
                                        class="icon icon-close " fill="none" viewBox="0 0 18 17">
                                        <path
                                            d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z"
                                            fill="currentColor">
                                        </path>
                                    </svg>
                                </div>
                                <div class="details-popup-tabs-wrapper">
                                    <div data-tab="details" class="details-tab flight-details-tab tab-active">
                                        <span>Flight Details</span>
                                        <span class="d-none">Flight</span>
                                    </div>
                                    <div data-tab="baggage" class="details-tab flight-baggage-tab">
                                        <span>Baggage Information</span>
                                        <span class="d-none">Baggage</span>
                                    </div>
                                    <div data-tab="fare" class="details-tab flight-fare-tab">
                                        <span>Fare Details</span>
                                        <span class="d-none">Fare</span>
                                    </div>
                                </div>
                                <hr class="details-tabs-content-divider">
                                <div class="details-popup-content-wrapper">
                                    <div class="details-content flight-details-content details content-active">
                                        <div class="details-date-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                viewBox="0 0 28 28" fill="none">
                                                <g clip-path="url(#clip0)">
                                                    <path
                                                        d="M25.0391 2.12324H24.1391V0.773241C24.1391 0.524729 23.9376 0.323242 23.6891 0.323242C23.4405 0.323242 23.2391 0.524729 23.2391 0.773241V2.12324H19.6391V0.773241C19.6391 0.524729 19.4376 0.323242 19.1891 0.323242C18.9406 0.323242 18.7391 0.524729 18.7391 0.773241V2.12324H15.1391V0.773241C15.1391 0.524729 14.9376 0.323242 14.6891 0.323242C14.4406 0.323242 14.2391 0.524729 14.2391 0.773241V2.12324H10.6391V0.773241C10.6391 0.524729 10.4376 0.323242 10.1891 0.323242C9.94057 0.323242 9.73908 0.524729 9.73908 0.773241V2.12324H6.13909V0.773241C6.13909 0.524729 5.9376 0.323242 5.68909 0.323242C5.44058 0.323242 5.23909 0.524729 5.23909 0.773241V2.12324H4.33909C3.0971 2.1247 2.09056 3.13124 2.0891 4.37323V15.3775C-0.354227 18.1384 -0.304558 22.3024 2.20385 25.0043C2.32872 25.144 2.46125 25.2766 2.60075 25.4016L2.6048 25.4057H2.6075C5.30867 27.9154 9.47319 27.9662 12.2348 25.5231H25.0391C26.281 25.5217 27.2876 24.5151 27.289 23.2731V4.37318C27.2875 3.13118 26.281 2.1247 25.0391 2.12324ZM11.7899 24.744C9.36761 26.9851 5.628 26.9826 3.20864 24.7383C3.089 24.6309 2.97526 24.517 2.86799 24.3972C0.500097 21.8378 0.655346 17.8433 3.21477 15.4754C5.7742 13.1074 9.76873 13.2627 12.1367 15.8222C14.5046 18.3816 14.3494 22.3761 11.7899 24.744ZM26.389 23.2732C26.389 24.0188 25.7846 24.6232 25.0391 24.6232H13.1051C13.16 24.5552 13.2081 24.4828 13.2599 24.413C13.3116 24.3433 13.3562 24.2861 13.4016 24.2204C13.502 24.076 13.5956 23.927 13.6847 23.7754C13.7108 23.7304 13.74 23.6894 13.7648 23.6449C13.8758 23.4475 13.977 23.2451 14.0685 23.0378C14.0919 22.9852 14.1108 22.9307 14.1329 22.8776C14.1981 22.721 14.2593 22.5626 14.3129 22.402C14.3385 22.3264 14.3606 22.2499 14.3831 22.1734C14.4281 22.0289 14.4654 21.8831 14.4992 21.736C14.5176 21.6554 14.5356 21.5753 14.5518 21.4939C14.5815 21.34 14.6054 21.1843 14.6252 21.0277C14.6342 20.9557 14.6459 20.8841 14.6531 20.8117C14.6751 20.5835 14.6891 20.354 14.6891 20.1232C14.6843 16.1487 11.4636 12.9279 7.48909 12.9232C7.25824 12.9232 7.02874 12.9372 6.80059 12.9592C6.72814 12.9664 6.65659 12.9781 6.58414 12.9871C6.42799 13.0074 6.27274 13.0321 6.11839 13.0605C6.03694 13.0767 5.95639 13.0947 5.87584 13.1131C5.72914 13.147 5.58407 13.1856 5.44069 13.2288C5.36329 13.2517 5.28589 13.2738 5.20939 13.2994C5.05144 13.3525 4.89439 13.4128 4.74229 13.4763C4.68559 13.4997 4.62844 13.5213 4.57264 13.5442C4.36744 13.6342 4.16764 13.7355 3.97055 13.8457C3.9206 13.8736 3.87335 13.906 3.82385 13.9357C3.6785 14.0221 3.5354 14.1117 3.3959 14.2057C3.32705 14.2534 3.2609 14.3047 3.1934 14.3547C3.1259 14.4046 3.05525 14.4532 2.9891 14.5072V7.52323H26.389V23.2732ZM26.389 6.62323H2.9891V4.37323C2.9891 3.62764 3.5935 3.02324 4.33909 3.02324H5.23909V4.37323C5.23909 4.62175 5.44058 4.82323 5.68909 4.82323C5.9376 4.82323 6.13909 4.62175 6.13909 4.37323V3.02324H9.73908V4.37323C9.73908 4.62175 9.94057 4.82323 10.1891 4.82323C10.4376 4.82323 10.6391 4.62175 10.6391 4.37323V3.02324H14.2391V4.37323C14.2391 4.62175 14.4406 4.82323 14.6891 4.82323C14.9376 4.82323 15.1391 4.62175 15.1391 4.37323V3.02324H18.7391V4.37323C18.7391 4.62175 18.9406 4.82323 19.1891 4.82323C19.4376 4.82323 19.6391 4.62175 19.6391 4.37323V3.02324H23.2391V4.37323C23.2391 4.62175 23.4405 4.82323 23.6891 4.82323C23.9376 4.82323 24.1391 4.62175 24.1391 4.37323V3.02324H25.0391C25.7846 3.02324 26.389 3.62764 26.389 4.37323V6.62323Z"
                                                        fill="#555555" />
                                                    <path
                                                        d="M7.48886 15.1729C7.24035 15.1729 7.03886 15.3743 7.03886 15.6229V19.6728H4.78887C4.54035 19.6728 4.33887 19.8743 4.33887 20.1228C4.33887 20.3714 4.54035 20.5728 4.78887 20.5728H7.48886C7.73737 20.5728 7.93886 20.3714 7.93886 20.1228V15.6229C7.93886 15.3743 7.73737 15.1729 7.48886 15.1729Z"
                                                        fill="#555555" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0">
                                                        <rect width="27" height="27" fill="white"
                                                            transform="translate(0.289062 0.322266)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <div>
                                                <p>30 Sep 2023</p>
                                                <p>Saturday</p>
                                            </div>
                                        </div>
                                        <div class="details-flight-step">
                                            <img src="{{ asset('assets/airlines/' . $flightCode . '.png') }}" alt="J9">
                                            <ul>
                                                <li class="flight-details-location">
                                                    <strong>01:25</strong>
                                                    <strong>Lahore</strong>
                                                    Allama Iqbal International (LHE)
                                                </li>
                                                <li class="flight-details-travel-time">
                                                    <p>Pakistan Airlines</p>
                                                    <p>Travel time: <strong>4h 00m</strong></p>
                                                </li>
                                                <li class="flight-details-location">
                                                    <strong>03:25</strong>
                                                    <strong>Kuwait City</strong>
                                                    Kuwait International (KWI)
                                                </li>
                                            </ul>
                                            <div class="flight-details_luggage-info">
                                                <p>Flight no: <strong>J9502</strong></p>
                                                <p>Cabin: <strong>Economy</strong></p>
                                            </div>
                                        </div>
                                        <div class="flight-details-transit-info">
                                            <div class="flight-details-transit-airport">
                                                <div class="flight-details-msg-info">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                                        viewBox="0 0 18 16" fill="none">
                                                        <g clip-path="url(#clip0)">
                                                            <path
                                                                d="M9.26756 0C4.58076 0 0.767578 3.58888 0.767578 7.99998C0.767578 12.4111 4.58076 16 9.26756 16C13.9544 16 17.7675 12.4111 17.7675 7.99998C17.7675 3.58888 13.9544 0 9.26756 0ZM9.26756 15.3043C4.988 15.3043 1.5067 12.0278 1.5067 7.99998C1.5067 3.97216 4.988 0.695641 9.26756 0.695641C13.5471 0.695641 17.0284 3.97216 17.0284 7.99998C17.0284 12.0278 13.5471 15.3043 9.26756 15.3043Z"
                                                                fill="black" />
                                                            <path
                                                                d="M12.8548 10.8848L9.63661 7.85594V2.43475C9.63661 2.24275 9.47104 2.08691 9.26704 2.08691C9.06304 2.08691 8.89746 2.24275 8.89746 2.43475V7.99997C8.89746 8.09248 8.93665 8.18085 9.00539 8.24623L12.3315 11.3767C12.4039 11.4441 12.4985 11.4782 12.5931 11.4782C12.6877 11.4782 12.7823 11.4442 12.8548 11.3767C12.9989 11.241 12.9989 11.0205 12.8548 10.8848Z"
                                                                fill="black" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0">
                                                                <rect x="0.767578" width="17" height="16"
                                                                    rx="5" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                    3h 55m layover - Kuwait International (KWI)
                                                </div>
                                            </div>
                                        </div>
                                        <div class="details-flight-step">
                                            <img src="{{ asset('assets/airlines/' . $flightCode . '.png') }}" alt="J9">
                                            <ul>
                                                <li class="flight-details-location">
                                                    <strong>01:25</strong>
                                                    <strong>Lahore</strong>
                                                    Allama Iqbal International (LHE)
                                                </li>
                                                <li class="flight-details-travel-time">
                                                    <p>Pakistan Airlines</p>
                                                    <p>Travel time: <strong>4h 00m</strong></p>
                                                </li>
                                                <li class="flight-details-location">
                                                    <strong>03:25</strong>
                                                    <strong>Kuwait City</strong>
                                                    Kuwait International (KWI)
                                                </li>
                                            </ul>
                                            <div class="flight-details_luggage-info">
                                                <p>Flight no: <strong>J9502</strong></p>
                                                <p>Cabin: <strong>Economy</strong></p>
                                            </div>
                                        </div>
                                        <div class="details-date-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M12 0C7.34756 0 3.5625 3.78506 3.5625 8.4375C3.5625 10.0094 3.99792 11.5434 4.82198 12.8743L11.5197 23.6676C11.648 23.8744 11.874 24 12.1171 24C12.119 24 12.1208 24 12.1227 24C12.3679 23.9981 12.5944 23.8686 12.7204 23.6582L19.2474 12.7603C20.026 11.4576 20.4375 9.96277 20.4375 8.4375C20.4375 3.78506 16.6524 0 12 0ZM18.0406 12.0383L12.1065 21.9462L6.0172 12.1334C5.33128 11.0257 4.95938 9.74766 4.95938 8.4375C4.95938 4.56047 8.12297 1.39687 12 1.39687C15.877 1.39687 19.0359 4.56047 19.0359 8.4375C19.0359 9.7088 18.6885 10.9541 18.0406 12.0383Z"
                                                    fill="#555555" />
                                                <path
                                                    d="M12 4.21875C9.67378 4.21875 7.78125 6.11128 7.78125 8.4375C7.78125 10.7489 9.64298 12.6562 12 12.6562C14.3861 12.6562 16.2188 10.7235 16.2188 8.4375C16.2188 6.11128 14.3262 4.21875 12 4.21875ZM12 11.2594C10.4411 11.2594 9.17813 9.9922 9.17813 8.4375C9.17813 6.88669 10.4492 5.61563 12 5.61563C13.5508 5.61563 14.8172 6.88669 14.8172 8.4375C14.8172 9.96952 13.5836 11.2594 12 11.2594Z"
                                                    fill="#555555" />
                                            </svg>
                                            <div>
                                                <p>30 Sep 2023</p>
                                                <p>Saturday</p>
                                            </div>
                                        </div>
                                        <div class="flight-details-arrive-destination">
                                            <label>Arrive at destination</label>
                                            <p class="m-0">Dubai</p>
                                        </div>
                                    </div>
                                    <div class="details-content flight-baggage-content baggage">
                                        <div class="content-header d-flex justify-content-between align-items-center">
                                            <span>Flight from Dubai to Islamabad on Tuesday, 24 October 2023</span>
                                            <span class="stop-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 14 14" fill="none">
                                                    <path
                                                        d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z"
                                                        fill="#333333"></path>
                                                </svg>
                                                1 Stop
                                            </span>
                                        </div>
                                        <div
                                            class="details-content-inner d-flex justify-content-between align-items-center">
                                            <div class="flight-brand-info text-center">
                                                <div class="flight-brand-img">
                                                    <img src="{{ asset('assets/airlines/' . $flightCode . '.png') }}" />
                                                </div>
                                                <div class="flight-brand-name f-12px">Pakistan Airlines</div>
                                            </div>
                                            <div class="flight-baggage-info">
                                                <div class="carry-on-baggage f-14px"><span class="font-500">Carry-on:
                                                    </span>7KG/person</div>
                                                <div class="check-in-baggage f-14px"><span class="font-500">Check-in:
                                                    </span>Adult: 0 KG</div>
                                            </div>
                                            <div class="flight-baggage-charges text-center">
                                                <div class="flight-baggage-text carry-on-charges f-14px font-500">Free
                                                </div>
                                                <div class="flight-baggage-text carry-on-charges f-14px font-500">Free
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="details-content flight-fare-content fare">
                                        <div class="details-content-inner">
                                            <div class="content-header d-flex justify-content-between align-items-center">
                                                <span class="font-500">Fare Details</span>
                                                <span class="refund-info">
                                                    Non-Refundable
                                                </span>
                                            </div>
                                            <div class="fare-details-inner">
                                                <div class="base-fare font-500">Base Fare: <span>AED 90</span></div>
                                                <div class="fare-tax-fee font-500">Taxes & Fees : <span>AED 400</span>
                                                </div>
                                                <div class="total-fare-value font-500">Total (incl. VAT): <span>AED
                                                        490</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- checkout step 1 main section end -->


@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            // ----------------Date picker--------------
            var currentDate = new Date();
            $('.dob').datepicker({
                format: 'yyyy-mm-dd',
                maxDate: currentDate, // Set minimum date to today
            });
            $('.passport_expiry').datepicker({
                format: 'yyyy-mm-dd',
                minDate: currentDate, // Set minimum date to today
            });

        });
    </script>
@endsection
