@extends('front.layouts.app')
@section('title', 'Search Results at sadaticket For Cheap Flights Pakistan')
@section('styles')
<link rel="stylesheet" href="{{ asset('front-assets/css/typeahead.css')}}">
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style>

	.details-popup-content-wrapper{
		max-height: 400px;
    	overflow-y: scroll;
	}
	.details-popup-content-wrapper::-webkit-scrollbar{
		width: 8px;
	}
	.details-popup-content-wrapper::-webkit-scrollbar-thumb{
		background: #cddbf4;
	}
	.details-flight-step > .blink:before{
		content: unset !important;
	}
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
	.stops-filter-options .filter-label:hover {
		cursor:  pointer !important;
	}
	/* ---------------------return flight-------------------- */
	.flight-details-popup-inner{
		overflow: hidden !important;
		height: auto;
		max-height: auto !important;
	}
	.details-popup-content-wrapper {
		overflow-x: hidden;
		max-height: 80vh;
		overflow-y: auto;
	}
	.result-flight-item.mb-3.return-result-flight-item {
		display: flex;
		background: #fff;
		border-radius: 11px;
		padding-right: 15px;
	}
	.result-flight-item.mb-3.return-result-flight-item .flight-details{
		grid-template-columns: 0.5fr 1fr 2fr 1fr;
	}
	.flight-details-popup-inner{
		padding-right: 0
	}
	.return-flight-info,.return-flight-duration{
		border-top:none;
	}
	.flight-book-actions button{
		padding: 4px 10px;
	}
	/* ------------------end return flight---------------- */
	
/*--- /.price-range-slider ---*/
</style>
@endsection

@section('content')

    <!-- search result header Start -->
		@include('front.flight.includes.search-engine-result')
		<!-- search result header End -->

		<!-- search results Start -->
		<div class="container-fluid p-0">
			<div class="container search-main-container mb-4">
				<div class="row">
					<div class="col-lg-3">
						<div class="price-notifications d-none">
							<svg xmlns="http://www.w3.org/2000/svg" width="17" height="21" viewBox="0 0 17 21" fill="none"><path d="M1.33494 16.8789C1.33494 17.2765 1.65613 17.5977 2.05369 17.5977H14.9463C15.3438 17.5977 15.665 17.2765 15.665 16.8789V11.6455C15.665 7.68789 12.4576 4.48047 8.49998 4.48047C4.54236 4.48047 1.33494 7.68789 1.33494 11.6455V16.8789ZM2.95213 11.6455C2.95213 8.58184 5.43631 6.09766 8.49998 6.09766C11.5636 6.09766 14.0478 8.58184 14.0478 11.6455V15.9805H6.0742V12.1396C6.0742 12.0161 5.97312 11.915 5.84959 11.915H4.86131C4.73777 11.915 4.6367 12.0161 4.6367 12.1396V15.9805H2.95213V11.6455ZM1.87175 5.97412L2.76121 5.08467C2.83084 5.01504 2.83084 4.90049 2.76121 4.83086L1.23611 3.30576C1.20234 3.27232 1.15673 3.25356 1.10921 3.25356C1.06168 3.25356 1.01607 3.27232 0.982302 3.30576L0.0928487 4.19521C0.0594084 4.22899 0.0406494 4.27459 0.0406494 4.32212C0.0406494 4.36965 0.0594084 4.41525 0.0928487 4.44902L1.61795 5.97412C1.68758 6.04375 1.79988 6.04375 1.87175 5.97412ZM16.9116 4.19521L16.0221 3.30576C15.9884 3.27232 15.9428 3.25356 15.8952 3.25356C15.8477 3.25356 15.8021 3.27232 15.7683 3.30576L14.2432 4.83086C14.2098 4.86463 14.191 4.91024 14.191 4.95776C14.191 5.00529 14.2098 5.0509 14.2432 5.08467L15.1327 5.97412C15.2023 6.04375 15.3169 6.04375 15.3865 5.97412L16.9116 4.44902C16.9812 4.37715 16.9812 4.26484 16.9116 4.19521ZM15.6875 19.0352H1.31248C0.914919 19.0352 0.593728 19.3563 0.593728 19.7539V20.293C0.593728 20.3918 0.674587 20.4727 0.773415 20.4727H16.2265C16.3254 20.4727 16.4062 20.3918 16.4062 20.293V19.7539C16.4062 19.3563 16.085 19.0352 15.6875 19.0352ZM7.87107 3.04297H9.12888C9.22771 3.04297 9.30857 2.96211 9.30857 2.86328V0.707031C9.30857 0.608203 9.22771 0.527344 9.12888 0.527344H7.87107C7.77224 0.527344 7.69138 0.608203 7.69138 0.707031V2.86328C7.69138 2.96211 7.77224 3.04297 7.87107 3.04297Z" fill="#333333"></path></svg>
							<span class="font-500">GET PRICE ALERTS</span>
						</div>
						<div class="search-results-sidebar"  id="aside_filter">

							{{-- @include('front.flight.includes.sidebar-filter_old') --}}
						</div>
						<div class="mobile-sidebar-toggler">
							<i class="fa-solid fa-sliders"></i>
							Filters
						</div>
					</div>
					<div class="col-lg-9 ps-0">
						<div class="search-resuls-wrapper">
							<div class="results-header-sort">
								<div class="results-count fw-semibold">
									<span id="flightCount">0</span> Flights
								</div>
								<div class="search-results-sort">
									<div class="sort-label">
										Sort By
										<i class="fa fa-caret-down"></i>
									</div>
									<div class="sort-options">
										<label class="sort-option f-14px fw-semibold">
											<input type="checkbox" name="price" value="lowest" style="display: none">
											PRICE (LOWEST)
										</label>
										<label class="sort-option f-14px fw-semibold">
											<input type="checkbox" name="price" value="highest" style="display: none">
											PRICE (HIGHEST)
										</label>
										<label class="sort-option f-14px fw-semibold">
											<input type="checkbox" name="flight_sort" value="asc" style="display: none">
											AIRLINE ASC
										</label>
										<label class="sort-option f-14px fw-semibold">
											<input type="checkbox" name="flight_sort" value="desc" style="display: none">
											AIRLINE DESC
										</label>
									</div>
								</div>
							</div>
							<div class="result-flights-wrapper" id="appendAvailability">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- search results End -->


		<!-- flight modal -->
		<div class="flight-details-popup-wrapper" id="flight-detial-modal">
            <div class="flight-details-popup-overlay"></div>
            <div class="flight-details-popup-inner">
                <div class="details-popup-close">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon icon-close " fill="none" viewBox="0 0 18 17">
                        <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
                    </path></svg>
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
                <div class="details-popup-content-wrapper" style="height: 350px">
                    @include('front.flight.includes.modal-blinking')
                </div>
            </div>
        </div>
		<!-- flight modal -->
		


@endsection
@section('scripts')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
		<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
		@include('admin.flight.includes.typeahead')
		
<script>
	
	function submitDesktop(){
		var urlParams = new URLSearchParams(window.location.search);

		var tripType = $('#tripType').val();
		var origin = $('#typeahead_origion_desc').val();
		var destination = $('#typeahead_distination_desc').val();
		var departureDate = $('#dapart_date').val();
		var returnDate = $('#return_date').val();
		var adults = $('#adult_count').val();
		var children = $('#child_count').val();
		var infants = $('#infant_count').val();
		var ticketClass = urlParams.get('class');
		

		var currentUrl = window.location.href;
		currentUrl = updateUrlParameter(currentUrl, 'tripType', tripType);
		currentUrl = updateUrlParameter(currentUrl, 'origin', origin);
        currentUrl = updateUrlParameter(currentUrl, 'destination', destination);
        currentUrl = updateUrlParameter(currentUrl, 'depature', departureDate);
		currentUrl = updateUrlParameter(currentUrl, 'adults', adults);
        currentUrl = updateUrlParameter(currentUrl, 'children', children);
        currentUrl = updateUrlParameter(currentUrl, 'infants', infants);
        // Update the browser's address bar
        history.pushState({}, document.title, currentUrl);
		
		flightSearch(tripType,origin,destination,departureDate,returnDate,adults,children,infants,ticketClass)
	}

	function updateUrlParameter(url, param, value) {
        var re = new RegExp('([?&])' + param + '=.*?(&|$)', 'i');
        var separator = url.indexOf('?') !== -1 ? '&' : '?';
        if (url.match(re)) {
            return url.replace(re, '$1' + param + '=' + value + '$2');
        } else {
            return url + separator + param + '=' + value;
        }
    }
	
	$(document).ready(function() {
		// ----------------Date picker--------------
		var currentDate = new Date();
		$('#dapart_date').datepicker({
			format: 'yyyy-mm-dd',
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
		// Get the URL parameters from the current URL
		const urlParams = new URLSearchParams(window.location.search);

		// Retrieve specific parameters
		const tripType = urlParams.get('tripType');
		const origin = urlParams.get('origin');
		const destination = urlParams.get('destination');
		const departureDate = urlParams.get('depature');
		const returnDate = urlParams.get('return');
		const adults = urlParams.get('adults');
		const children = urlParams.get('children');
		const infants = urlParams.get('infants');
		const ticketClass = urlParams.get('class');
		// console.log(returnDate);
		flightSearch(tripType,origin,destination,departureDate,returnDate,adults,children,infants,ticketClass)
	});

	function flightSearch(tripType,origin,destination,departureDate,returnDate,adults,children,infants,ticketClass){
		var blinking = <?php echo json_encode(flightCardBlinkingFront(5)); ?>;
		$('#appendAvailability').html(blinking);
		// var asideBlinking = <?php echo json_encode(flightFilterBlinking()); ?>;
		// $('#aside_filter').html(asideBlinking);
		$.ajax({
			type:'get',
			url:"{{route('flight.availability')}}",
			data:{tripType,origin,destination,departureDate,returnDate,adults,children,infants,ticketClass},
			success:function(data) {
				var obj = JSON.parse(data);
				// console.log(data);return false;
				$('#appendAvailability').html('');
				$('#aside_filter').html('');

				if(obj.message == 'success'){
					$('#appendAvailability').append(obj.html);
					$('#aside_filter').html(obj.filter);
					TotalFlights();
				}else{
					swal("opps..!", "Server issue", "error");
				}
			}
		});
	}
	function TotalFlights(){
		var numberOfFlights = $('#appendAvailability .result-flight-item').length;
		$('#flightCount').html(numberOfFlights);
	}
	function flightModal(key){
		$(".details-tab").removeClass("tab-active");
		$("div[data-tab='details']").addClass("tab-active");
		
		$('#flight-detial-modal').addClass('details-open');
		var blinking = <?php echo json_encode(flightModalBlinkingFront(1)); ?>;
		$('.details-popup-content-wrapper').html(blinking);
		$.ajax({
                type:'post',
                url:"{{route('flight.detail.modal')}}",
                data:{key},
                success:function(data) {
					var obj = JSON.parse(data);

					if(obj.message == 'success'){
						$('.details-popup-content-wrapper').html(obj.flightDetailHtml);
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
				}

		});
	}
</script>


<script>
	
	$('.navbar-toggler').click(function(){
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

	$('.details-popup-close').click(function(){
		$(this).parents('.flight-details-popup-wrapper').removeClass('details-open');
	});
	$('.details-tab').click(function(){
		$(this).addClass('tab-active');
		$(this).siblings().removeClass('tab-active');
		var dataTab = $(this).data('tab');
		$(this).parents('.details-popup-tabs-wrapper').siblings('.details-popup-content-wrapper').find('.details-content').removeClass('content-active');
		$(this).parents('.details-popup-tabs-wrapper').siblings('.details-popup-content-wrapper').find('.details-content.'+dataTab).addClass('content-active');
	});

	if($(window).width() <= 768){
		$('.sort-label').click(function(){
			$(this).next().slideToggle();
		});
		$('.mobile-sidebar-toggler').click(function(){
			$('.search-results-sidebar').addClass('sidebar-open');
			$('body').css('position','fixed');
		});
		$('.filter-close').click(function(){
			$('.search-results-sidebar').removeClass('sidebar-open');
			$('body').css('position','initial');
		});

		$('.search-modify-btn').click(function(){
			$('.search-details-row-desktop').addClass('mobile-widget-open');
			$('body').addClass('mobile-widget-open');
		});
		$('.widget-close').click(function(){
			$('.search-details-row-desktop').removeClass('mobile-widget-open');
			$('body').removeClass('mobile-widget-open');
		})
		$('.widget-close-submit').click(function(){
			$('.search-details-row-desktop').removeClass('mobile-widget-open');
			$('body').removeClass('mobile-widget-open');
		})
	}
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
	// close passenger dropdown
    $(document).click(function (e) {
        if (!$(e.target).closest('.passenger-dropdown').length && !$(e.target).closest('.passenger-change').length) {
            $('.passenger-dropdown').slideUp();
        }
    });
    $('.btn-ok').click(function () {
        $('.passenger-dropdown').slideUp();
    });
	// Filter sidebar

	$(document).ready(function() {
		$('input[name="price"]').change(function() {
			if ($(this).is(":checked")) {
				$(this).parent('label').css('background', 'darkgray');
			} else {
				$(this).parent('label').css('background', '#fff'); // Set the background color back to the default color when unchecked
			}
		});
		$('input[name="flight_sort"]').change(function() {
			if ($(this).is(":checked")) {
				$(this).parent('label').css('background', 'darkgray');
			} else {
				$(this).parent('label').css('background', '#fff'); // Set the background color back to the default color when unchecked
			}
		});
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



