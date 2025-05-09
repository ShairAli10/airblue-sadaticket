@foreach ($customer_data['passengers'] as $passKey => $passenger)
    @php
        if($passenger['passenger_type'] == 'ADT')
            $PaxType = 'Adult';
        elseif($passenger['passenger_type'] == 'CNN')
            $PaxType = 'Child';
        else
            $PaxType = 'Infant';
    @endphp
    <tr class="border-bottom pb-3 Passengerbody">
        <td><span class="fs-5">{{ $passKey+1 }}</span></td>
        <td style="margin-left: -109px;">
            <span style="font-size: 14px; font-weight: 700;">{{ $passenger['passenger_title'].' '.strtoupper($passenger['name']).' '.strtoupper($passenger['sur_name']) }}<br>
                <span class="fw-normal">{{ $PaxType }} ({{ date('M d, Y',strtotime($passenger['dob'])) }})</span>
            </span>
        </td>
        <td  style="margin-left: -39px;">{{ capitalizeAlphabetic($passenger['document_number']) }},{{ date('M d, Y',strtotime($passenger['document_expiry_date'])) }},{{ $passenger['nationality'] }}</td>
        {{-- <td class="fs-4"style="margin-right: -13px;"><b>{{ @$order->pnrCode}}</b></td> --}}
        <td style="margin-left: 7px;">-</td>
        <td style="margin-left: -39px;">
            @if(@$tickets_data)
                @foreach ($tickets_data as $ticket)
                    @php
                        $passengerFirstName = strtoupper($passenger['name']).' '.strtoupper($passenger['passenger_title']);
                        $ticketedName = $ticket['name'];
                        $passengerLastName = strtoupper($passenger['sur_name']);
                        $ticketedLastName = $ticket['sur_name'];
                    @endphp
                    @if(strtoupper($passenger['name']) == $ticketedName || $passengerFirstName == $ticketedName)
                        @if($passengerLastName == $ticketedLastName)
                            <a class="coupon-status" data-bs-toggle="offcanvas" href="#ticketStatus" aria-controls="ticketStatus" data-ticket="{{ $ticket['TicketNumber'] }}" data-name="{{ $passenger['name'] }}" data-name2="{{ $passenger['sur_name'] }}">
                                {{ $ticket['TicketNumber'] }}
                                @if(@$ticket['TicketStatus'])
                                    @if($ticket['TicketStatus'] != 'Issued')
                                        <span style="color:#facb6f;">
                                            - {{ $ticket['TicketStatus'] }}
                                        </span>
                                    @endif
                                @endif
                            </a><br>
                        @endif
                    @endif
                @endforeach
            @endif
        </td>
        <td class=""style="margin-left: -39px;">{{ $order->status }}</td>
    </tr>
@endforeach