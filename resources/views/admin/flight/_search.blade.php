@extends('admin.layouts.app')

@section('styles')
<link href="{{ asset('assets/css/contact-profile2.css') }}" rel="stylesheet" type="text/css" />
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style>
    .passenger-dropdown {
        right: 0;
        display: none;
        padding: 15px;
        position: absolute;
        top: 100%;
        z-index: 40;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        width: 280px;
        border: 1px solid #ccc;
    }
    .passenger-dropdown p:first-child {
        line-height: 2;
    }

    .passenger-dropdown p {
        display: block;
    }
    .input-group {
        position: relative;
        display: table;
        border-collapse: separate;
    }
    .input-group-addon, .input-group-btn {
        width: 1%;
        white-space: nowrap;
        vertical-align: middle;
    }
    .form-control:disabled, .form-control[readonly] {
        background-color: transparent;
        opacity: 1;
        min-width: 40px;
    }
    .input-group .form-control, .input-group-addon, .input-group-btn {
        display: table-cell;
    }
    .passenger-dropdown .input-group{
        float: right
    }
    .input-group-sm>.form-control, .input-group-sm>.input-group-addon, .input-group-sm>.input-group-btn>.btn {
        height: 30px;
        padding: 5px 10px;
        font-size: 12px;
        line-height: 1.5;
        border-radius: 3px;
    }

    .btn:not(:disabled):not(.disabled) {
        cursor: pointer;
    }
    .input-group-btn .btn-default {
        width: auto;
    }
    .btn-default:not(.active) {
        text-shadow: 0 1px 0 #fff;
        background-image: -webkit-linear-gradient(top, #fff 0%, #e0e0e0 100%);
        background-image: -o-linear-gradient(top, #fff 0%, #e0e0e0 100%);
        background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#e0e0e0));
        background-image: linear-gradient(to bottom, #fff 0%, #e0e0e0 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffffff", endColorstr="#ffe0e0e0", GradientType=0);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
        background-repeat: repeat-x;
        border-color: #dbdbdb;
        border-color: #ccc;
    }
 
</style>
@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.flight.includes.search-engine')
        </div>
        
        <div class="row">
            <div class="col-md-3">
                <div class="user-sidebar">
                    <div class="card" id="aside_filter">

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="user-sidebar">
                    
                    <div class="card">
                        <div class="card-center">
                            <div style="display: flex; justify-content: space-between; padding-bottom:10px;">
                                <span class="card-title">Choose departing flight</span>
                                <span class="w-30">
                                    <select class="form-select">
                                        <option>Select</option>
                                        <option>Large select</option>
                                        <option>Small select</option>
                                    </select>
                                </span>
                            </div>
                            <div>
                                <div>
                                    <span class="badge rounded-pill bg-primary">EK</span>
                                    <span class="badge rounded-pill bg-primary">KY</span>
                                    <span class="badge rounded-pill bg-primary">QR</span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            
                            <p class="text-muted"><b>Note:</b>Price displayed include taxes and may chabge based on availability.You can review any additional 
                            fees before checkout.Prices are not final until you complete your purchase</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-label="Example with label" style="width: 100%; background-color: #3b76e1;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                            </div>
                            <p class="card-search">search results from 1/1 providers</p>
                        </div>
                    </div>
                </div>
                
                <div class="scrollable" id="appendAvailability">
                    
                </div>
            </div>
            <div class="col-md-3">
                @include('admin.flight.includes.aside-recent-search')
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
<!-- Modal -->
<div class="modal right" id="rightModal" tabindex="-1" aria-labelledby="rightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md w-100">
        <div class="modal-content" style="height: 100%;">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modal_flight_result">
                
            </div>
            
        </div>
    </div>
</div>

<!-- My MOdal -->
@endsection

@section('scripts')
{{-- ------------DatePicker--------------- --}}
{{-- <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/libs/%40simonwep/pickr/pickr.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script> --}}
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
@include('admin.flight.includes.typeahead')
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
    $('#btnAvailability').click(function(){
        if(validateForm()){
            $('#appendAvailability').html('');
            $('#aside_filter').html('');

            var api_selected = $('#api_selected').val();
            var tripType = $('#trip_type').val();
            var origin = $('#origin_code').val();
            var destination = $('#destination_code').val();
            var departureDate = $('#dapart_date').val();
            var returnDate = $('#return_date').val();
            var adults = $('#adult_count').val();
            var children = $('#child_count').val();
            var infants = $('#infant_count').val();
            
            var blinking = <?php echo json_encode(flightCardBlinking(5)); ?>;
            var asideBlinking = <?php echo json_encode(flightFilterBlinking()); ?>;
            $('#appendAvailability').html(blinking);
            $('#aside_filter').html(asideBlinking);

            var apiArray = ['Hitit'];
            // var apiArray = ['Travelport'];
            $.each(apiArray, function(index, apiItem) {
                var api = apiItem;
                $.ajax({
                    type:'get',
                    url:"{{route('admin.flight.search.availability')}}",
                    data:{api,api_selected,tripType,origin,destination,departureDate,returnDate,adults,children,infants},
                    success:function(data) {
                        var obj = JSON.parse(data);
                        // add scroll-y when content more
                        console.log(obj);
                        addScroll('#appendAvailability', '1190px');
                        // if(obj.api == 'Amadeus'){
                            
                        // }
                        if(obj.message == 'success'){
                            $('#appendAvailability').html('');
                            $('#aside_filter').html('');

                            $('#appendAvailability').append(obj.html);
                            $('#aside_filter').html(obj.filter);
                        }else{
                            Swal.fire({
                                text: obj.message,
                                icon: "warning",
                                buttonsStyling: false,
                                confirmButtonText: "Okay, got it!",
                                customClass: {
                                confirmButton: "btn btn-primary"
                                }
                            }) 
                        }
                    },
                    error:function(data){
                        var data = JSON.parse(data.responseText);
                        console.log(data);return false;
                        var message = '';
                        data.errors.permissionArray ? message = data.errors.permissionArray[0]  :  message = data.errors.roleName[0];
                        Swal.fire({
                            text: message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Okay, got it!",
                            customClass: {
                            confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            });
        }
    });
    // ---------------------Validation-------------------------
    function validateForm(){
        var isValidated = true;

        var origin = $('#origin').val();
        if(origin == ''){
            $('.origin-label').addClass('error-label');
            $('.origin-main').addClass('error-main');
            $('.origin-icon').addClass('error-icon');
            isValidated = false;
        }else{
            $('.origin-label').removeClass('error-label');
            $('.origin-main').removeClass('error-main');
            $('.origin-icon').removeClass('error-icon');
        }
        var destination = $('#destination').val();
        if(destination == ''){
            $('.destination-label').addClass('error-label');
            $('.destination-main').addClass('error-main');
            $('.destination-icon').addClass('error-icon');
            isValidated = false;
        }else{
            $('.destination-label').removeClass('error-label');
            $('.destination-main').removeClass('error-main');
            $('.destination-icon').removeClass('error-icon');
        }

        if(origin == destination){
            Swal.fire({
                text: "Origin and Destination must be different",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Okay, got it!",
                customClass: {
                confirmButton: "btn btn-primary"
                }
            });
            isValidated = false;
        }
        
        
        
        var dapart_date = $('#dapart_date').val();
        if(dapart_date == ''){
            $('.depart-label').addClass('error-label');
            $('.depart-main').addClass('error-main');
            $('.depart-icon').addClass('error-icon');
            isValidated = false;
        }else{
            $('.depart-label').removeClass('error-label');
            $('.depart-main').removeClass('error-main');
            $('.depart-icon').removeClass('error-icon');
        }
        
        // var dapart_date = $('#dapart_date').val();
        // if(dapart_date == ''){
        //     $('.depart-label').addClass('error-label');
        //     $('.depart-main').addClass('error-main');
        //     $('.depart-icon').addClass('error-icon');
        //     isValidated = false;
        // }els{
        //     $('.depart-label').removeClass('error-label');
        //     $('.depart-main').removeClass('error-main');
        //     $('.depart-icon').removeClass('error-icon');
        //     isValidated = true; 
        // }

        return isValidated;
    }
    // ---------------------Tab Change-------------------------
    function changeTab(tabType) {
        var tripType = '';
        
        if (tabType === 'oneway') {
            tripType = 'oneway';
            $('.return-date-main').hide();
        } else if (tabType === 'return') {
            tripType = 'return';
            $('.return-date-main').show();
        } else if (tabType === 'multy') {
            tripType = 'multy';
            $('.return-date-main').hide();
        }
        
        $('#trip_type').val(tripType);
    }
    // Flight Detail modale
    $(document).on('click','.card1',function(){
        $('#modal_flight_result').html('');
        id = $(this).data('id');
        $('#rightModal').closest('.modal').modal('show');
        $.ajax({
            type:'post',
            url:"{{route('admin.flight.detail')}}",
            data:{id},
            success:function(data) {
                var obj = JSON.parse(data);

                if(obj.message == 'success'){
                    $('#modal_flight_result').append(obj.flightDetailHtml);
                    // add scroll-y when content more
                    addScroll('#modal_flight_result .modal-body', 'auto');
                }else{
                    Swal.fire({
                        text: obj.message,
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Okay, got it!",
                        customClass: {
                        confirmButton: "btn btn-primary"
                        }
                    }) 
                }
            },
            error:function(data){
                var data = JSON.parse(data.responseText);
                console.log(data);return false;
                var message = '';
                data.errors.permissionArray ? message = data.errors.permissionArray[0]  :  message = data.errors.roleName[0];
                Swal.fire({
                    text: message,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Okay, got it!",
                    customClass: {
                    confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    });
    // Recent Search function click
    $(document).on('click','.card-fly',function(){
        $('#origin').val($(this).data('originairport'));
        $('#origin_code').val($(this).data('origin'));
        $('#destination').val($(this).data('destinationairport'));
        $('#destination_code').val($(this).data('destination'));
        $('#dapart_date').val($(this).data('departdate'));
        $('#return_date').val($(this).data('returndate'));
    });
    // Add scroll
    function addScroll(classOrId, height) {
        $(classOrId).css({
            'overflow-y': 'scroll',
            'height': height,
            'overflow-x': 'hidden'
        });
    }

    var currentDate = new Date();

    $('#dapart_date').datepicker({
        format: 'yyyy-mm-dd',
        minDate: currentDate, // Set minimum date to today
        onSelect: function (selectedDate) {
            alert(23423);
        }
    });

    $('#return_date').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('.passenger-change').click(function (e) {
        e.preventDefault();
        $(this).next('.passenger-dropdown').slideToggle();
    });
    $('.btn-ok').click(function () {
        $('.passenger-dropdown').slideUp();
    });
    // Passenger Plus and Minus
    $(document).ready(function() {
        function updateTotalPassengerCount() {
            var adultCount = parseInt($("#adult_count").val());
            var childCount = parseInt($("#child_count").val());
            var infantCount = parseInt($("#infant_count").val());

            var totalPassengers = adultCount + childCount + infantCount;
            $(".passenger-count").text(totalPassengers);
        }

        $(".number-spinner-flight").click(function () {
            var fieldName = $(this).attr('data-field');
            var type = $(this).attr('data-type');
            var inputElement = $("#" + fieldName);
            var currentValue = parseInt(inputElement.val());

            if (!isNaN(currentValue)) {
                if (type === 'minus') {
                    if (currentValue > inputElement.attr('min')) {
                        inputElement.val(currentValue - 1);
                    }
                } else if (type === 'plus') {
                    if (currentValue < inputElement.attr('max')) {
                        inputElement.val(currentValue + 1);
                    }
                }
            }

            updateTotalPassengerCount(); // Update the total count
        });
    });

    $(document).click(function (e) {
        if (!$(e.target).closest('.passenger-dropdown').length && !$(e.target).closest('.passenger-change').length) {
            $('.passenger-dropdown').slideUp();
        }
    });
</script>

@endsection







