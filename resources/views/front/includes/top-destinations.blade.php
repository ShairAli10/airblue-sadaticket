<div class="container-fluid top-flights-wrapper pt-5 pb-5">
		<div class="container">
			<div class="row cardrow">
				
				<div class="section1 pb-4 d-flex flex-wrap w-100 justify-content-center">
					<div class="wave d-flex justify-content-center align-items-center flex-wrap">
						<h4 class="section-heading font-400"> TOP FLIGHT <strong>DESTINATION</strong></h4>
					</div>
				</div>
				@foreach($top as $top)
				<div class="col-lg-3 col-md-6 col-sm-6 col-12 cardcol py-2">
					<div class="images">
						<img src="{{ asset('Top/'.$top->banner_image) }}" alt="{{ $top->title }}">
						<h3 class="imageheading">{{$top->title}}</h3>
					</div>
					<div class="textdata-all pt-3 pb-3">
						<div class="planeSection d-flex flex-wrap align-items-center">
							<div class="planeText">
								<h6>{{ CityNameByAirportCode($top->from) }}</h6>
							</div>
							<div class="planeimg">
								<span>
									<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
										<path d="M20.012 18v2h-20v-2h20zm3.973-13.118c.154 1.349-.884 2.615-1.927 3.491-.877.735-9.051 6.099-9.44 6.307-1.756.936-3.332 1.306-4.646 1.32-1.36.014-2.439-.354-3.144-.872l-4.784-3.977 3.742-2.373 4.203 1.445.984-.578-4.973-3.645 3.678-2.124 7.992 1.545c.744-.445 1.482-.9 2.225-1.348 1.049-.623 2.056-1.055 3.387-1.055 1.321 0 2.552.52 2.703 1.864zm-4.341.512c-.419.192-3.179 1.882-3.615 2.144l-8.01-1.55-.418.241 5.288 3.307-4.683 2.876-4.214-1.448-.69.395c.917.729 1.787 1.522 2.751 2.186 1.472.962 4.344.22 5.685-.663.9-.592 7.551-4.961 8.436-5.582.605-.431 1.797-1.414 1.824-2.152l.001-.004c-.644-.287-1.716-.041-2.355.25z"></path>
									</svg>
								</span>
							</div>
							<div class="planeText text-end">
								<h6>{{ CityNameByAirportCode($top->to)}}</h6>
							</div>
						</div>
						
						<div class="imgSection destination-col pt-3">
							<div class="planeText text-start">
								<img src="{{ asset('front-assets/images/EY.png') }}" alt="Airline code: EY">
							</div>
							
							<div class="planeimg">
								<span>
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
										<path d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z" fill="#333333"></path>
									</svg>
									<p class="m-0 Bangkok-date">16-Aug</p>
								</span>
							</div>
							
							<div class="planeText planeText1 text-end">
								<a class="flight-book-price-btn" href="">AED 614</a>
							</div>
						</div>
						
						<div class="imgSection destination-col ">
							<div class="planeText text-start">
								<img src="{{ asset('front-assets/images/XY.png') }}" alt="Airline code: XY">
							</div>
							<div class="planeimg">
								<span>
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
										<path d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z" fill="#333333"></path>
									</svg>
									<p class="m-0 Bangkok-date">16-Aug</p>
								</span>
							</div>
							<div class="planeText planeText1 text-end py-2">
								<a class="flight-book-price-btn" href="">AED 980</a>
							</div>
						</div>
						
						<div class="imgSection destination-col ">
							<div class="planeText text-start">
								<img src="{{ asset('front-assets/images/EK.png') }}" alt="Airline code: EK">
							</div>
							<div class="planeimg">
								<span>
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
										<path d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z" fill="#333333"></path>
									</svg>
									<p class="m-0 Bangkok-date">16-Aug</p>
								</span>
							</div>
							<div class="planeText planeText1 text-end">
								<a class="flight-book-price-btn" href="">AED 1,250</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				
		
				
			</div>
		</div>
	</div>