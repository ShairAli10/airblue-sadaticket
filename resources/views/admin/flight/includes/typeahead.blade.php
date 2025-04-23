<script type="text/javascript" src="{{ asset('assets/js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {
        setTimeout(() => {
                // ----------Type head for origion location----------//
        var list_airport_class = $('.typeahead.typeahead_origion');
        var listAirport = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('airport_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
    
            // prefetch: {
            //     url: "{{ url('getAllAirPortCodes') }}",
            //     // cache: true, //depends on localstorage size
            // },
            remote: {
                url: "{{ url('getAllAirPortCodes') }}"+"/"+'%QUERY',
                wildcard: '%QUERY',
            }
        });
        list_airport_class.typeahead({
            hint: true,
            highlight: true
        },
        {
            name: 'list_airport',
            display: function (listAirport) {
                return listAirport.code + ' - '+listAirport.airport_name;
            },
            source: listAirport,
            limit: 12,
            templates: {
                empty: [
                    '<div class="empty-message">',
                    'No record found',
                    '</div>'
                ].join('\n'),
                suggestion: function(data) {
                    return '<p>' + data.code + ' - '+data.airport_name+'</p>';
                }
            }
        });
        list_airport_class.bind('typeahead:select', function(ev, suggestion) {
            $('#origin_code').val(suggestion.code);
            $('.display_name_origin').text(suggestion.code + ' - '+suggestion.airport_name);
        });
    
    
        // ----------Type head for distination location----------//
        var list_airport_class = $('.typeahead.typeahead_distination');
        var listAirport = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('airport_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
    
            // prefetch: {
            //     url: "{{ url('getAllAirPortCodes') }}",
            //     // cache: true, //depends on localstorage size
            // },
            remote: {
                url: "{{ url('getAllAirPortCodes') }}"+"/"+'%QUERY',
                wildcard: '%QUERY',
            }
        });
        list_airport_class.typeahead({
            hint: true,
            highlight: true
        },
        {
            name: 'list_airport',
            display: function (listAirport) {
                return listAirport.code + ' - '+listAirport.airport_name;
            },
            source: listAirport,
            limit: 12,
            templates: {
                empty: [
                    '<div class="empty-message">',
                    'No record found',
                    '</div>'
                ].join('\n'),
                suggestion: function(data) {
                    return '<p>' + data.code + ' - '+data.airport_name+'</p>';
                }
            }
        });
        list_airport_class.bind('typeahead:select', function(ev, suggestion) {
            $('#destination_code').val(suggestion.code);
            $('.display_name_destination').text(suggestion.code + ' - '+suggestion.airport_name);
        });
        }, 2000);
    });
</script>