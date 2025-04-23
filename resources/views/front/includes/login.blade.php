<style>
    .otp-boxes input:not(:last-child) {
        margin-right: 10px; /* You can adjust the margin as needed */
    }
</style>
<div class="login-popup-wrapper">
    <div class="login-popup-inner p-3">
        <span class="close-login-popup">
            <i class="fa fa-close"></i>
        </span>
        <div class="p-4 login-popup-content">
            <form id="loginForm">
                @csrf
                <div class="login-popup-heading">
                    <h4>Continue to your account</h4>
                </div>
                <div class="input-group f-14px login-popup-email-field mb-2">
                    <label class="form-label">Email</label>
                    <input class="form-control w-100 rounded" type="email" id="login-email" placeholder="Email"/>
                    <span class="error email-error" style="display:none;"></span>
                </div>
                <div id="otp_div">
                    
                </div>
                <div class="input-group mt-4 f-14px">
                    <button class="green_btn w-100 edit-profile-btn" id="loginButton">Login </button>
                </div>
                <div class="text-center mt-4 login-popup-privacy">
                    By continuing you are agreeing to the Terms and Conditions of sadaticket.com
                </div>
            </form>
        </div>
    </div>
</div>

    
