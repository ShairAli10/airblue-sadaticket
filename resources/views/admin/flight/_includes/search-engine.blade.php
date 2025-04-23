<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <form action="#" id="searchAvailabilityForm">
                <div style="border-bottom: 2px solid #eff0f2; display: flex; justify-content: space-between;">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist" style="border-bottom:none; width: 70%;">
                        <li class="nav-item">
                            <a class="nav-link active" onclick="changeTab('oneway')" data-bs-toggle="tab" href="#oneway" role="tab">
                                <span class="d-none d-sm-block">oneway</span> 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="changeTab('return')" data-bs-toggle="tab" href="#return-trip" role="tab">
                                <span class="d-none d-sm-block">return trip</span> 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="changeTab('multy')" data-bs-toggle="tab" href="#multy-city" role="tab">
                                <span class="d-none d-sm-block">multy city</span>   
                            </a>
                        </li>
                        <li class="nav-item">
                            <select class="form-select " id="api_selected" name="api_selected">
                                <option value="all" selected>Choose API</option>
                                <option value="Sabre">Sabre</option>
                                <option value="Airblue">Airblue</option>
                                <option value="Serene Air">Serene Air</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <div class="select-wrap">
                                <a href="#" class="btn btn-primary w-md text-white passenger-change">Travelers <span class="passenger-count">1</span></a>
                                
                                <div class="passenger-dropdown text-start" role="menu">
                                    <div class="row no-gutter">
                                        <p class="col-lg-7">Adults (12+) </p>
                                        <div class="col-lg-5">
                                            <div class="input-group input-group-sm pull-right">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default number-spinner-flight" data-field="adult_count" data-type="minus">
                                                        <span class="fa fa-minus"></span>
                                                    </a>
                                                </span>
                                                <input type="text"
                                                    class="form-control text-center spinner-value-flight"
                                                    name="adult_count" id="adult_count" value="1" max="9"
                                                    min="1" readonly="readonly">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default number-spinner-flight" data-field="adult_count" data-type="plus">
                                                        <span class="fa fa-plus"></span>
                                                    </a>
                                                </span>
                                            </div>
                                            
                                        </div> <!-- col// -->
                                    </div> <!-- row// -->

                                    <div class="row no-gutter">
                                        <p class="col-lg-7"> Children (2-12) </p>
                                        <div class="col-lg-5">
                                            <div class="input-group input-group-sm pull-right">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default number-spinner-flight" data-field="child_count" data-type="minus">
                                                        <span class="fa fa-minus"></span>
                                                    </a>
                                                </span>
                                                <input type="text" class="form-control text-center spinner-value-flight"
                                                    name="child_count" id="child_count" value="0" max="8"
                                                    min="0" readonly="readonly">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default number-spinner-flight" data-field="child_count" data-type="plus">
                                                        <span class="fa fa-plus"></span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div> <!-- col// -->
                                    </div> <!-- row// -->

                                    <div class="row no-gutter">
                                        <p class="col-lg-7"> Infant (0-2) </p>
                                        <div class="col-lg-5">
                                            <div class="input-group input-group-sm pull-right">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default number-spinner-flight" data-field="infant_count" data-type="minus">
                                                        <span class="fa fa-minus"></span>
                                                    </a>
                                                </span>
                                                <input type="text"
                                                    class="form-control text-center spinner-value-flight"
                                                    name="infant_count" id="infant_count" value="0" max="4"
                                                    min="0" readonly="readonly">
                                                <span class="input-group-btn">
                                                    <a class="btn btn-default number-spinner-flight" data-field="infant_count" data-type="plus">
                                                        <span class="fa fa-plus"></span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:;" class="btn btn-primary text-uppercase btn-ok mt-2 w-100"> Done </a>
                                </div> 
                                <!-- passenger-dropdown //  -->
                            </div>
                        </li>
                        
                    </ul>
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist" style="border-bottom:none; width: 25%;">
                        
                    </ul>
                </div>
                <!-- Tab content -->
                <div class="tab-content p-4">
                    <div class="input-field-wrapper origin-main" style="overflow: inherit">
                        <input type="hidden" name="trip_type" id="trip_type" value="oneway">
                        <i class="fas fa-globe-americas origin-icon text-primary"></i>
                        <label class="origin-label">Flying From</label>
                        <input type="text" class="typeahead typeahead_origion" id="origin" name="origin" style="width:87%"/>
                        <input type="hidden" id="origin_code" value="">
                    </div>
                    <div class="input-field-wrapper destination-main" style="overflow: inherit">
                        <i class="fas fa-globe-americas destination-icon text-primary"></i>
                        <label class="destination-label">Flying To</label> 
                        <input type="text" class="typeahead typeahead_distination" id="destination" name="destination" style="width:87%"/>
                        <input type="hidden" id="destination_code" value="">
                    </div>
                    <div class="label-date input-field-wrapper depart-main">
                        <label class="depart-label">Depart</label>
                        <input type="text" class="" id="dapart_date" name="dapart_date" autocomplete="off" style="top: 17px; height: 26px;"/>
                        {{-- <input type="text" class="form-control flatpickr-input" id="datepicker-humanfd"> --}}
                    </div>
                    <div class="label-date input-field-wrapper return-date-main" style="display:none;">
                        <label>Returh</label>
                        <input type="text" id="return_date" name="return_date" autocomplete="off" style="top: 17px; height: 26px;">
                    </div>
                    <button type="button" class="flight-submit-btn btn btn-primary w-md" id="btnAvailability">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>