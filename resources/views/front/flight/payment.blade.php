@extends('front.layouts.app')
@section('styles')

@endsection

@section('content')
<div class="flight-checkout-step-2 container-small mt-4">
    <div class="row">
        <div class="col-lg-8 flight-confimation-wrapper mb-5">
            
            <div class="flight-confimation-header mb-3">
                <h5 class="confimation-title">
                    Payment Options
                </h5>
            </div>

            <div class="flight-book-contact-details p-4 bg-white mb-3">
                <form action="{{ route('create.pnr')}}" method="POST">
                    @csrf
                    <div class="payment-features d-flex justify-content-center align-items-center f-14px gap-lg-4 gap-1">
                        <div class="pay-ftr">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24 3.76707V12.5451C24 13.5599 23.1882 14.3717 22.1734 14.3717H21.26V12.9764H22.1734C22.4017 12.9764 22.6047 12.7988 22.6047 12.5451V3.76707C22.6047 3.53874 22.4271 3.33578 22.1734 3.33578H5.75898C5.53065 3.33578 5.3277 3.51337 5.3277 3.76707V4.60428H3.93235V3.76707C3.93235 2.75227 4.74419 1.94043 5.75898 1.94043H22.1987C23.1882 1.94043 24 2.75227 24 3.76707ZM20.0677 7.6233V16.4013C20.0677 17.4161 19.2558 18.228 18.241 18.228H15.222V17.0863C15.222 16.9848 15.222 16.9087 15.1966 16.8072H18.241C18.4693 16.8072 18.6723 16.6296 18.6723 16.3759V10.896H1.39535V16.4267C1.39535 16.655 1.57294 16.858 1.82664 16.858H4.87104C4.87104 16.9595 4.84567 17.0356 4.84567 17.137V18.2787H1.82664C0.811839 18.2787 0 17.4669 0 16.4521V7.6233C0 6.60851 0.811839 5.79667 1.82664 5.79667H18.2664C19.2558 5.79667 20.0677 6.60851 20.0677 7.6233ZM18.6723 7.6233C18.6723 7.39497 18.4947 7.19202 18.241 7.19202H1.82664C1.59831 7.19202 1.39535 7.36961 1.39535 7.6233V8.56199H18.6723V7.6233ZM13.6998 17.1117V21.2977C13.6998 21.7036 13.37 22.0588 12.9387 22.0588H7.10359C6.69767 22.0588 6.34249 21.729 6.34249 21.2977V17.1117C6.34249 16.7058 6.6723 16.3506 7.10359 16.3506H7.1797H8.4482H11.6702V15.4119C11.6702 14.6 11.0867 13.8643 10.2748 13.7628C9.36152 13.636 8.57505 14.2956 8.47357 15.1328C8.4482 15.2597 8.34672 15.3611 8.21987 15.3611H7.45877C7.30655 15.3611 7.1797 15.2343 7.20507 15.0821C7.35729 13.5345 8.72727 12.3675 10.351 12.4943C11.8478 12.6466 12.9387 13.9404 12.9387 15.4373V16.3506H12.9641C13.37 16.3506 13.6998 16.6804 13.6998 17.1117ZM10.7822 18.8115C10.7822 18.4563 10.5285 18.1772 10.1987 18.1265C9.89429 18.0757 9.56448 18.228 9.41226 18.5324C9.28541 18.8368 9.36152 19.192 9.64059 19.395C9.69133 19.4457 9.7167 19.4711 9.7167 19.5472C9.7167 19.8516 9.7167 20.1561 9.7167 20.4605C9.7167 20.7142 9.99577 20.9172 10.2495 20.765C10.351 20.7142 10.4271 20.5874 10.4271 20.4605C10.4271 20.1561 10.4271 19.8516 10.4271 19.5472C10.4271 19.4711 10.4524 19.4457 10.5032 19.395C10.6808 19.2428 10.7822 19.0398 10.7822 18.8115Z" fill="#595959"></path>
                            </svg>
                            <span>Secure Payments</span>
                        </div>
                        <div class="pay-ftr">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.8735 8.42109H14.7102L19.3532 2.55469C19.4493 2.43047 19.3626 2.25 19.2055 2.25H10.2172C10.1516 2.25 10.0883 2.28516 10.0555 2.34375L3.98286 12.832C3.91021 12.9563 3.99927 13.1133 4.14458 13.1133H8.23208L6.13677 21.4945C6.09224 21.6773 6.31255 21.8062 6.44849 21.675L20.0024 8.74219C20.1243 8.62734 20.0422 8.42109 19.8735 8.42109ZM8.86255 17.168L10.2758 11.5195H6.58677L11.0305 3.84609H16.2946L11.4126 10.0172H16.3579L8.86255 17.168Z" fill="#595959"></path>
                            </svg>
                            <span>Lightning Fast Refunds</span>
                        </div>
                        <div class="pay-ftr">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.7633 12.509C21.157 11.9887 21.375 11.3512 21.375 10.6879C21.375 9.63556 20.7867 8.63947 19.8398 8.084C19.5961 7.94102 19.3185 7.86577 19.0359 7.86603H13.4156L13.5563 4.98556C13.5891 4.28947 13.343 3.62853 12.8648 3.12463C12.6302 2.87626 12.3471 2.67864 12.0331 2.544C11.7191 2.40936 11.3807 2.34054 11.0391 2.34181C9.82031 2.34181 8.74219 3.16213 8.41875 4.33635L6.40547 11.6254H3.375C2.96016 11.6254 2.625 11.9606 2.625 12.3754V20.9067C2.625 21.3215 2.96016 21.6567 3.375 21.6567H17.468C17.6836 21.6567 17.8945 21.6145 18.0891 21.5301C19.2047 21.0543 19.9242 19.9645 19.9242 18.7551C19.9242 18.4598 19.882 18.1692 19.7977 17.8879C20.1914 17.3676 20.4094 16.7301 20.4094 16.0668C20.4094 15.7715 20.3672 15.4809 20.2828 15.1996C20.6766 14.6793 20.8945 14.0418 20.8945 13.3785C20.8898 13.0832 20.8477 12.7903 20.7633 12.509ZM4.3125 19.9692V13.3129H6.21094V19.9692H4.3125ZM19.2281 11.6957L18.7148 12.141L19.0406 12.7363C19.148 12.9324 19.2036 13.1526 19.2023 13.3762C19.2023 13.7629 19.0336 14.1309 18.743 14.384L18.2297 14.8293L18.5555 15.4246C18.6628 15.6207 18.7185 15.8409 18.7172 16.0645C18.7172 16.4512 18.5484 16.8192 18.2578 17.0723L17.7445 17.5176L18.0703 18.1129C18.1776 18.309 18.2333 18.5292 18.232 18.7528C18.232 19.2778 17.9227 19.7512 17.4445 19.9668H7.71094V13.2379L10.043 4.78869C10.1031 4.57213 10.2322 4.38107 10.4107 4.24446C10.5891 4.10786 10.8073 4.03315 11.032 4.03166C11.2102 4.03166 11.3859 4.08322 11.5266 4.18869C11.7586 4.36213 11.8828 4.62463 11.8687 4.90353L11.6437 9.55353H19.0125C19.4297 9.809 19.6875 10.2403 19.6875 10.6879C19.6875 11.0746 19.5188 11.4403 19.2281 11.6957Z" fill="#595959"></path>
                            </svg>
                            <span>Trusted by 10 Lac Customers</span>
                        </div>
                    </div>


                    <div class="parent d-sm-flex mt-4 justify-content-between gap-5">
                        <div class="left left-pay-methods-main">

                            <div data-pay="credit-card-payment" class="credit-card-payment pay-methods selected p-2">
                                <span>Debit / Credit Card </span>
                                <span class="visa-svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="11" viewBox="0 0 34 11" fill="none">
                                        <path d="M14.7125 10.8168H11.9414L13.6712 0.182129H16.4422L14.7125 10.8168Z" fill="#0066B3"/>
                                        <path d="M9.60767 0.182129L6.97032 7.4967L6.66021 5.92055L5.72705 1.13806C5.72705 1.13806 5.61609 0.182129 4.41549 0.182129H0.0512106L0 0.361366C1.0218 0.615987 1.99855 1.02568 2.89624 1.57619L5.30029 10.8168H8.18515L12.5921 0.182129H9.60767Z" fill="#0066B3"/>
                                        <path d="M31.3929 10.8168H33.9363L31.7172 0.182037H29.4924C29.2221 0.161741 28.9523 0.228361 28.7225 0.372178C28.4927 0.515995 28.3149 0.729482 28.215 0.981491L24.084 10.8168H26.9632L27.5322 9.23777H31.0543L31.3929 10.8168ZM28.3458 7.05563L29.7997 3.07259L30.619 7.05563H28.3458Z" fill="#0066B3"/>
                                        <path d="M24.2996 2.73976L24.6951 0.46374C23.8951 0.177984 23.0548 0.021443 22.2057 0C20.8315 0 17.5683 0.600301 17.5683 3.5193C17.5683 6.2676 21.3977 6.30174 21.3977 7.74417C21.3977 9.1866 17.9609 8.93055 16.8285 8.02867L16.416 10.3986C17.4065 10.8127 18.4721 11.0171 19.5455 10.9989C21.4346 10.9989 24.2854 10.0202 24.2854 7.36009C24.2825 4.59472 20.419 4.33583 20.419 3.13522C20.419 1.93462 23.1161 2.08541 24.2996 2.73976Z" fill="#0066B3"/>
                                        <path d="M6.66021 5.92055L5.72705 1.13806C5.72705 1.13806 5.61609 0.182129 4.41549 0.182129H0.0512106L0 0.361366C1.50223 0.744353 2.90373 1.44802 4.10822 2.42401C5.25303 3.34343 6.13361 4.54993 6.66021 5.92055Z" fill="#FAA634"/>
                                        </svg>
                                </span>
                                <span class="visa-svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" viewBox="0 0 20 19" fill="none">
                                        <path d="M13.0042 8.19287H7.86719V16.9585H13.0042V8.19287Z" fill="#FF5F00"/>
                                        <path d="M8.19265 12.5753C8.19265 10.7943 9.07329 9.21463 10.4269 8.19249C9.43207 7.44912 8.17635 7 6.80647 7C3.56115 7 0.935547 9.49339 0.935547 12.5753C0.935547 15.6572 3.56115 18.1506 6.80647 18.1506C8.17635 18.1506 9.43207 17.7014 10.4269 16.9581C9.07329 15.9514 8.19265 14.3563 8.19265 12.5753Z" fill="#EB001B"/>
                                        <path d="M19.9347 12.5753C19.9347 15.6572 17.3091 18.1506 14.0638 18.1506C12.6939 18.1506 11.4382 17.7014 10.4434 16.9581C11.8132 15.9359 12.6776 14.3563 12.6776 12.5753C12.6776 10.7943 11.7969 9.21463 10.4434 8.19249C11.4382 7.44912 12.6939 7 14.0638 7C17.3091 7 19.9347 9.50888 19.9347 12.5753Z" fill="#F79E1B"/>
                                        </svg>
                                </span>
                                <span class="visa-svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="20" viewBox="0 0 28 20" fill="none">
                                        <path d="M1.73904 0H26.0859C27.0459 0 27.8249 0.779061 27.8249 1.73989V18.261C27.8249 19.2209 27.0459 20 26.0859 20H1.73904C0.778203 20.0001 0 19.2209 0 18.2611V1.73989C0 0.779061 0.779061 0 1.73904 0Z" fill="#26A6D1"/>
                                        <path d="M4.48602 6.9563L1.73828 13.037H5.02771L5.43551 12.0674H6.36763L6.77543 13.037H10.3962V12.297L10.7188 13.037H12.5917L12.9144 12.2814V13.037H20.4445L21.3601 12.0926L22.2175 13.037L26.0851 13.0448L23.3287 10.0136L26.0851 6.9563H22.2775L21.3862 7.88318L20.5558 6.9563H12.364L11.6606 8.52577L10.9406 6.9563H7.65806V7.67108L7.29289 6.9563H4.48602ZM5.12251 7.81976H6.72593L8.54851 11.9431V7.81976H10.305L11.7127 10.7762L13.0101 7.81976H14.7578V12.183H13.6944L13.6857 8.764L12.1353 12.183H11.184L9.62493 8.764V12.183H7.43718L7.02243 11.2048H4.78166L4.36777 12.1822H3.1956L5.12251 7.81976ZM15.7308 7.81976H20.0549L21.3775 9.24837L22.7427 7.81976H24.0653L22.0558 10.0127L24.0653 12.1805H22.6827L21.3601 10.7353L19.988 12.1805H15.7308V7.81976ZM5.90252 8.558L5.16428 10.3006H6.63991L5.90252 8.558ZM16.7986 8.72318V9.51969H19.1576V10.4075H16.7986V11.277H19.4446L20.6741 9.99625L19.4968 8.72242H16.7986V8.72318Z" fill="white"/>
                                        </svg>
                                </span>
                            </div>

                            <div data-pay="paylater" class="paylater pay-methods p-2">
                                <span>Pay Later</span>
                            </div>
                        </div>

                        
                        <div class="right right-payment-details">

                            <div class="pay-method-details" data-payment="credit-card-payment">
                                <div class="reliable-part d-flex gap-2 align-items-center">
                                    <div style="width: 40px; height: 40px;">
                                        <img class="w-100" src="download_secure.png">
                                    </div>
                                    <div>
                                        <div class="f-14px">All information is encrypted and we do not store your card details.</div>
                                    </div>
                                </div>
                                <div class="payform-details mt-2">
                                    <form method="" action="" class="form-control f-14px">
                                        <label class="form-label mt-2">Name on Card</label>
                                        <input type="text" class="form-control" />
                                        <label class="form-label mt-2">Card Number</label>
                                        <input type="number" class="form-control" />
                                        <div class="form-group">
                                            <label for="my-input">Expiry</label>
                                            <input id="my-input" class="form-control" type="text" name="" placeholder="MM/YY">
                                        </div>
                                        <div class="form-group">
                                            <label for="my-input1">CVV</label>
                                            <input id="my-input1" class="form-control" type="text" name="" placeholder="123">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="pay-actions mt-4">
                                <div class="pay-login-action">
                                    Please <a href="#">login</a> to avail discounts on voucher codes.
                                </div>
                                <span class="f-14px">
                                    By selecting to complete this booking, I acknowledge that I have read and accept the above Policy section containing Fare Rules &amp; Restrictions, <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.
                                </span>
                                <input type="hidden" name="ref_key" value="{{ $ref_key }}">
                                <button class="button green_btn d-block mt-2 w-100">Pay Now</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            

            <div class="flight-details-popup-wrapper">
                <div class="flight-details-popup-overlay"></div>
                <div class="flight-details-popup-inner">
                    <div class="details-popup-close">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon icon-close " fill="none" viewBox="0 0 18 17">
                            <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
                        </path></svg>
                    </div>

                    <div class="details-popup-tabs-wrapper">
                        Review your details
                    </div>

                    <hr class="details-tabs-content-divider">

                    <div class="details-popup-content-wrapper">

                        <div class="airline-image">
                            <img src="pia.png"/>
                        </div>

                        <div class="dprtr-dstntn">
                            <h5>Lahore - Karachi</h5>
                        </div>

                        <div class="timing-details">
                            <span class="f-14px">Friday, 19th January, 06:15 PM - 08:00 PM</span>
                        </div>

                        <div class="d-flex f-14px justify-content-start align-items-center mt-2">
                            <div class="">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="_1MZrIK28AE8HVj289UBgZw st-svg-icon ">
                                    <path d="M6 0.75C3.10078 0.75 0.75 3.10078 0.75 6C0.75 8.89922 3.10078 11.25 6 11.25C8.89922 11.25 11.25 8.89922 11.25 6C11.25 3.10078 8.89922 0.75 6 0.75ZM6 10.3594C3.59297 10.3594 1.64062 8.40703 1.64062 6C1.64062 3.59297 3.59297 1.64062 6 1.64062C8.40703 1.64062 10.3594 3.59297 10.3594 6C10.3594 8.40703 8.40703 10.3594 6 10.3594Z" fill="#262626"></path><path d="M5.4375 3.9375C5.4375 4.08668 5.49676 4.22976 5.60225 4.33525C5.70774 4.44074 5.85082 4.5 6 4.5C6.14918 4.5 6.29226 4.44074 6.39775 4.33525C6.50324 4.22976 6.5625 4.08668 6.5625 3.9375C6.5625 3.78832 6.50324 3.64524 6.39775 3.53975C6.29226 3.43426 6.14918 3.375 6 3.375C5.85082 3.375 5.70774 3.43426 5.60225 3.53975C5.49676 3.64524 5.4375 3.78832 5.4375 3.9375ZM6.28125 5.25H5.71875C5.66719 5.25 5.625 5.29219 5.625 5.34375V8.53125C5.625 8.58281 5.66719 8.625 5.71875 8.625H6.28125C6.33281 8.625 6.375 8.58281 6.375 8.53125V5.34375C6.375 5.29219 6.33281 5.25 6.28125 5.25Z" fill="#262626"></path>
                                </svg>
                            </div>
                            <div class="px-1">
                                <span class="text-secondary">Make sure that your name matches with your CNIC.<span class=""> Errors might lead to cancellation penalties.</span></span>
                            </div>
                        </div>

                        <div class="traveler-info mt-3">
                            <h5>Travelers</h5>
                            <div class="d-flex gap-1 align-items-center">
                                <i class="fa fa-user"></i>
                                <div class="traveler-name">Mr. Hamid Afridi</div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>	

                    
        </div>
                
            <div class="col-lg-4 right-flight-summary pb-2">
                @php
                    $CurrencyCode = $result['Fares']['CurrencyCode'];
                    $TotalPrice = $result['Fares']['TotalPrice'];
                @endphp
                <div class="flight-summary-wrapper checkout-booking-confirm">
                    <div class="flight-summary-header">Price Summary</div>
                    @foreach ($result['Fares']['fareBreakDown'] as $key => $fare)
                        @php
                            if ($key == 'ADT') {
                                $type = 'Adult';
                            } elseif ($key == 'CNN') {
                                $type = 'Child';
                            } else {
                                $type = 'Infant';
                            }

                        @endphp
                        <div
                            class="flight-passenger-price-summary p-3 d-flex justify-content-between align-items-center f-14px">
                            <span class="flight-booked-airline-and-passenger">Pakistan Airline ({{ $type }} x
                                {{ $fare['Quantity'] }})</span>
                            <span class="flight-booked-price">{{ $CurrencyCode }}
                                {{ $fare['BaseFare'] * $fare['Quantity'] }}</span>
                        </div>
                    @endforeach
                    <div class="flight-passenger-price-summary p-3 d-flex justify-content-between align-items-center">
                        <span class="flight-booked-airline-and-passenger">Price you pay</span>
                        <span class="flight-booked-price">{{ $CurrencyCode }} {{ $TotalPrice }}</span>
                    </div>
                </div>

                <div class="bg-white booking-reviews-part f-14px p-3 mb-3 mt-3">
                    <div class="reliable-part d-flex gap-2 align-items-center">
                        <div class="ant-image" style="width: 40px; height: 40px;">
                            <img class="ant-image-img" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzQiIGhlaWdodD0iMzQiIHZpZXdCb3g9IjAgMCAzNCAzNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTMxLjU5MzcgNS45OTIxOUwyNy40MzM2IDEuODM1OTRDMjcuMTQwMSAxLjU0MTE5IDI2Ljc5MTMgMS4zMDczMiAyNi40MDcyIDEuMTQ3NzhDMjYuMDIzMSAwLjk4ODIzIDI1LjYxMTIgMC45MDYxNSAyNS4xOTUzIDAuOTA2MjVDMjQuMzQ3NyAwLjkwNjI1IDIzLjU1MDggMS4yMzgyOCAyMi45NTMxIDEuODM1OTRMMTguNDc2NiA2LjMxMjVDMTguMTgxOCA2LjYwNTk2IDE3Ljk0NzkgNi45NTQ3NyAxNy43ODg0IDcuMzM4ODhDMTcuNjI4OSA3LjcyMyAxNy41NDY4IDguMTM0ODUgMTcuNTQ2OSA4LjU1MDc4QzE3LjU0NjkgOS4zOTg0NCAxNy44Nzg5IDEwLjE5NTMgMTguNDc2NiAxMC43OTNMMjEuNzUgMTQuMDY2NEMyMC45ODM4IDE1Ljc1NTMgMTkuOTE4NCAxNy4yOTE3IDE4LjYwNTUgMTguNjAxNkMxNy4yOTU4IDE5LjkxNzcgMTUuNzU5NSAyMC45ODY5IDE0LjA3MDMgMjEuNzU3OEwxMC43OTY5IDE4LjQ4NDRDMTAuNTAzNCAxOC4xODk2IDEwLjE1NDYgMTcuOTU1OCA5Ljc3MDQ5IDE3Ljc5NjJDOS4zODYzOCAxNy42MzY3IDguOTc0NTMgMTcuNTU0NiA4LjU1ODYgMTcuNTU0N0M3LjcxMDk0IDE3LjU1NDcgNi45MTQwNiAxNy44ODY3IDYuMzE2NDEgMTguNDg0NEwxLjgzNTk0IDIyLjk1N0MxLjU0MDgzIDIzLjI1MSAxLjMwNjc2IDIzLjYwMDUgMS4xNDcyMSAyMy45ODUzQzAuOTg3NjU1IDI0LjM3MDEgMC45MDU3NjYgMjQuNzgyNiAwLjkwNjI1MiAyNS4xOTkyQzAuOTA2MjUyIDI2LjA0NjkgMS4yMzgyOCAyNi44NDM4IDEuODM1OTQgMjcuNDQxNEw1Ljk4ODI4IDMxLjU5MzhDNi45NDE0MSAzMi41NTA4IDguMjU3ODEgMzMuMDkzOCA5LjYwOTM4IDMzLjA5MzhDOS44OTQ1MyAzMy4wOTM4IDEwLjE2OCAzMy4wNzAzIDEwLjQzNzUgMzMuMDIzNEMxNS43MDMxIDMyLjE1NjIgMjAuOTI1OCAyOS4zNTU1IDI1LjE0MDYgMjUuMTQ0NUMyOS4zNTE2IDIwLjkzNzUgMzIuMTQ4NCAxNS43MTg4IDMzLjAyNzMgMTAuNDM3NUMzMy4yOTMgOC44MjQyMiAzMi43NTc4IDcuMTY0MDYgMzEuNTkzNyA1Ljk5MjE5WiIgZmlsbD0iIzBBNTQ5QyIvPgo8L3N2Zz4K">
                        </div>
                        <div>
                            <div>Having trouble making a payment? Contact our helpline for assistance</div>
                            <a class="text-decoration-none" href="tel:03 111 222 427">03 111 222 427</a>
                        </div>
                    </div>
                    
                </div>

                <div class="booking-card-trigger mt-4 f-14px d-flex align-items-center gap-1">
                    Your Bookings <i class="fa fa-angle-down"></i>
                </div>

                @foreach ($result['LowFareSearch'] as $offer)
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

                            $Baggage = $segment['Baggage'];
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

@endsection
@section('scripts')
<script>
    $('.pay-methods').click(function(){
        $(this).addClass('selected');
        $(this).siblings().removeClass('selected');

        var this_pay_data = $(this).data('pay');
        $(this).parents().siblings().find('.pay-method-details').addClass('d-none');
        $(this).parents().siblings().find('[data-payment="'+this_pay_data+'"]').removeClass('d-none');
    });
</script>
@endsection