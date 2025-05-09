<style>
.customer-tab{
    text-decoration: none;
    color: #000;
    display: block;
}
</style>
<div class="account-sidebar">
    <div class="user-img-name d-flex align-items-center gap-4">
        <div class="user-img-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" viewBox="0 0 46 46" fill="none">
                <g clip-path="url(#clip0_16466_181059)">
                    <rect width="64" height="64" fill="#BFBFBF"/>
                    <path d="M30.7828 28.6512C30.3591 27.6476 29.7442 26.7359 28.9724 25.9671C28.203 25.196 27.2915 24.5813 26.2883 24.1567C26.2794 24.1522 26.2704 24.15 26.2614 24.1455C27.6607 23.1348 28.5704 21.4884 28.5704 19.6309C28.5704 16.5537 26.0772 14.0605 23.0001 14.0605C19.9229 14.0605 17.4297 16.5537 17.4297 19.6309C17.4297 21.4884 18.3394 23.1348 19.7387 24.1478C19.7297 24.1522 19.7208 24.1545 19.7118 24.159C18.7055 24.5835 17.8026 25.1922 17.0277 25.9693C16.2566 26.7388 15.6419 27.6502 15.2173 28.6534C14.8003 29.6355 14.5754 30.6885 14.5547 31.7553C14.5541 31.7792 14.5583 31.8031 14.5671 31.8254C14.5759 31.8477 14.589 31.8681 14.6058 31.8852C14.6225 31.9024 14.6425 31.916 14.6646 31.9254C14.6867 31.9347 14.7105 31.9395 14.7344 31.9395H16.0821C16.1809 31.9395 16.2595 31.8608 16.2618 31.7643C16.3067 30.0303 17.003 28.4063 18.2338 27.1755C19.5074 25.902 21.1987 25.2012 23.0001 25.2012C24.8014 25.2012 26.4927 25.902 27.7663 27.1755C28.9971 28.4063 29.6934 30.0303 29.7383 31.7643C29.7406 31.8631 29.8192 31.9395 29.918 31.9395H31.2657C31.2897 31.9395 31.3134 31.9347 31.3355 31.9254C31.3576 31.916 31.3776 31.9024 31.3944 31.8852C31.4111 31.8681 31.4242 31.8477 31.433 31.8254C31.4418 31.8031 31.446 31.7792 31.4454 31.7553C31.4229 30.6816 31.2005 29.6372 30.7828 28.6512ZM23.0001 23.4941C21.9691 23.4941 20.9988 23.0921 20.2688 22.3621C19.5388 21.6321 19.1368 20.6618 19.1368 19.6309C19.1368 18.5999 19.5388 17.6296 20.2688 16.8996C20.9988 16.1696 21.9691 15.7676 23.0001 15.7676C24.031 15.7676 25.0013 16.1696 25.7313 16.8996C26.4613 17.6296 26.8633 18.5999 26.8633 19.6309C26.8633 20.6618 26.4613 21.6321 25.7313 22.3621C25.0013 23.0921 24.031 23.4941 23.0001 23.4941Z" fill="white"/>
                </g>
                <defs>
                    <clipPath id="clip0_16466_181059">
                        <rect width="46" height="46" rx="23" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
        </div>
        <div class="user-name">
            User 361066
        </div>
    </div>
    <div class="customer-tabs mt-lg-5 mt-3">
        <a href="{{ route('mybookings' )}}" class="customer-tab p-3 tab-booking active" style="width: 100%;">
            Bookings
        </a>
        <a href="{{ route('mybookings' )}}" class="customer-tab p-3 tab-purchase-history" style="width: 100%;">
            Purchase History
        </a>
        <a href="{{ route('mywallet' )}}" class="customer-tab p-3 tab-wallet" style="width: 100%;">
            Wallet
        </a>
    </div>
    <div class="sign-out-link mt-4">
        <form action="{{ route('logout.customer') }}" method="POST">
            @csrf
            <button type="submit" class="button green_btn">
                Sign Out
            </button>
        </form>
    </div>
</div>