<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap" rel="stylesheet" />

    <title>Forgot Password</title>
    <style>
        body {
            font-family: Poppins;
        }

        .first {
            height: 290px;
        }

        .second {
            height: 290px;
        }

        /* media queries */
        @media only screen and (max-width: 500px) {
            .first {
                height: 350px;
                width: 100% !important;
                float: none !important;
            }

            .second {
                width: 100% !important;
                float: none !important;
                border-top-right-radius: 0px !important;
                border-bottom-left-radius: 20px !important;
                height: auto !important;
                /* margin-top: -10px; */
            }

            .offer1_img {
                border-top-right-radius: 20px !important;
                border-bottom-left-radius: 0px !important;
            }

            .offer2_img {
                border-top-right-radius: 20px !important;
                border-bottom-left-radius: 0px !important;
            }

            .footer_td {
                padding: 1px !important;
            }

            .footer_a {
                font-size: 12px !important;
            }

            .footer_li {
                padding: 5px !important;
            }

            .br_in_mob {
                display: none;
            }

            .service-desc {
                /* font-size: 12px !important; */
                padding: 0 !important;
            }

            .img_mobile {
                width: 100px !important;
            }

            .sep {
                display: none !important;
                height: 0;
                width: 0;
                float: left;
            }

            .service_box {
                width: 45% !important;
                float: none !important;
                margin: 5px !important;
            }

            .p_overflow {
                height: auto !important;
            }

            .service-title {
                font-size: 18px !important;
            }
        }
    </style>
</head>

<body>
    <!-- main div starts -->
    <div
        style=" width: 100%; min-height: 100%; margin: 0px; padding: 0px; background-color: white; ">
        <!-- main table starts -->

        <table style="width: 100%" border="0">
            <!-- main table body starts -->

            <tbody>
                <!-- main table row starts  -->
                <tr>
                    <td
                        style=" display: block !important; margin: 0 auto !important; clear: both !important; ">
                        <div
                            style=" padding: 0px; margin: 0 auto !important; display: block; max-width: 800px; display: block; background-color: #f5f5f5; ">
                            <!-- second main table starts -->
                            <table cellpadding="0" ; cellspacing="0" style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td style="text-align: center">
                                            <img src="https://booking.jetpakistan.com/assets/images/{{ config('constants.sadaticket-webp') }}"
                                                width="200px" alt="sadaticket.com By Binham Group" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <!-- second div starts -->
                                            <div
                                                style=" padding: 15px; margin: 0 auto; display: block; max-width: 730px; display: block; ">
                                                <table style="width: 100%" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="height: 10px"></td>
                                                        </tr>
                                                        <tr align="center">
                                                            <td>
                                                                <p
                                                                    style=" color: #326ec6; font-weight: 800; font-size: 20px; margin-bottom: 0px; ">
                                                                    Welcome to {{ config('constants.SITE_TITLE') }}
                                                                </p>
                                                                <!-- </td> -->
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <p
                                                                    style=" color: #3d3d3d; font-size: 15px; margin-top: 0px; ">
                                                                    Your OTP code:{{ $otpCode }}
                                                                </p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="height: 25px"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                                <!-- second main table ends -->
                            </table>
                        </div>
                    </td>

                    <!-- main table row ends -->
                </tr>

                <!-- main table body ends -->
            </tbody>

            <!-- main table ends -->
        </table>

        <!-- main div ends -->
    </div>
</body>

</html>
