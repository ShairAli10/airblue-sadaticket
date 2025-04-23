@extends('admin.layouts.app')


@section('styles')
    <link href="{{ asset('assets/css/contact-profile2.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <style>
        .form-label {
            margin-bottom: 0px !important;
        }
        #price_detail,#flight_detail, .accordion-button:not(.collapsed) {
            background-color: unset;
        }
        .accordion-button.collapsed {
            background-color: rgba(59,118,225,0.5)!important;
        }
        .accordion-body{
            font-weight: 500;
        }
        .gj-textbox-md {
            border: 1px solid #e2e5e8;
            border-bottom: 1px solid #e2e5e8;
            display: block;
            font-family: Helvetica,Arial,sans-serif;
            font-size: .875rem;
            line-height: 1.5;
            padding: .47rem .75rem;
            margin: 0;
        }
        .gj-textbox-md:active, .gj-textbox-md:focus {
            border-bottom: 1px solid #e2e5e8;
        }
    </style>
@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h4 class="card-title fs-4 fw-bold">Passenger Detail</h4>
                                </div>
                                <div class="col-lg-4">
                                    <select id="formrow-inputState" class="form-select" onchange="loadCustomerData(this,'customer')">
                                        <option selected value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.flight.create.pnr') }}" method="POST" id="checkoutForm" class="needs-validation" novalidate>
                                @csrf
                                
                                {{-- --------------Passenger Detail--------------- --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="hidden" name="customer_id" id="customer_id">
                                            <input type="hidden" name="lf_id" value="{{ $lf_id }}">
                                            <label for="customer_name" class="form-label">Full Name</label>
                                            <input type="text" name="customer_name" class="form-control" required placeholder="Enter Full Name" id="customer_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customer_email" class="form-label">Email</label>
                                            <input type="email" name="customer_email" class="form-control" required placeholder="Enter Email" id="customer_email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="customer_country" class="form-label">Country Code</label>
                                        <select name="customer_country" class="form-select" required id="customer_country">
                                            <option selected value="">Select Country Code</option>
                                            @foreach (countryDialCodes() as $cntry_code)
                                            <option value="{{$cntry_code['name']}}">
                                                {{-- <img src="{{ asset('/assets/media/flags/afghanistan.svg')}}" alt=""> --}}
                                                {{$cntry_code['name']}} (+{{$cntry_code['dial_code']}})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customer_phone" class="form-label">Phone</label>
                                            <input type="number" name="customer_phone" class="form-control" required placeholder="Enter Phone Number" id="customer_phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="customer_address" class="form-label">Address</label>
                                            <textarea id="customer_address" name="customer_address" class="form-control" required placeholder="Enter Address" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                {{-- -----------------Contact Info---------------- --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label fs-5 " style="line-height: 30px;font-weight: bold;">Contact Info</label>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" required placeholder="Enter Email" id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">Country Code</label>
                                        <select name="country" class="form-select" required id="country">
                                            <option selected value="">Select Country Code</option>
                                            @foreach (countryDialCodes() as $cntry_code)
                                            <option value="{{$cntry_code['name']}}">
                                                {{-- <img src="{{ asset('/assets/media/flags/afghanistan.svg')}}" alt=""> --}}
                                                {{$cntry_code['name']}} (+{{$cntry_code['dial_code']}})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="number" name="phone" class="form-control" required placeholder="Enter Phone Number" id="phone">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                @php
                                    $i = 0;
                                @endphp
                                {{-------------------- Adults -----------------------}}
                                @if(@$query['adults'] > 0)
                                    @for ($adt = 1; $adt <= $query['adults']; $adt++)
                                        <div class="passenger_adults">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="adult_seletion_{{ $adt }}" class="form-label fs-5 fw-bold" style="line-height: 30px;font-weight: bold;">Adult ({{$adt}})</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select id="adult_seletion_{{ $adt }}" name="passengers[{{ $i }}][id]" onchange="loadPassengerData(this,'adult',{{ $adt }})" disabled class="form-select adult_select_option">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                            <input type="hidden" name="passengers[{{ $i }}][id]" id="adult_id_{{ $adt }}">
                                            <input type="hidden" name="passengers[{{ $i }}][passenger_type]" value="ADT">
                                            <div class="col-md-2">
                                                <label for="adult_title_{{ $adt }}" class="form-label">Title</label>
                                                <select id="adult_title_{{ $adt }}" name="passengers[{{ $i }}][passenger_title]" onchange="selectGenderByTitle(this,'adult',{{ $adt }})" class="form-select" required>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Ms">Ms</option>
                                                    <option value="Mrs">Mrs</option>
                                                </select>
                                            </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="adult_first_name_{{ $adt }}" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][name]" required placeholder="Enter First Name" id="adult_first_name_{{ $adt }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="adult_last_name_{{ $adt }}" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][sur_name]" required placeholder="Enter Last Name" id="adult_last_name_{{ $adt }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="adult_gender_{{ $adt }}" class="form-label">Gender</label>
                                                    <select id="adult_gender_{{ $adt }}" name="passengers[{{ $i }}][passenger_gender]" class="form-select" required>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="adult_dob_{{ $adt }}" class="form-label">Date of Birth</label>
                                                        <input type="text" class="form-control date_dob" name="passengers[{{ $i }}][dob]" required autocomplete="off" placeholder="Enter Date of Birth" id="adult_dob_{{ $adt }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="adult_country_{{ $adt }}" class="form-label">Country</label>
                                                    <select id="adult_country_{{ $adt }}" name="passengers[{{ $i }}][nationality]" class="form-select" required>
                                                        <option value="">Select Country</option>
                                                        @foreach (Countries() as $country)
                                                            <option value="{{ $country->code }}">{{ substr($country->name, 0, 35) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="adult_identity_{{ $adt }}" class="form-label">Identification</label>
                                                    <select id="adult_identity_{{ $adt }}" name="passengers[{{ $i }}][document_type]" onchange="changeIdentity(this,'adult',{{ $adt }})" class="form-select" required>
                                                        <option value="P">Passport</option>
                                                        <option value="RI">Resident Identity</option>
                                                        <option value="I">National ID</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row" id="adult_passport_Div{{ $adt }}">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="adult_passport_{{ $adt }}" class="form-label">Passport Number</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][document_number]" required placeholder="Enter Passport Number" id="adult_passport_{{ $adt }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="adult_passport_expiry_{{ $adt }}" class="form-label">Passport Expiry</label>
                                                    <input type="text" class="form-control date_passport_expiry" name="passengers[{{ $i }}][document_expiry_date]" required autocomplete="off" placeholder="Enter Passport Expiry" id="adult_passport_expiry_{{ $adt }}">
                                                </div>
                                            </div>
                                            <div class="row" id="adult_identity_Div_{{ $adt }}" style="display: none;">
                                                <div class="col-md-6">
                                                    <label for="adult_issue_country_{{ $adt }}" class="form-label">Issuing Country</label>
                                                    <select id="adult_issue_country_{{ $adt }}" name="passengers[{{ $i }}][country]" class="form-select" required>
                                                        <option value="">Select Country</option>
                                                        @foreach (Countries() as $country)
                                                            <option value="{{ $country->code }}">{{ substr($country->name, 0, 35) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="adult_identity_number_{{ $adt }}" class="form-label">Identity Number</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][identity_number]" placeholder="Enter Identity Number" id="adult_identity_number_{{ $adt }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        @php
                                            $i++;
                                        @endphp
                                    @endfor
                                @endif
                                {{-------------------- Childs -----------------------}}
                                @if(@$query['children'] > 0)
                                    @for ($cnn = 1; $cnn <= $query['children']; $cnn++)
                                        <div class="passenger_childs">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="child_selection_{{$cnn}}" class="form-label fs-5 fw-bold" style="line-height: 30px;font-weight: bold;">Child ({{$cnn}})</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select id="child_selection_{{$cnn}}" name="passengers[{{ $i }}][id]" onchange="loadPassengerData(this,'child',{{$cnn}})" disabled class="form-select child_select_option">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <input type="hidden" name="passengers[{{ $i }}][id]" id="child_id_{{$cnn}}">
                                                <input type="hidden" name="passengers[{{ $i }}][passenger_type]" value="CNN">
                                                <div class="col-md-2">
                                                    <label for="child_title_{{$cnn}}" class="form-label">Title</label>
                                                    <select id="child_title_{{$cnn}}" name="passengers[{{ $i }}][passenger_title]" onchange="selectGenderByTitle(this,'child',{{$cnn}})" class="form-select" required>
                                                        <option value="Mstr">Mstr</option>
                                                        <option value="Miss">Miss</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="child_first_name_{{$cnn}}" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][name]" required placeholder="Enter First Name" id="child_first_name_{{$cnn}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="child_last_name_{{$cnn}}" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][sur_name]" required placeholder="Enter Last Name" id="child_last_name_{{$cnn}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="child_gender_{{$cnn}}" class="form-label">Gender</label>
                                                    <select id="child_gender_{{$cnn}}" name="passengers[{{ $i }}][passenger_gender]" required class="form-select">
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="child_dob_{{$cnn}}" class="form-label">Date of Birth</label>
                                                        <input type="text" class="form-control date_dob" name="passengers[{{ $i }}][dob]" required autocomplete="off" placeholder="Enter Date of Birth" id="child_dob_{{$cnn}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="child_country_{{$cnn}}" class="form-label">Country</label>
                                                    <select id="child_country_{{$cnn}}" name="passengers[{{ $i }}][nationality]" class="form-select" required>
                                                        <option value="">Select Country</option>
                                                        @foreach (Countries() as $country)
                                                            <option value="{{ $country->code }}">{{ substr($country->name, 0, 35) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="child_identity_{{ $cnn }}" class="form-label">Identification</label>
                                                    <select id="child_identity_{{ $cnn }}" name="passengers[{{ $i }}][document_type]" onchange="changeIdentity(this,'child',{{ $cnn }})" class="form-select" required>
                                                        <option value="P">Passport</option>
                                                        <option value="RI">Resident Identity</option>
                                                        <option value="I">National ID</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row" id="child_passport_Div{{ $cnn }}">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="child_passport_{{$cnn}}" class="form-label">Passport Number</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][document_number]" required placeholder="Enter Passport Number" id="child_passport_{{$cnn}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="child_passport_expiry_{{$cnn}}" class="form-label">Passport Expiry</label>
                                                        <input type="text" class="form-control date_passport_expiry" name="passengers[{{ $i }}][document_expiry_date]" required autocomplete="off" placeholder="Enter Passport Expiry" id="child_passport_expiry_{{$cnn}}">
                                                </div>
                                            </div>
                                            <div class="row" id="child_identity_Div_{{ $cnn }}" style="display: none;">
                                                <div class="col-md-6">
                                                    <label for="child_issue_country_{{ $cnn }}" class="form-label">Issuing Country</label>
                                                    <select id="child_issue_country_{{ $cnn }}" name="passengers[{{ $i }}][country]" class="form-select" required>
                                                        <option value="">Select Country</option>
                                                        @foreach (Countries() as $country)
                                                            <option value="{{ $country->code }}">{{ substr($country->name, 0, 35) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="child_identity_number_{{ $cnn }}" class="form-label">Identity Number</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][identity_number]" placeholder="Enter Identity Number" id="child_identity_number_{{ $cnn }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        @php
                                            $i++;
                                        @endphp
                                    @endfor
                                @endif
                                {{-------------------- Infants -----------------------}}
                                @if(@$query['infants'] > 0)
                                    @for ($inf = 1; $inf <= $query['infants']; $inf++)
                                        <div class="passenger_infants">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="infant_selection_{{ $inf }}" class="form-label fs-5 fw-bold" style="line-height: 30px;font-weight: bold;">Infant ({{ $inf }})</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select id="infant_selection_{{ $inf }}" name="passengers[{{ $i }}][id]" onchange="loadPassengerData(this,'infant',{{ $inf }})" disabled class="form-select infant_select_option">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <input type="hidden" name="passengers[{{ $i }}][id]" id="infant_id_{{ $inf }}">
                                                <input type="hidden" name="passengers[{{ $i }}][passenger_type]" value="INF">
                                                <div class="col-md-2">
                                                    <label for="infant_title_{{ $inf }}" class="form-label">Title</label>
                                                    <select id="infant_title_{{ $inf }}" name="passengers[{{ $i }}][passenger_title]" onchange="selectGenderByTitle(this,'infant',{{ $inf }})" class="form-select" required>
                                                        <option value="Mstr">Mstr</option>
                                                        <option value="Miss">Miss</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="infant_first_name_{{ $inf }}" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][name]" required placeholder="Enter First Name" id="infant_first_name_{{ $inf }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="infant_last_name_{{ $inf }}" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][sur_name]" required placeholder="Enter Last Name" id="infant_last_name_{{ $inf }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="infant_gender_{{ $inf }}" class="form-label">Gender</label>
                                                    <select id="infant_gender_{{ $inf }}" name="passengers[{{ $i }}][passenger_gender]" required class="form-select">
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="infant_dob_{{ $inf }}" class="form-label">Date of Birth</label>
                                                        <input type="text" class="form-control date_dob" name="passengers[{{ $i }}][dob]" required autocomplete="off" placeholder="Enter Date of Birth" id="infant_dob_{{ $inf }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="infant_country_{{ $inf }}" class="form-label">Country</label>
                                                    <select id="infant_country_{{ $inf }}" name="passengers[{{ $i }}][nationality]" required class="form-select">
                                                        <option value="">Select Country</option>
                                                        @foreach (Countries() as $country)
                                                            <option value="{{ $country->code }}">{{ substr($country->name, 0, 35) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="infant_identity_{{ $inf }}" class="form-label">Identification</label>
                                                    <select id="infant_identity_{{ $inf }}" name="passengers[{{ $i }}][document_type]" onchange="changeIdentity(this,'infant',{{ $inf }})" class="form-select" required>
                                                        <option value="P">Passport</option>
                                                        <option value="RI">Resident Identity</option>
                                                        <option value="I">National ID</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row" id="infant_passport_Div{{ $inf }}">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="infant_passport_{{ $inf }}" class="form-label">Passport Number</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][document_number]" required placeholder="Enter Passport Number" id="infant_passport_{{ $inf }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="infant_passport_expiry_{{ $inf }}" class="form-label">Passport Expiry</label>
                                                    <input type="text" class="form-control date_passport_expiry" required name="passengers[{{ $i }}][document_expiry_date]" autocomplete="off" placeholder="Enter Passport Expiry" id="infant_passport_expiry_{{ $inf }}">
                                                </div>
                                            </div>
                                            <div class="row" id="infant_identity_Div_{{ $inf }}" style="display: none;">
                                                <div class="col-md-6">
                                                    <label for="infant_issue_country_{{ $inf }}" class="form-label">Issuing Country</label>
                                                    <select id="infant_issue_country_{{ $inf }}" name="passengers[{{ $i }}][country]" class="form-select" required>
                                                        <option value="">Select Country</option>
                                                        @foreach (Countries() as $country)
                                                            <option value="{{ $country->code }}">{{ substr($country->name, 0, 35) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="infant_identity_number_{{ $inf }}" class="form-label">Identity Number</label>
                                                        <input type="text" class="form-control" name="passengers[{{ $i }}][identity_number]" placeholder="Enter Identity Number" id="infant_identity_number_{{ $inf }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        @php
                                            $i++;
                                        @endphp
                                    @endfor
                                @endif
                                {{-------------------Payment Info---------------------}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                        <label class="form-label fs-5 " style="line-height: 30px;font-weight: bold;">Payment Info</label>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="additional_payment" class="form-label">Additional Payment</label>
                                            <input type="number" max="9999" name="additional_payment" class="form-control" id="additional_payment">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="adjustment" class="form-label">Adjustment</label>
                                            <input type="number" max="100" name="adjustment" class="form-control" id="adjustment">
                                        </div>
                                    </div>
                                    @if(@$finaldata['Fares'])
                                        @php
                                            $CurrencyCode = @$finaldata['Fares']['CurrencyCode'];
                                            $TotalPrice = @$finaldata['Fares']['TotalPrice'];
                                        @endphp
                                    @endif
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="grand_total" class="form-label">Grand Total</label>
                                            <input type="text" name="grand_total" disabled class="form-control" value="{{ $CurrencyCode }} {{ number_format($TotalPrice,2) }}" id="grand_total">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary w-md">Checkout</button>
                                </div>
                            </form>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                {{-- --------------------------------------- --}}
                <div class="col-xl-4">
                    @include('admin.checkout.includes.right-sidebar')
                </div>
                {{-- end col-6 --}}
            </div>
            {{-- end row --}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<script>
    // Checkout form datepickers
        var currentDate = new Date();
        $('.date_dob').each(function() {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                maxDate: currentDate
            });
        });
        $('.date_passport_expiry').each(function() {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                minDate: currentDate
            });
        });
    // End Datepickers
    function changeIdentity(selectElement,type,index){
        var selectedValue = selectElement.value;
        if(selectedValue == 'P'){
            $('#'+type+'_passport_Div'+index).show();
            $('#'+type+'_identity_Div_'+index).hide();
            $('#'+type+'_passport_'+index).prop('required', true);
            $('#'+type+'_passport_expiry_'+index).prop('required', true);
            $('#'+type+'_identity_number_'+index).prop('required', false);
            $('#'+type+'_issue_country_'+index).prop('required', false);
        }else{
            $('#'+type+'_passport_Div'+index).hide();
            $('#'+type+'_identity_Div_'+index).show();
            $('#'+type+'_passport_'+index).prop('required', false);
            $('#'+type+'_passport_expiry_'+index).prop('required', false);
            $('#'+type+'_identity_number_'+index).prop('required', true);
            $('#'+type+'_issue_country_'+index).prop('required', true);
        }
    }
    function loadCustomerData(selectElement,type) {
        var selectedValue = selectElement.value;
        if(selectedValue != ''){
            $.ajax({
                url: "{{ route('admin.customer.data' )}}",
                method: 'post',
                data: { customer_id: selectedValue,type:type },
                success: function(response) {
                    if(response.status == 200){
                        emptyCheckoutForm();
                        var customer = response.customerData;
                        $('#customer_id').val(customer.id);
                        $('#customer_name').val(customer.name);
                        $('#customer_email').val(customer.email);
                        $('#customer_country').val(customer.country);
                        $('#customer_phone').val(customer.phone);
                        $('#customer_address').text(customer.address);

                        $('#email').val(customer.email);
                        $('#country').val(customer.country);
                        $('#phone').val(customer.phone);

                        if(response.render['ADT']){
                           $('.adult_select_option').html(response.render['ADT']);
                           $('.adult_select_option').prop('disabled', false);
                        }else{
                            $('.adult_select_option').html('');
                            $('.adult_select_option').prop('disabled', true);
                        }
                        if(response.render['CNN']){
                            $('.child_select_option').html(response.render['CNN']);
                            $('.child_select_option').prop('disabled', false);
                        }else{
                            $('.child_select_option').html('');
                            $('.child_select_option').prop('disabled', true);
                        }
                        if(response.render['INF']){
                            $('.infant_select_option').html(response.render['INF']);
                            $('.infant_select_option').prop('disabled', false);
                        }else{
                            $('.infant_select_option').html('');
                            $('.infant_select_option').prop('disabled', true);
                        }
                    }
               },
               error: function(xhr, status, error) {
                  console.error(error);
               }
            });
        }else{
            emptyCheckoutForm();
        }
    }
    function loadPassengerData(selectElement,type,index){
        var selectedValue = selectElement.value;
        if(selectedValue != ''){
            $.ajax({
                url: "{{ route('admin.customer.data' )}}",
                method: 'post',
                data: { customer_id: selectedValue,type:type },
                success: function(response) {
                    if(response.status == 200){
                        var passenger = response.passenger;
                        if(passenger != null){
                            $('#'+ type +'_id_'+index).val(passenger.id)
                            $('#'+ type +'_title_'+index).val(passenger.title)
                            $('#'+ type +'_first_name_'+index).val(passenger.firstName)
                            $('#'+ type +'_last_name_'+index).val(passenger.lastName)
                            $('#'+ type +'_gender_'+index).val(passenger.gender)
                            $('#'+ type +'_dob_'+index).val(passenger.dob)
                            $('#'+ type +'_country_'+index).val(passenger.region)
                            $('#'+ type +'_identity_'+index).val(passenger.identity)
                            $('#'+ type +'_phone_'+index).val(passenger.phone)
                            if(passenger.identity == 'P'){
                                $('#'+ type +'_passport_Div'+index).show();
                                $('#'+ type +'_identity_Div_'+index).hide();
                                $('#'+ type +'_passport_'+index).prop('required', true);
                                $('#'+ type +'_passport_expiry_'+index).prop('required', true);
                                $('#'+ type +'_identity_number_'+index).prop('required', false);
                                $('#'+ type +'_issue_country_'+index).prop('required', false);

                                $('#'+ type +'_passport_'+index).val(passenger.passportNumber)
                                $('#'+ type +'_passport_expiry_'+index).val(passenger.passportExpiry)
                            }else{
                                $('#'+ type +'_passport_Div'+index).hide();
                                $('#'+ type +'_identity_Div_'+index).show();
                                $('#'+ type +'_passport_'+index).prop('required', false);
                                $('#'+ type +'_passport_expiry_'+index).prop('required', false);
                                $('#'+ type +'_identity_number_'+index).prop('required', true);
                                $('#'+ type +'_issue_country_'+index).prop('required', true);
                                $('#'+ type +'_identity_number_'+index).val(passenger.identityNumber)
                                $('#'+ type +'_issue_country_'+index).val(passenger.issueCountry)
                            }
                        }else{
                            $('#'+ type +'_id_'+index).val('')
                            $('#'+ type +'_title_'+index).val('')
                            $('#'+ type +'_first_name_'+index).val('')
                            $('#'+ type +'_last_name_'+index).val('')
                            $('#'+ type +'_gender_'+index).val('')
                            $('#'+ type +'_dob_'+index).val('')
                            $('#'+ type +'_country_'+index).val('')
                            $('#'+ type +'_identity_'+index).val('')
                            $('#'+ type +'_passport_'+index).val('')
                            $('#'+ type +'_passport_expiry_'+index).val('')
                            $('#'+ type +'_identity_number_'+index).val('')
                            $('#'+ type +'_issue_country_'+index).val('')
                            $('#'+ type +'_phone_'+index).val('')
                        }

                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }else{
            emptyCheckoutForm();
        }
    }

    function selectGenderByTitle(selectElement,type,index){
        var selectedValue = selectElement.value;
        if(selectedValue =='Mr' || selectedValue =='Mstr'){
            $('#'+ type +'_gender_'+index).val('M');
        }else{
            $('#'+ type +'_gender_'+index).val('F');
        }
    }
    function emptyCheckoutForm(){
        var grandTotalInput = $('#grand_total');
        var grandTotalValue = grandTotalInput.val();
        var additional_paymentInput = $('#additional_payment');
        var additional_paymentValue = additional_paymentInput.val();
        var adjustmentInput = $('#adjustment');
        var adjustmentValue = adjustmentInput.val();

        $('#checkoutForm input[type="text"]').val('');
        $('#checkoutForm input[type="email"]').val('');
        $('#checkoutForm input[type="number"]').val('');
        $('#checkoutForm textarea').text('');
        $('#checkoutForm select').val('');
        $('.adult_select_option').prop('disabled', true);
        $('.child_select_option').prop('disabled', true);
        $('.infant_select_option').prop('disabled', true);

        // Restore the value of the grand_total input
        grandTotalInput.val(grandTotalValue);
        additional_paymentInput.val(additional_paymentValue);
        adjustmentInput.val(adjustmentValue);
    }

    $(document).ready(function() {
        $('input[type="number"]').on('input', function () {
            if (parseFloat(this.value) > parseFloat($(this).attr('max'))) {
                this.value = $(this).attr('max');
            }
        });

        function updateGrandTotal() {
            var grandTotal = parseFloat('{{ $TotalPrice }}') || 0;
            var additionalPayment = parseFloat($("#additional_payment").val()) || 0;
            var adjustment = parseFloat($("#adjustment").val()) || 0;
            console.log(grandTotal+'--'+additionalPayment+'--'+adjustment);
            grandTotal += additionalPayment + adjustment;

            var formattedTotal = new Intl.NumberFormat('en-US', {
                style: 'decimal', // Use the decimal style
                minimumFractionDigits: 2, // Specify the minimum number of decimal places
            }).format(grandTotal);

            $("#grand_total").val('PKR '+formattedTotal);
            $(".grand_total_span").text(formattedTotal);
        }

        $("#additional_payment, #adjustment").on("input", updateGrandTotal);
    });
</script>
@endsection







