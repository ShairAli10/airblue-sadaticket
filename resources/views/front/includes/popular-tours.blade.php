<div class="container-fluid pb-5 popular-tour-section">
    <div class="container">
        
        <div class="section1 text-center pt-5 pb-4">
            <h4 class="section-heading text-uppercase">Popular <span>Tours</span></h4>
        </div>
        
        <div class="row gy-3">
            
            @foreach($tours as $tour)
            <div class="col-lg-4 col-md-6">
                <div class=" tour-first-img">
                    <img src="{{  asset('Tours/'.$tour->Banner_Image) }}" alt="{{ $tour->Title }}" class="rounded-lg tour-img-size">
                    <h2>{{ $tour->Title }}</h2>
                </div>
                <div class="slider-content">
                    <div class="row">
                        <div class="col-lg-6 d-none">
                            <div class="from-content">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="18" viewBox="0 0 25 18" fill="none">
                                        <path d="M20.8 3.61674H9.984V9.67575H8.83199V7.61621C8.83066 6.44932 8.35022 5.33059 7.49608 4.50546C6.64194 3.68034 5.48386 3.2162 4.27591 3.21488H1.664V0H0V17.28H1.664V14.8817L23.296 15.0489V17.28H24.96V7.63535C24.9587 6.56992 24.5201 5.54847 23.7402 4.7951C22.9603 4.04173 21.9029 3.61795 20.8 3.61674ZM1.664 4.82233H4.27591C5.04267 4.82316 5.77778 5.11778 6.31996 5.64153C6.86214 6.16529 7.16712 6.87541 7.16799 7.61611V9.67564H1.664V4.82233ZM23.296 13.4414L1.664 13.2743V11.2832H23.296V13.4414ZM23.296 9.67575H11.648V5.22419H20.8C21.4617 5.22492 22.0962 5.47918 22.5641 5.93121C23.032 6.38323 23.2952 6.99609 23.296 7.63535V9.67575Z" fill="#333333"></path>
                                    </svg>
                                </span>
                                <h6>From</h6>
                                <h3>PKR {{$tour->Price}}</h3>
                            </div>
                            <div class="Slide-btn">
                                <a href="" target="_blank" tabindex="0">Find hotels</a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="from-content">
                                <span>
                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20.012 18v2h-20v-2h20zm3.973-13.118c.154 1.349-.884 2.615-1.927 3.491-.877.735-9.051 6.099-9.44 6.307-1.756.936-3.332 1.306-4.646 1.32-1.36.014-2.439-.354-3.144-.872l-4.784-3.977 3.742-2.373 4.203 1.445.984-.578-4.973-3.645 3.678-2.124 7.992 1.545c.744-.445 1.482-.9 2.225-1.348 1.049-.623 2.056-1.055 3.387-1.055 1.321 0 2.552.52 2.703 1.864zm-4.341.512c-.419.192-3.179 1.882-3.615 2.144l-8.01-1.55-.418.241 5.288 3.307-4.683 2.876-4.214-1.448-.69.395c.917.729 1.787 1.522 2.751 2.186 1.472.962 4.344.22 5.685-.663.9-.592 7.551-4.961 8.436-5.582.605-.431 1.797-1.414 1.824-2.152l.001-.004c-.644-.287-1.716-.041-2.355.25z"/></svg>
                                </span>
                                <h6>From</h6>
                                <h3>PKR {{$tour->Price}}</h3>
                            </div>
                            <div class="Slide-btn d-none green_btn">
                                <a href="" target="_blank" tabindex="0">Find flights</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
            
            
        </div>
    </div>
</div>