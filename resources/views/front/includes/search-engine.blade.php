<div class="container-fluid search-engine-wrapper pt-4 pb-5">
	<div class="container">
		<div class="search-engine-header text-center">
			<h1>Book Flights Online</h1>
		</div>
		<div class="row">
			
			<div class="col-12 flight-btn-row">
				<a href="#flight" aria-controls="home" class="align-items-center active" role="tab" data-toggle="tab">
					<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20.012 18v2h-20v-2h20zm3.973-13.118c.154 1.349-.884 2.615-1.927 3.491-.877.735-9.051 6.099-9.44 6.307-1.756.936-3.332 1.306-4.646 1.32-1.36.014-2.439-.354-3.144-.872l-4.784-3.977 3.742-2.373 4.203 1.445.984-.578-4.973-3.645 3.678-2.124 7.992 1.545c.744-.445 1.482-.9 2.225-1.348 1.049-.623 2.056-1.055 3.387-1.055 1.321 0 2.552.52 2.703 1.864zm-4.341.512c-.419.192-3.179 1.882-3.615 2.144l-8.01-1.55-.418.241 5.288 3.307-4.683 2.876-4.214-1.448-.69.395c.917.729 1.787 1.522 2.751 2.186 1.472.962 4.344.22 5.685-.663.9-.592 7.551-4.961 8.436-5.582.605-.431 1.797-1.414 1.824-2.152l.001-.004c-.644-.287-1.716-.041-2.355.25z"/></svg>
					Flights
				</a>
			</div>
			
			<div class="col-12 search-row-wrapper">
				<div class="check-box-row p-0 pt-2">
					<div class="form-check d-flex flex-wrap align-items-center">
						<label class="form-check-label btn-one-way" for="oneway-trip">
						<input type="radio" value="oneway" name="trip_type_chk" id="oneway-trip" checked=""> <span>One Way</span></label>
					</div>
					<div class="form-check d-flex flex-wrap align-items-center">
						<label class="form-check-label btn-round-trip" for="round-trip">
						<input type="radio" value="return" name="trip_type_chk" id="round-trip"> <span>Return</span></label>
					</div>
					<div class="form-check d-flex flex-wrap align-items-center">
						<label class="form-check-label btn-multy-city" for="multicity-trip">
						<input type="radio" value="multicity" name="trip_type_chk" id="multicity-trip"> <span>Multi-City</span></label>
					</div>
				</div>
						
				<div class="flight-tab-switcher" id="one-round-block">
					<form autocomplete="off" name="flight" id="flight-search-form" action="{{ route('flight.search') }}" class="row flight-search-form" novalidate="true">
						<div class="form-row">
							<div class="row no-gutter search-inputs-row">

								<div class="flight-from col-6 col-sm-6 col-md-4 col-lg-4 pe-0">
									<div class="search-input mb-0 form-group">
										<svg xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17" fill="none">
											<path d="M7.5 9.20898C8.6736 9.20898 9.625 8.25759 9.625 7.08398C9.625 5.91038 8.6736 4.95898 7.5 4.95898C6.32639 4.95898 5.375 5.91038 5.375 7.08398C5.375 8.25759 6.32639 9.20898 7.5 9.20898Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M7.49967 1.41699C5.99678 1.41699 4.55544 2.01401 3.49274 3.07672C2.43003 4.13943 1.83301 5.58077 1.83301 7.08366C1.83301 8.42383 2.11776 9.30074 2.89551 10.2712L7.49967 15.5837L12.1038 10.2712C12.8816 9.30074 13.1663 8.42383 13.1663 7.08366C13.1663 5.58077 12.5693 4.13943 11.5066 3.07672C10.4439 2.01401 9.00257 1.41699 7.49967 1.41699V1.41699Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>
										<input class="form-control autocomplete-airports typeahead typeahead_origion" name="origin" value="" id="origin_code" placeholder="Flying from" tabindex="1" required="">
										<a href="javascript:void(0);" class="btn-way-switch" onclick="changeDepartArrival();">
											<svg xmlns="http://www.w3.org/2000/svg" class="flip-ico" width="28" height="28" viewBox="0 0 28 28" fill="none">
												<circle cx="14" cy="14" r="14" fill="#C4C4C4"></circle>
												<path d="M12 8.99959C11.7348 8.99959 11.4804 9.10495 11.2929 9.29249C11.1054 9.48002 11 9.73438 11 9.99959C11 10.2648 11.1054 10.5192 11.2929 10.7067C11.4804 10.8942 11.7348 10.9996 12 10.9996H17.586L16.293 12.2926C16.1108 12.4812 16.01 12.7338 16.0123 12.996C16.0146 13.2582 16.1198 13.509 16.3052 13.6944C16.4906 13.8798 16.7414 13.985 17.0036 13.9873C17.2658 13.9895 17.5184 13.8888 17.707 13.7066L20.707 10.7066C20.8945 10.5191 20.9998 10.2648 20.9998 9.99959C20.9998 9.73443 20.8945 9.48012 20.707 9.29259L17.707 6.29259C17.6148 6.19708 17.5044 6.1209 17.3824 6.06849C17.2604 6.01608 17.1292 5.9885 16.9964 5.98734C16.8636 5.98619 16.7319 6.01149 16.609 6.06177C16.4861 6.11205 16.3745 6.18631 16.2806 6.2802C16.1867 6.37409 16.1125 6.48574 16.0622 6.60864C16.0119 6.73154 15.9866 6.86321 15.9877 6.99599C15.9889 7.12877 16.0165 7.25999 16.0689 7.382C16.1213 7.504 16.1975 7.61435 16.293 7.70659L17.586 8.99959H12Z" fill="#333333"></path>
												<path d="M15.9998 18.9996C16.265 18.9996 16.5194 18.8942 16.7069 18.7067C16.8944 18.5192 16.9998 18.2648 16.9998 17.9996C16.9998 17.7344 16.8944 17.48 16.7069 17.2925C16.5194 17.105 16.265 16.9996 15.9998 16.9996H10.4138L11.7068 15.7066C11.8023 15.6143 11.8785 15.504 11.9309 15.382C11.9833 15.26 12.0109 15.1288 12.012 14.996C12.0132 14.8632 11.9879 14.7315 11.9376 14.6086C11.8873 14.4857 11.8131 14.3741 11.7192 14.2802C11.6253 14.1863 11.5136 14.1121 11.3907 14.0618C11.2678 14.0115 11.1362 13.9862 11.0034 13.9873C10.8706 13.9885 10.7394 14.0161 10.6174 14.0685C10.4954 14.1209 10.385 14.1971 10.2928 14.2926L7.29279 17.2926C7.10532 17.4801 7 17.7344 7 17.9996C7 18.2648 7.10532 18.5191 7.29279 18.7066L10.2928 21.7066C10.4814 21.8888 10.734 21.9895 10.9962 21.9873C11.2584 21.985 11.5092 21.8798 11.6946 21.6944C11.88 21.509 11.9852 21.2582 11.9875 20.996C11.9897 20.7338 11.8889 20.4812 11.7068 20.2926L10.4138 18.9996H15.9998Z" fill="#333333"></path>
											</svg>
										</a>
									</div>
								</div>
								<div class="flight-to col-6 col-sm-6 col-md-4 col-lg-4 pe-0">
									<div class="search-input mb-0 form-group">
										<svg xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17" fill="none">
											<path d="M7.5 9.20898C8.6736 9.20898 9.625 8.25759 9.625 7.08398C9.625 5.91038 8.6736 4.95898 7.5 4.95898C6.32639 4.95898 5.375 5.91038 5.375 7.08398C5.375 8.25759 6.32639 9.20898 7.5 9.20898Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M7.49967 1.41699C5.99678 1.41699 4.55544 2.01401 3.49274 3.07672C2.43003 4.13943 1.83301 5.58077 1.83301 7.08366C1.83301 8.42383 2.11776 9.30074 2.89551 10.2712L7.49967 15.5837L12.1038 10.2712C12.8816 9.30074 13.1663 8.42383 13.1663 7.08366C13.1663 5.58077 12.5693 4.13943 11.5066 3.07672C10.4439 2.01401 9.00257 1.41699 7.49967 1.41699V1.41699Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>
										<input type="text" name="destination" value="" id="destination_code" tabindex="2" placeholder="Flying to" class="autocomplete-airports form-control typeahead typeahead_distination" required="">
									</div>
								</div>
								
								<div class="col-12 d-flex align-items-end col-md-4 col-lg-4 mt-sm-3 pe-sm-3 pe-xs-3" id="depart_div">
									<div class="date-input date-from mb-0">
										<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
											<path d="M3.9375 0C4.08668 0 4.22976 0.0592632 4.33525 0.164752C4.44074 0.270242 4.5 0.413316 4.5 0.5625V1.125H13.5V0.5625C13.5 0.413316 13.5593 0.270242 13.6648 0.164752C13.7702 0.0592632 13.9133 0 14.0625 0C14.2117 0 14.3548 0.0592632 14.4602 0.164752C14.5657 0.270242 14.625 0.413316 14.625 0.5625V1.125H15.75C16.3467 1.125 16.919 1.36205 17.341 1.78401C17.7629 2.20597 18 2.77826 18 3.375V15.75C18 16.3467 17.7629 16.919 17.341 17.341C16.919 17.7629 16.3467 18 15.75 18H2.25C1.65326 18 1.08097 17.7629 0.65901 17.341C0.237053 16.919 0 16.3467 0 15.75V3.375C0 2.77826 0.237053 2.20597 0.65901 1.78401C1.08097 1.36205 1.65326 1.125 2.25 1.125H3.375V0.5625C3.375 0.413316 3.43426 0.270242 3.53975 0.164752C3.64524 0.0592632 3.78832 0 3.9375 0V0ZM1.125 4.5V15.75C1.125 16.0484 1.24353 16.3345 1.4545 16.5455C1.66548 16.7565 1.95163 16.875 2.25 16.875H15.75C16.0484 16.875 16.3345 16.7565 16.5455 16.5455C16.7565 16.3345 16.875 16.0484 16.875 15.75V4.5H1.125Z" fill="#333333"/>
											</svg>
										<input type="date" class="form-control pl-5" name="depature" value="{{ date('d/m/Y')}}" readonly="true" autocomplete="off" required="" id="dapart_date">
									</div>
									<div class="date-input date-from mb-0 date-return-active" style="display:none;">
										<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
											<path d="M3.9375 0C4.08668 0 4.22976 0.0592632 4.33525 0.164752C4.44074 0.270242 4.5 0.413316 4.5 0.5625V1.125H13.5V0.5625C13.5 0.413316 13.5593 0.270242 13.6648 0.164752C13.7702 0.0592632 13.9133 0 14.0625 0C14.2117 0 14.3548 0.0592632 14.4602 0.164752C14.5657 0.270242 14.625 0.413316 14.625 0.5625V1.125H15.75C16.3467 1.125 16.919 1.36205 17.341 1.78401C17.7629 2.20597 18 2.77826 18 3.375V15.75C18 16.3467 17.7629 16.919 17.341 17.341C16.919 17.7629 16.3467 18 15.75 18H2.25C1.65326 18 1.08097 17.7629 0.65901 17.341C0.237053 16.919 0 16.3467 0 15.75V3.375C0 2.77826 0.237053 2.20597 0.65901 1.78401C1.08097 1.36205 1.65326 1.125 2.25 1.125H3.375V0.5625C3.375 0.413316 3.43426 0.270242 3.53975 0.164752C3.64524 0.0592632 3.78832 0 3.9375 0V0ZM1.125 4.5V15.75C1.125 16.0484 1.24353 16.3345 1.4545 16.5455C1.66548 16.7565 1.95163 16.875 2.25 16.875H15.75C16.0484 16.875 16.3345 16.7565 16.5455 16.5455C16.7565 16.3345 16.875 16.0484 16.875 15.75V4.5H1.125Z" fill="#333333"/>
											</svg>
										<input type="date" class="form-control pl-5" name="return" value="" readonly="true" autocomplete="off" required="" tabindex="4" id="return_date">
									</div>
								</div>
							</div>
							<div class="row no-gutter align-items-center mb-0">
								<div class="col-12 col-lg-6 col-md-3 col-sm-4">
									<div class="flight-checkbox d-flex flex-wrap align-items-center" for="check-direct">
										<input type="checkbox" name="direct" id="mbl-check-direct" class="form-check-input mr-2 ml-2" tabindex="5" value="1"><span>Direct flights only</span>
									</div>
								</div>
								<div class="col-6 col-lg-2 col-md-3 col-sm-4">
									<div class="select-wrap">
										<a href="#" class="passenger-change ">
											<p class="form-paxs dropdown-toggle">
												<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
													<path d="M18.4444 16.4055C18.0391 15.4455 17.451 14.5735 16.7128 13.8381C15.9768 13.1005 15.1049 12.5125 14.1454 12.1064C14.1368 12.1021 14.1282 12.1 14.1196 12.0957C15.4581 11.1289 16.3282 9.5541 16.3282 7.77734C16.3282 4.83398 13.9434 2.44922 11.0001 2.44922C8.0567 2.44922 5.67193 4.83398 5.67193 7.77734C5.67193 9.5541 6.54205 11.1289 7.88052 12.0979C7.87193 12.1021 7.86334 12.1043 7.85474 12.1086C6.89224 12.5146 6.02857 13.0969 5.28736 13.8402C4.54982 14.5762 3.96178 15.4481 3.55572 16.4076C3.1568 17.347 2.94166 18.3542 2.92193 19.3746C2.92136 19.3975 2.92538 19.4204 2.93376 19.4417C2.94214 19.4631 2.95471 19.4825 2.97072 19.4989C2.98674 19.5153 3.00588 19.5284 3.02702 19.5373C3.04816 19.5462 3.07087 19.5508 3.0938 19.5508H4.38287C4.4774 19.5508 4.55259 19.4756 4.55474 19.3832C4.59771 17.7246 5.26373 16.1713 6.44107 14.9939C7.65923 13.7758 9.27701 13.1055 11.0001 13.1055C12.7231 13.1055 14.3409 13.7758 15.559 14.9939C16.7364 16.1713 17.4024 17.7246 17.4454 19.3832C17.4475 19.4777 17.5227 19.5508 17.6172 19.5508H18.9063C18.9292 19.5508 18.952 19.5462 18.9731 19.5373C18.9942 19.5284 19.0134 19.5153 19.0294 19.4989C19.0454 19.4825 19.058 19.4631 19.0664 19.4417C19.0747 19.4204 19.0788 19.3975 19.0782 19.3746C19.0567 18.3477 18.844 17.3486 18.4444 16.4055ZM11.0001 11.4727C10.0139 11.4727 9.0858 11.0881 8.38755 10.3898C7.68931 9.6916 7.30474 8.76348 7.30474 7.77734C7.30474 6.79121 7.68931 5.86309 8.38755 5.16484C9.0858 4.4666 10.0139 4.08203 11.0001 4.08203C11.9862 4.08203 12.9143 4.4666 13.6126 5.16484C14.3108 5.86309 14.6954 6.79121 14.6954 7.77734C14.6954 8.76348 14.3108 9.6916 13.6126 10.3898C12.9143 11.0881 11.9862 11.4727 11.0001 11.4727Z" fill="#333333"></path>
												</svg>&nbsp;<span class="passenger-count">1</span> Passenger(s)
											</p>  
										</a>
										<div class="passenger-dropdown" role="menu">
											<div class="row no-gutter">
												<p class="col-lg-7">Adults (12+) </p>
												<div class="col-lg-5">
													<div class="input-group input-group-sm pull-right">
														<span class="input-group-btn">
															<a class="btn btn-default number-spinner-flight" data-field="adult_count" data-type="minus"> <span class="fa fa-minus"></span></a>
														</span>
														<input type="text" class="form-control text-center spinner-value-flight" name="adults" id="adult_count" value="1" max="9" min="1" readonly="readonly">
														<span class="input-group-btn">
															<a class="btn btn-default number-spinner-flight" data-field="adult_count" data-type="plus"><span class="fa fa-plus"></span></a>
														</span>
													</div> 
												</div> <!-- col// -->
											</div> <!-- row// -->
											
											<div class="row no-gutter">
												<p class="col-lg-7"> Children (2-12) </p>
												<div class="col-lg-5">
													<div class="input-group input-group-sm pull-right">
														<span class="input-group-btn">
															<a class="btn btn-default number-spinner-flight" data-field="child_count" data-type="minus"> <span class="fa fa-minus"></span></a>
														</span>
														<input type="text" class="form-control text-center spinner-value-flight" name="children" id="child_count" value="0" max="8" min="0" readonly="readonly">
														<span class="input-group-btn">
															<a class="btn btn-default number-spinner-flight" data-field="child_count" data-type="plus"><span class="fa fa-plus"></span></a>
														</span>
													</div> 
												</div> <!-- col// -->
											</div> <!-- row// -->
											
											<div class="row no-gutter">
												<p class="col-lg-7"> Infant (0-2) </p>
												<div class="col-lg-5">
													<div class="input-group input-group-sm pull-right">
														<span class="input-group-btn">
															<a class="btn btn-default number-spinner-flight" data-field="infant_count" data-type="minus"> <span class="fa fa-minus"></span></a>
														</span>
														<input type="text" class="form-control text-center spinner-value-flight" name="infants" id="infant_count" value="0" max="4" min="0" readonly="readonly">
														<span class="input-group-btn">
															<a class="btn btn-default number-spinner-flight" data-field="infant_count" data-type="plus"><span class="fa fa-plus"></span></a>
														</span>
													</div>
												</div>
											</div>                             
											<a href="javascript:;" class="btn button w-100 green_btn text-uppercase btn-ok mt-2"> ok </a>
										</div>   <!-- passenger-dropdown //  -->                       
									</div>
								</div>
								<div class="col-6 col-lg-2 col-md-3 col-sm-4">
									<input type="hidden" value="Economy" id="mbl-cabin_class" name="class">
									<div class="select-wrap dropdown"><a href="javascript:;" class="passenger-change ">
										<p class="form-paxs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
												<path d="M4.45818 4.69981C3.70818 4.16647 3.52485 3.13314 4.04985 2.37481C4.57485 1.62481 5.61651 1.44147 6.37485 1.96647C7.12485 2.49981 7.30818 3.53314 6.78318 4.29147C6.24985 5.04147 5.21651 5.22481 4.45818 4.69981ZM13.3332 16.6665C13.3332 16.2081 12.9582 15.8331 12.4998 15.8331H7.44151C6.20818 15.8331 5.15818 14.9331 4.97485 13.7165L3.46651 6.48314C3.42878 6.29906 3.32847 6.13372 3.18263 6.01523C3.03679 5.89673 2.85442 5.83239 2.66651 5.83314C2.14985 5.83314 1.76651 6.30814 1.86651 6.81647L3.32485 13.9665C3.47793 14.9506 3.9778 15.8477 4.73424 16.4956C5.49068 17.1435 6.45384 17.4997 7.44985 17.4998H12.4998C12.9582 17.4998 13.3332 17.1248 13.3332 16.6665ZM12.9498 12.4998H9.45818L8.59985 9.08314C9.66651 9.68314 10.7915 10.1498 12.0165 10.1665C12.4998 10.1748 12.8915 9.75814 12.8915 9.27481C12.8915 8.78314 12.4832 8.40814 11.9915 8.39147C10.8998 8.35814 9.79985 7.92481 8.98318 7.28314L7.61651 6.22481C7.42485 6.07481 7.20818 5.97481 6.98318 5.90814C6.71552 5.82918 6.43342 5.81209 6.15818 5.85814H6.14151C5.65079 5.94526 5.21434 6.22269 4.92717 6.63004C4.64 7.03739 4.52535 7.54168 4.60818 8.03314L5.73318 12.9665C5.8431 13.5381 6.14855 14.0537 6.59712 14.4247C7.04568 14.7957 7.60939 14.9991 8.19151 14.9998H13.8998L16.4748 17.0165C16.8248 17.2915 17.3248 17.2581 17.6332 16.9498C18.0082 16.5748 17.9665 15.9665 17.5498 15.6415L13.9748 12.8498C13.6814 12.6228 13.3208 12.4997 12.9498 12.4998Z" fill="#333333"></path>
											</svg>&nbsp;<span id="cabin">Economy</span>
											<span class="caret"></span>
										</p></a>
										<ul class="passenger-dropdown dropdown-menu cabin-class-list" aria-labelledby="dropdownMenu1" role="menu">
											<li class="p-1"><a href="javascript:;" data-value="Economy" data-lang="Economy" class="cabin-link">Economy</a></li>
											<li class="p-1"><a href="javascript:;" data-value="Business" data-lang="Business" class="cabin-link">Business</a></li>
											<li class="p-1"><a href="javascript:;" data-value="First" data-lang="First" class="cabin-link">First</a></li>
										</ul>
									</div>
								</div>
								<div class="col-12 col-md-3 col-sm-12 col-lg-2 mb-0">
									<button class="button green_btn form-btn uppercase m-0 w-100 availability" style="min-height:40px;">                           
										Search                            
									</button>
								</div>
							</div>
						</div>
						<input type="hidden" class="trip-type-hidden" name="tripType" id="tripType" value="oneway">
					</form>
				</div>
					
				<div class="flight-tab-switcher d-none" id="multi-block">
					<form autocomplete="off" name="flight" id="flight" action="#" class="row flight-search-form" novalidate="true">
						<div class="form-row">
							<div class="row no-gutter">
								<div class="flight-from col-6 col-md-6 col-sm-6 col-lg-4 pe-0">
									<div class="search-input mb-0 form-group">
										<svg xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17" fill="none">
											<path d="M7.5 9.20898C8.6736 9.20898 9.625 8.25759 9.625 7.08398C9.625 5.91038 8.6736 4.95898 7.5 4.95898C6.32639 4.95898 5.375 5.91038 5.375 7.08398C5.375 8.25759 6.32639 9.20898 7.5 9.20898Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M7.49967 1.41699C5.99678 1.41699 4.55544 2.01401 3.49274 3.07672C2.43003 4.13943 1.83301 5.58077 1.83301 7.08366C1.83301 8.42383 2.11776 9.30074 2.89551 10.2712L7.49967 15.5837L12.1038 10.2712C12.8816 9.30074 13.1663 8.42383 13.1663 7.08366C13.1663 5.58077 12.5693 4.13943 11.5066 3.07672C10.4439 2.01401 9.00257 1.41699 7.49967 1.41699V1.41699Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>
										<input class="form-control autocomplete-airports" name="from" value="" id="autocomplete1" placeholder="Flying from" tabindex="1" required="">
										<a href="javascript:void(0);" class="btn-way-switch" onclick="changeDepartArrival();">
											<svg xmlns="http://www.w3.org/2000/svg" class="flip-ico" width="28" height="28" viewBox="0 0 28 28" fill="none">
												<circle cx="14" cy="14" r="14" fill="#C4C4C4"></circle>
												<path d="M12 8.99959C11.7348 8.99959 11.4804 9.10495 11.2929 9.29249C11.1054 9.48002 11 9.73438 11 9.99959C11 10.2648 11.1054 10.5192 11.2929 10.7067C11.4804 10.8942 11.7348 10.9996 12 10.9996H17.586L16.293 12.2926C16.1108 12.4812 16.01 12.7338 16.0123 12.996C16.0146 13.2582 16.1198 13.509 16.3052 13.6944C16.4906 13.8798 16.7414 13.985 17.0036 13.9873C17.2658 13.9895 17.5184 13.8888 17.707 13.7066L20.707 10.7066C20.8945 10.5191 20.9998 10.2648 20.9998 9.99959C20.9998 9.73443 20.8945 9.48012 20.707 9.29259L17.707 6.29259C17.6148 6.19708 17.5044 6.1209 17.3824 6.06849C17.2604 6.01608 17.1292 5.9885 16.9964 5.98734C16.8636 5.98619 16.7319 6.01149 16.609 6.06177C16.4861 6.11205 16.3745 6.18631 16.2806 6.2802C16.1867 6.37409 16.1125 6.48574 16.0622 6.60864C16.0119 6.73154 15.9866 6.86321 15.9877 6.99599C15.9889 7.12877 16.0165 7.25999 16.0689 7.382C16.1213 7.504 16.1975 7.61435 16.293 7.70659L17.586 8.99959H12Z" fill="#333333"></path>
												<path d="M15.9998 18.9996C16.265 18.9996 16.5194 18.8942 16.7069 18.7067C16.8944 18.5192 16.9998 18.2648 16.9998 17.9996C16.9998 17.7344 16.8944 17.48 16.7069 17.2925C16.5194 17.105 16.265 16.9996 15.9998 16.9996H10.4138L11.7068 15.7066C11.8023 15.6143 11.8785 15.504 11.9309 15.382C11.9833 15.26 12.0109 15.1288 12.012 14.996C12.0132 14.8632 11.9879 14.7315 11.9376 14.6086C11.8873 14.4857 11.8131 14.3741 11.7192 14.2802C11.6253 14.1863 11.5136 14.1121 11.3907 14.0618C11.2678 14.0115 11.1362 13.9862 11.0034 13.9873C10.8706 13.9885 10.7394 14.0161 10.6174 14.0685C10.4954 14.1209 10.385 14.1971 10.2928 14.2926L7.29279 17.2926C7.10532 17.4801 7 17.7344 7 17.9996C7 18.2648 7.10532 18.5191 7.29279 18.7066L10.2928 21.7066C10.4814 21.8888 10.734 21.9895 10.9962 21.9873C11.2584 21.985 11.5092 21.8798 11.6946 21.6944C11.88 21.509 11.9852 21.2582 11.9875 20.996C11.9897 20.7338 11.8889 20.4812 11.7068 20.2926L10.4138 18.9996H15.9998Z" fill="#333333"></path>
											</svg>
										</a>
									</div>
								</div>
								<div class="flight-to col-6 col-sm-6 col-md-6 col-lg-4 pe-sm-0">
									<div class="search-input mb-0 form-group">
										<svg xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17" fill="none">
											<path d="M7.5 9.20898C8.6736 9.20898 9.625 8.25759 9.625 7.08398C9.625 5.91038 8.6736 4.95898 7.5 4.95898C6.32639 4.95898 5.375 5.91038 5.375 7.08398C5.375 8.25759 6.32639 9.20898 7.5 9.20898Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M7.49967 1.41699C5.99678 1.41699 4.55544 2.01401 3.49274 3.07672C2.43003 4.13943 1.83301 5.58077 1.83301 7.08366C1.83301 8.42383 2.11776 9.30074 2.89551 10.2712L7.49967 15.5837L12.1038 10.2712C12.8816 9.30074 13.1663 8.42383 13.1663 7.08366C13.1663 5.58077 12.5693 4.13943 11.5066 3.07672C10.4439 2.01401 9.00257 1.41699 7.49967 1.41699V1.41699Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>
										<input type="text" name="to" value="" id="autocomplete2" tabindex="2" placeholder="Flying to" class="autocomplete-airports form-control" required="">
									</div>
								</div>
								
								<div class="col-12 d-flex align-items-end col-xs-6 col-lg-4" id="depart_div">
									<div class="date-input date-from mb-0">
										<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
											<path d="M3.9375 0C4.08668 0 4.22976 0.0592632 4.33525 0.164752C4.44074 0.270242 4.5 0.413316 4.5 0.5625V1.125H13.5V0.5625C13.5 0.413316 13.5593 0.270242 13.6648 0.164752C13.7702 0.0592632 13.9133 0 14.0625 0C14.2117 0 14.3548 0.0592632 14.4602 0.164752C14.5657 0.270242 14.625 0.413316 14.625 0.5625V1.125H15.75C16.3467 1.125 16.919 1.36205 17.341 1.78401C17.7629 2.20597 18 2.77826 18 3.375V15.75C18 16.3467 17.7629 16.919 17.341 17.341C16.919 17.7629 16.3467 18 15.75 18H2.25C1.65326 18 1.08097 17.7629 0.65901 17.341C0.237053 16.919 0 16.3467 0 15.75V3.375C0 2.77826 0.237053 2.20597 0.65901 1.78401C1.08097 1.36205 1.65326 1.125 2.25 1.125H3.375V0.5625C3.375 0.413316 3.43426 0.270242 3.53975 0.164752C3.64524 0.0592632 3.78832 0 3.9375 0V0ZM1.125 4.5V15.75C1.125 16.0484 1.24353 16.3345 1.4545 16.5455C1.66548 16.7565 1.95163 16.875 2.25 16.875H15.75C16.0484 16.875 16.3345 16.7565 16.5455 16.5455C16.7565 16.3345 16.875 16.0484 16.875 15.75V4.5H1.125Z" fill="#333333"/>
											</svg>
										<input type="text" class="form-control from-date pl-5 hasDatepicker" name="depature" value="" readonly="true" autocomplete="off" required="" tabindex="3" id="dapart_date12345">
									</div>
								</div>
							</div>
							<div class="row no-gutter mb-3">
								<div class="flight-from col-6 col-sm-6 col-md-6 col-lg-4 pe-0">
									<div class="search-input mb-0 form-group">
										<svg xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17" fill="none">
											<path d="M7.5 9.20898C8.6736 9.20898 9.625 8.25759 9.625 7.08398C9.625 5.91038 8.6736 4.95898 7.5 4.95898C6.32639 4.95898 5.375 5.91038 5.375 7.08398C5.375 8.25759 6.32639 9.20898 7.5 9.20898Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M7.49967 1.41699C5.99678 1.41699 4.55544 2.01401 3.49274 3.07672C2.43003 4.13943 1.83301 5.58077 1.83301 7.08366C1.83301 8.42383 2.11776 9.30074 2.89551 10.2712L7.49967 15.5837L12.1038 10.2712C12.8816 9.30074 13.1663 8.42383 13.1663 7.08366C13.1663 5.58077 12.5693 4.13943 11.5066 3.07672C10.4439 2.01401 9.00257 1.41699 7.49967 1.41699V1.41699Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>
										<input class="form-control autocomplete-airports" name="from" value="" id="mbl-autocomplete1" placeholder="Flying from" tabindex="1" required="">
										<a href="javascript:void(0);" class="btn-way-switch" >
											<svg xmlns="http://www.w3.org/2000/svg" class="flip-ico" width="28" height="28" viewBox="0 0 28 28" fill="none">
												<circle cx="14" cy="14" r="14" fill="#C4C4C4"></circle>
												<path d="M12 8.99959C11.7348 8.99959 11.4804 9.10495 11.2929 9.29249C11.1054 9.48002 11 9.73438 11 9.99959C11 10.2648 11.1054 10.5192 11.2929 10.7067C11.4804 10.8942 11.7348 10.9996 12 10.9996H17.586L16.293 12.2926C16.1108 12.4812 16.01 12.7338 16.0123 12.996C16.0146 13.2582 16.1198 13.509 16.3052 13.6944C16.4906 13.8798 16.7414 13.985 17.0036 13.9873C17.2658 13.9895 17.5184 13.8888 17.707 13.7066L20.707 10.7066C20.8945 10.5191 20.9998 10.2648 20.9998 9.99959C20.9998 9.73443 20.8945 9.48012 20.707 9.29259L17.707 6.29259C17.6148 6.19708 17.5044 6.1209 17.3824 6.06849C17.2604 6.01608 17.1292 5.9885 16.9964 5.98734C16.8636 5.98619 16.7319 6.01149 16.609 6.06177C16.4861 6.11205 16.3745 6.18631 16.2806 6.2802C16.1867 6.37409 16.1125 6.48574 16.0622 6.60864C16.0119 6.73154 15.9866 6.86321 15.9877 6.99599C15.9889 7.12877 16.0165 7.25999 16.0689 7.382C16.1213 7.504 16.1975 7.61435 16.293 7.70659L17.586 8.99959H12Z" fill="#333333"></path>
												<path d="M15.9998 18.9996C16.265 18.9996 16.5194 18.8942 16.7069 18.7067C16.8944 18.5192 16.9998 18.2648 16.9998 17.9996C16.9998 17.7344 16.8944 17.48 16.7069 17.2925C16.5194 17.105 16.265 16.9996 15.9998 16.9996H10.4138L11.7068 15.7066C11.8023 15.6143 11.8785 15.504 11.9309 15.382C11.9833 15.26 12.0109 15.1288 12.012 14.996C12.0132 14.8632 11.9879 14.7315 11.9376 14.6086C11.8873 14.4857 11.8131 14.3741 11.7192 14.2802C11.6253 14.1863 11.5136 14.1121 11.3907 14.0618C11.2678 14.0115 11.1362 13.9862 11.0034 13.9873C10.8706 13.9885 10.7394 14.0161 10.6174 14.0685C10.4954 14.1209 10.385 14.1971 10.2928 14.2926L7.29279 17.2926C7.10532 17.4801 7 17.7344 7 17.9996C7 18.2648 7.10532 18.5191 7.29279 18.7066L10.2928 21.7066C10.4814 21.8888 10.734 21.9895 10.9962 21.9873C11.2584 21.985 11.5092 21.8798 11.6946 21.6944C11.88 21.509 11.9852 21.2582 11.9875 20.996C11.9897 20.7338 11.8889 20.4812 11.7068 20.2926L10.4138 18.9996H15.9998Z" fill="#333333"></path>
											</svg>
										</a>
									</div>
								</div>
								<div class="flight-to col-6 col-sm-6 col-md-6 col-lg-4 pe-sm-0">
									<div class="search-input mb-0 form-group">
										<svg xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17" fill="none">
											<path d="M7.5 9.20898C8.6736 9.20898 9.625 8.25759 9.625 7.08398C9.625 5.91038 8.6736 4.95898 7.5 4.95898C6.32639 4.95898 5.375 5.91038 5.375 7.08398C5.375 8.25759 6.32639 9.20898 7.5 9.20898Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M7.49967 1.41699C5.99678 1.41699 4.55544 2.01401 3.49274 3.07672C2.43003 4.13943 1.83301 5.58077 1.83301 7.08366C1.83301 8.42383 2.11776 9.30074 2.89551 10.2712L7.49967 15.5837L12.1038 10.2712C12.8816 9.30074 13.1663 8.42383 13.1663 7.08366C13.1663 5.58077 12.5693 4.13943 11.5066 3.07672C10.4439 2.01401 9.00257 1.41699 7.49967 1.41699V1.41699Z" stroke="#333333" stroke-width="2.33333" stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>
										<input type="text" name="to" value="{{ date('d/m/Y')}}" id="mbl-autocomplete2" tabindex="2" placeholder="Flying to" class="autocomplete-airports form-control" required="">
									</div>
								</div>
								
								<div class="col-12 d-flex align-items-end col-xs-6 col-lg-4" id="depart_div">
									<div class="date-input date-from mb-0">
										<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
											<path d="M3.9375 0C4.08668 0 4.22976 0.0592632 4.33525 0.164752C4.44074 0.270242 4.5 0.413316 4.5 0.5625V1.125H13.5V0.5625C13.5 0.413316 13.5593 0.270242 13.6648 0.164752C13.7702 0.0592632 13.9133 0 14.0625 0C14.2117 0 14.3548 0.0592632 14.4602 0.164752C14.5657 0.270242 14.625 0.413316 14.625 0.5625V1.125H15.75C16.3467 1.125 16.919 1.36205 17.341 1.78401C17.7629 2.20597 18 2.77826 18 3.375V15.75C18 16.3467 17.7629 16.919 17.341 17.341C16.919 17.7629 16.3467 18 15.75 18H2.25C1.65326 18 1.08097 17.7629 0.65901 17.341C0.237053 16.919 0 16.3467 0 15.75V3.375C0 2.77826 0.237053 2.20597 0.65901 1.78401C1.08097 1.36205 1.65326 1.125 2.25 1.125H3.375V0.5625C3.375 0.413316 3.43426 0.270242 3.53975 0.164752C3.64524 0.0592632 3.78832 0 3.9375 0V0ZM1.125 4.5V15.75C1.125 16.0484 1.24353 16.3345 1.4545 16.5455C1.66548 16.7565 1.95163 16.875 2.25 16.875H15.75C16.0484 16.875 16.3345 16.7565 16.5455 16.5455C16.7565 16.3345 16.875 16.0484 16.875 15.75V4.5H1.125Z" fill="#333333"/>
											</svg>
										<input type="text" class="form-control from-date pl-5 hasDatepicker" name="depature" value="" readonly="true" autocomplete="off" required="" tabindex="3" id="dapart_date12312">
									</div>
								</div>
							</div>
							
							<div class="row no-gutter ">
								<div class="col-12 col-lg-6 col-md-3 col-sm-4">
									<div class="flight-checkbox d-flex flex-wrap align-items-center mt-2" for="check-direct">
										<input type="checkbox" name="direct" id="check-direct" class="form-check-input mr-2 ml-2" tabindex="5" value="1"><span>Direct flights only</span>
									</div>
								</div>
								<div class="col-6 col-lg-2 col-md-3 col-sm-4">
									<div class="select-wrap">
										<a href="#" class="passenger-change ">
											<p class="form-paxs dropdown-toggle">
												<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
													<path d="M18.4444 16.4055C18.0391 15.4455 17.451 14.5735 16.7128 13.8381C15.9768 13.1005 15.1049 12.5125 14.1454 12.1064C14.1368 12.1021 14.1282 12.1 14.1196 12.0957C15.4581 11.1289 16.3282 9.5541 16.3282 7.77734C16.3282 4.83398 13.9434 2.44922 11.0001 2.44922C8.0567 2.44922 5.67193 4.83398 5.67193 7.77734C5.67193 9.5541 6.54205 11.1289 7.88052 12.0979C7.87193 12.1021 7.86334 12.1043 7.85474 12.1086C6.89224 12.5146 6.02857 13.0969 5.28736 13.8402C4.54982 14.5762 3.96178 15.4481 3.55572 16.4076C3.1568 17.347 2.94166 18.3542 2.92193 19.3746C2.92136 19.3975 2.92538 19.4204 2.93376 19.4417C2.94214 19.4631 2.95471 19.4825 2.97072 19.4989C2.98674 19.5153 3.00588 19.5284 3.02702 19.5373C3.04816 19.5462 3.07087 19.5508 3.0938 19.5508H4.38287C4.4774 19.5508 4.55259 19.4756 4.55474 19.3832C4.59771 17.7246 5.26373 16.1713 6.44107 14.9939C7.65923 13.7758 9.27701 13.1055 11.0001 13.1055C12.7231 13.1055 14.3409 13.7758 15.559 14.9939C16.7364 16.1713 17.4024 17.7246 17.4454 19.3832C17.4475 19.4777 17.5227 19.5508 17.6172 19.5508H18.9063C18.9292 19.5508 18.952 19.5462 18.9731 19.5373C18.9942 19.5284 19.0134 19.5153 19.0294 19.4989C19.0454 19.4825 19.058 19.4631 19.0664 19.4417C19.0747 19.4204 19.0788 19.3975 19.0782 19.3746C19.0567 18.3477 18.844 17.3486 18.4444 16.4055ZM11.0001 11.4727C10.0139 11.4727 9.0858 11.0881 8.38755 10.3898C7.68931 9.6916 7.30474 8.76348 7.30474 7.77734C7.30474 6.79121 7.68931 5.86309 8.38755 5.16484C9.0858 4.4666 10.0139 4.08203 11.0001 4.08203C11.9862 4.08203 12.9143 4.4666 13.6126 5.16484C14.3108 5.86309 14.6954 6.79121 14.6954 7.77734C14.6954 8.76348 14.3108 9.6916 13.6126 10.3898C12.9143 11.0881 11.9862 11.4727 11.0001 11.4727Z" fill="#333333"></path>
												</svg>&nbsp;<span class="passenger-count">1</span> Passenger(s)</p>  
											</a>
											<div class="passenger-dropdown" role="menu">
												<div class="row no-gutter">
													<p class="col-lg-7">Adults (12+) </p>
													<div class="col-lg-5">
														<div class="input-group input-group-sm pull-right">
															<span class="input-group-btn">
																<a class="btn btn-default number-spinner-flight" data-field="adult_count" data-type="minus"> <span class="fa fa-minus"></span></a>
															</span>
															<input type="text" class="form-control text-center spinner-value-flight" name="mbl_adult_count" id="mbl-adult_count" value="1" max="9" min="1" readonly="readonly">
															<span class="input-group-btn">
																<a class="btn btn-default number-spinner-flight" data-field="adult_count" data-type="plus"><span class="fa fa-plus"></span></a>
															</span>
														</div> 
													</div> <!-- col// -->
												</div> <!-- row// -->
												
												<div class="row no-gutter">
													<p class="col-lg-7"> Children (2-12) </p>
													<div class="col-lg-5">
														<div class="input-group input-group-sm pull-right">
															<span class="input-group-btn">
																<a class="btn btn-default number-spinner-flight" data-field="child_count" data-type="minus"> <span class="fa fa-minus"></span></a>
															</span>
															<input type="text" class="form-control text-center spinner-value-flight" name="child_count" id="mbl_child_count" value="0" max="8" min="0" readonly="readonly">
															<span class="input-group-btn">
																<a class="btn btn-default number-spinner-flight" data-field="child_count" data-type="plus"><span class="fa fa-plus"></span></a>
															</span>
														</div> 
													</div> <!-- col// -->
												</div> <!-- row// -->
												
												<div class="row no-gutter">
													<p class="col-lg-7"> Infant (0-2) </p>
													<div class="col-lg-5">
														<div class="input-group input-group-sm pull-right">
															<span class="input-group-btn">
																<a class="btn btn-default number-spinner-flight" data-field="infant_count" data-type="minus"> <span class="fa fa-minus"></span></a>
															</span>
															<input type="text" class="form-control text-center spinner-value-flight" name="infant_count" id="mbl_infant_count" value="0" max="4" min="0" readonly="readonly">
															<span class="input-group-btn">
																<a class="btn btn-default number-spinner-flight" data-field="infant_count" data-type="plus"><span class="fa fa-plus"></span></a>
															</span>
														</div>
													</div>
												</div>                             
												<a href="javascript:;" class="btn button green_btn text-uppercase btn-ok mt-2"> ok </a>
											</div>   <!-- passenger-dropdown //  -->                       
										</div>
									</div>
									<div class="col-6 col-lg-2 col-md-3 col-sm-4">
										<input type="hidden" value="Economy" id="cabin_class" name="class">
										<div class="select-wrap dropdown"><a href="javascript:;" class="passenger-change ">
											<p class="form-paxs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
													<path d="M4.45818 4.69981C3.70818 4.16647 3.52485 3.13314 4.04985 2.37481C4.57485 1.62481 5.61651 1.44147 6.37485 1.96647C7.12485 2.49981 7.30818 3.53314 6.78318 4.29147C6.24985 5.04147 5.21651 5.22481 4.45818 4.69981ZM13.3332 16.6665C13.3332 16.2081 12.9582 15.8331 12.4998 15.8331H7.44151C6.20818 15.8331 5.15818 14.9331 4.97485 13.7165L3.46651 6.48314C3.42878 6.29906 3.32847 6.13372 3.18263 6.01523C3.03679 5.89673 2.85442 5.83239 2.66651 5.83314C2.14985 5.83314 1.76651 6.30814 1.86651 6.81647L3.32485 13.9665C3.47793 14.9506 3.9778 15.8477 4.73424 16.4956C5.49068 17.1435 6.45384 17.4997 7.44985 17.4998H12.4998C12.9582 17.4998 13.3332 17.1248 13.3332 16.6665ZM12.9498 12.4998H9.45818L8.59985 9.08314C9.66651 9.68314 10.7915 10.1498 12.0165 10.1665C12.4998 10.1748 12.8915 9.75814 12.8915 9.27481C12.8915 8.78314 12.4832 8.40814 11.9915 8.39147C10.8998 8.35814 9.79985 7.92481 8.98318 7.28314L7.61651 6.22481C7.42485 6.07481 7.20818 5.97481 6.98318 5.90814C6.71552 5.82918 6.43342 5.81209 6.15818 5.85814H6.14151C5.65079 5.94526 5.21434 6.22269 4.92717 6.63004C4.64 7.03739 4.52535 7.54168 4.60818 8.03314L5.73318 12.9665C5.8431 13.5381 6.14855 14.0537 6.59712 14.4247C7.04568 14.7957 7.60939 14.9991 8.19151 14.9998H13.8998L16.4748 17.0165C16.8248 17.2915 17.3248 17.2581 17.6332 16.9498C18.0082 16.5748 17.9665 15.9665 17.5498 15.6415L13.9748 12.8498C13.6814 12.6228 13.3208 12.4997 12.9498 12.4998Z" fill="#333333"></path>
												</svg>&nbsp;<span id="cabin">Economy</span>
												<span class="caret"></span>
											</p></a>
											<ul class="passenger-dropdown dropdown-menu cabin_class_list" aria-labelledby="dropdownMenu1" role="menu">
												<li class="p-1"><a href="javascript:;" data-value="Economy" data-lang="Economy" class="cabin_link">Economy</a></li>
												<li class="p-1"><a href="javascript:;" data-value="Business" data-lang="Business" class="cabin_link">Business</a></li>
												<li class="p-1"><a href="javascript:;" data-value="First" data-lang="First" class="cabin_link">First</a></li>
											</ul>
										</div>
									</div>
									<div class="col-12 col-md-3 col-sm-12 col-lg-2 mb-0">
										<button class="button green_btn form-btn uppercase m-0 w-100 availability" style="min-height:40px;">                           
											Search                            
										</button>
									</div>
							</div>
						</div>
						<input type="hidden" class="trip-type-hidden" name="trip_type" value="oneway">
					</form>
				</div>
							
			</div>
			
		</div>
	</div>
</div>
