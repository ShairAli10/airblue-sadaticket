
    <i class="fa fa-close filter-close"></i>
    <div class="filter-item pb-5">
        <div class="filter-label f-14px fw-semibold">PRICE RANGE</div>
        <div class="price-range-slider">

            <p class="range-value">
              <span id="amount" ></span>
            </p>
            <div id="slider-range" class="range-bar"></div>
            
        </div>
        {{-- <div id="slider"></div> --}}
    </div>
    <div class="filter-item pb-4">
        <div class="filter-label f-14px fw-semibold">STOPS</div>
        <div class="stops-filter-options">
            <div class="filter-label">
                <input type="checkbox" name="stops" value="direct" />
                <label>Direct</label>
            </div>
            <div class="filter-label">
                <input type="checkbox" name="stops" value="1 stop"/>
                <label>1 Stop</label>
            </div>
        </div>
    </div>
    <div class="filter-item pb-4">
        <div class="filter-label f-14px fw-semibold">FARE TYPE</div>
        <div class="stops-filter-options">
            <div class="filter-label">
                <input type="checkbox" name="faretype" value="refundable" />
                <label>Refundable</label>
            </div>
        </div>
    </div>
    <div class="filter-item d-none pb-5">
        <div class="filter-label f-14px fw-semibold">DEPARTURE TIME</div>
        <div class="price-range-slider">

            <p class="range-value">
              <input type="text" id="amount" readonly>
            </p>
            <div id="slider-range" class="range-bar"></div>
            
        </div>
        {{-- <div id="slider2"></div> --}}
    </div>
    <div class="filter-item airlines-filter pb-4">
        <div class="filter-label f-14px fw-semibold">AIRLINES</div>
        <div class="stops-filter-options">
            <div class="filter-label flex-column d-flex gap-1 w-100">

                <div class="d-flex align-items-center gap-2">
                    <input type="checkbox" class="airlines" value="emirates" id="emirates">
                    <label for="emirates">Emirates Airlines</label>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <input type="checkbox" class="airlines" value="etihad" id="etihad">
                    <label for="etihad">Etihad Airways</label>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <input type="checkbox" class="airlines" value="pakistan" id="pakistan">
                    <label for="pakistan">Pakistan Airlines</label>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <input type="checkbox" class="airlines" value="saudi" id="saudi">
                    <label for="saudi">Saudi Arabian Airline</label>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <input type="checkbox" class="airlines" value="oman" id="oman">
                    <label for="oman">Oman Air</label>
                </div>
                
            </div>
        </div>
    </div>
