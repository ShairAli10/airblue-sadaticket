@extends('front.layouts.app')
@section('styles')

<link rel="stylesheet" href="{{ asset('front-assets/css/account-pages.css') }}">

@endsection

@section('content')

<div class="container-fluid edit-profile-wrapper">
    <div class="row">
        <div class="col-md-4 bg-white">
            @include('front.customer-panel.includes.sidebar')
        </div>
        <div class="col-md-8">
            <div class="customer-wallet-balance-wrapper bg-white m-lg-4 m-2 px-lg-4 px-3 py-4">
                <div class="balance-title d-flex align-items-center gap-1">
                    <span>
                        <svg viewBox="64 64 896 896" focusable="false" data-icon="signal" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                            <path d="M584 352H440c-17.7 0-32 14.3-32 32v544c0 17.7 14.3 32 32 32h144c17.7 0 32-14.3 32-32V384c0-17.7-14.3-32-32-32zM892 64H748c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h144c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32zM276 640H132c-17.7 0-32 14.3-32 32v256c0 17.7 14.3 32 32 32h144c17.7 0 32-14.3 32-32V672c0-17.7-14.3-32-32-32z"></path>
                        </svg>
                    </span>
                    <span class="mt-1">Balance</span>
                </div>
                <div class="wallet-balance-amount mt-2">
                    <span>PKR</span>&nbsp;<span>0</span>
                </div>
            </div>

            <div class="transaction-title m-lg-4 m-2 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Transaction History</h5>
                <button class="view-all-transations button green_btn">View All</button>
            </div>

            <div class="customer-edit-profile-fields-main bg-white m-lg-4 m-2">


                <table class="customer-transactions-history-table w-100">
                    <colgroup></colgroup>
                    <thead style="background-color: #fafafa;">
                        <tr>
                            <th class="p-3">Date</th>
                            <th class="p-3">Type</th>
                            <th class="p-3">Amount</th>
                            <th class="p-3">Order ID</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr class="empty-table-placeholder text-center">
                            <td colspan="4" class="p-3">
                                <div>
                                    <div class="empty-image">
                                        <svg width="64" height="41" viewBox="0 0 64 41" xmlns="http://www.w3.org/2000/svg">
                                            <g transform="translate(0 1)" fill="none" fill-rule="evenodd">
                                                <ellipse cx="32" cy="33" rx="32" ry="7"></ellipse>
                                                <g style="stroke: #d9d9d9;" fill-rule="nonzero">
                                                    <path d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z"></path>
                                                    <path d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z" class="ant-empty-img-simple-path"></path>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="empty-transactions text-center">No data</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>


                
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')


@endsection