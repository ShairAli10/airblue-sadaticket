@extends('front.layouts.app')
@section('title', 'Book Online Tickets at sadaticket.com With Cheap Flights Pakistan')

@section('styles')
	<link rel="stylesheet" href="{{ asset('front-assets/css/typeahead.css')}}">
	<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
	<style>
		.gj-datepicker .gj-icon{
			display: none;
		}
		.error-main{
			border: 1px solid red !important;
		}
		.error-main.gj-textbox-md{
			border: 1px solid red !important;
		}
		.gj-textbox-md{
			border: 1px solid #ced4da !important;
		}
	</style>
@endsection

@section('content')

	
	@include('front.includes.search-engine')
	
    {{-- @if (@$topDestination) --}}
    	@include('front.includes.top-destinations')
    {{-- @endif --}}
	
    @if (@$tours)
	    @include('front.includes.popular-tours')
    @endif
	
	@include('front.includes.why-choose')
	

@endsection

@section('scripts')
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
@include('admin.flight.includes.typeahead')

<script>
	var currentDate = new Date();

	$('#dapart_date').datepicker({
		format: 'yyyy-mm-dd',
        defaultDate: currentDate,
		minDate: currentDate, // Set minimum date to today

	});

	$('#return_date').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('.availability').click(function(e){
		e.preventDefault();
        if(validateForm()){
			$('#flight-search-form').submit();
		}
	});
	function validateForm(){
        var isValidated = true;

        var origin_code = $('#origin_code').val();
        if(origin_code == ''){
            $('#origin_code').addClass('error-main');
            $('#origin_code').addClass('error-icon');
            isValidated = false;
        }else{
            $('#origin_code').removeClass('error-main');
            $('#origin_code').removeClass('error-icon');
        }
        
		var destination_code = $('#destination_code').val();
        if(destination_code == ''){
            $('#destination_code').addClass('error-main');
            $('#destination_code').addClass('error-icon');
            isValidated = false;
        }else{
            $('#destination_code').removeClass('error-main');
            $('#destination_code').removeClass('error-icon');
        }
		
		var dapart_date = $('#dapart_date').val();
        if(dapart_date == ''){
            $('#dapart_date').addClass('error-main');
            $('#dapart_date').addClass('error-icon');
            isValidated = false;
        }else{
            $('#dapart_date').removeClass('error-main');
            $('#dapart_date').removeClass('error-icon');
        }

        var tripType = $('input[name="trip_type_chk"]:checked').val();

        if(tripType == 'return'){
            var return_date = $('#return_date').val();
            if(return_date == ''){
                $('#return_date').addClass('error-main');
                $('#return_date').addClass('error-icon');
                isValidated = false;
            }else{
                $('#return_date').removeClass('error-main');
                $('#return_date').removeClass('error-icon');
            }
        }


		return isValidated;
	};
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
</script>
<script>
    $(document).ready(function(){
        $('.navbar-toggler').click(function(){
            // $(this).next().toggleClass('show');
            $(this).next().slideToggle('slow');
        });
        $('.btn-round-trip').click(function(){
            $('.date-return-active').css('display','block');
            $('#one-round-block .flight-from, #one-round-block .flight-to, #one-round-block #depart_div').removeClass('col-lg-4');
            $('#one-round-block .flight-from, #one-round-block .flight-to').addClass('col-lg-3');
            $('#one-round-block #depart_div').addClass('col-lg-6');
        });
        $('.btn-one-way').click(function(){
            $('#one-round-block .date-return-active').css('display','none');
            $('#one-round-block .flight-from, #one-round-block .flight-to, #one-round-block #depart_div').addClass('col-lg-4');
            $('#one-round-block .flight-from, #one-round-block .flight-to').removeClass('col-lg-3');
            $('#one-round-block #depart_div').removeClass('col-lg-6');
        });
        $('.btn-multy-city').click(function(){
            $('#one-round-block').hide();
            $('#multi-block').removeClass('d-none');
        });
        $('.btn-one-way, .btn-round-trip').click(function(){
            $('#multi-block').addClass('d-none');
            $('#one-round-block').show('500');
        });
        $('.passenger-change').click(function(e){
            e.preventDefault();
            $(this).next('.passenger-dropdown').slideToggle();
        });
        $('.cabin_class_list li').click(function(){
            var cabinClass = $(this).find('a').data('value');
            console.log(cabinClass);
            $(this).parents('.cabin_class_list').prev('.passenger-change').find('#cabin').html(cabinClass);
        });
    });
    // close passenger dropdown
    $(document).click(function (e) {
        if (!$(e.target).closest('.passenger-dropdown').length && !$(e.target).closest('.passenger-change').length) {
            $('.passenger-dropdown').slideUp();
        }
    });
    $('.btn-ok').click(function () {
        $('.passenger-dropdown').slideUp();
    });

    // ======================  change trip type ======================
    $(document).ready(function () {
        $('input[name="trip_type_chk"]').change(function () {
            if ($(this).is(':checked')) {
                // Update the hidden input value based on the selected radio button
                $('#tripType').val($(this).val());
            }
        });
    });
</script>
@endsection


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0N479WWRYB"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0N479WWRYB');
</script>
