<!-- signup popup -->
	<div class="signup-popup-wrapper">
		<div class="signup-popup-inner p-3">
			<span class="close-signup-popup">
				<i class="fa fa-close"></i>
			</span>
			
			<div class="p-4 login-popup-content">
				<div class="login-popup-heading">
					<h4>Create your account</h4>
				</div>
				<div class="input-group f-14px signup-popup-field mb-2">
					<label class="form-label">First Name</label>
					<input class="form-control w-100 rounded" type="text" id="signup-firstname" placeholder="First Name"/>
                    <span class="error firstname-error" style="display:none;"></span>
                </div>
				<div class="input-group f-14px signup-popup-field mb-2">
					<label class="form-label">Last Name</label>
					<input class="form-control w-100 rounded" type="text" id="signup-lastname" placeholder="Last Name"/>
                    <span class="error lastname-error" style="display:none;"></span>
                </div>
				<div class="input-group f-14px signup-popup-email-field mb-2">
					<label class="form-label">Email</label>
					<input class="form-control w-100 rounded" type="email" id="signup-email" placeholder="Email"/>
                    <span class="error email-error" style="display:none;"></span>
                </div>
				<div class="input-group f-14px signup-popup-email-field mb-2" x-data>
					<label class="form-label">Phone</label>
					<input class="form-control w-100 rounded" id="signup-phone" x-mask="9999 9999999" placeholder="0345 1234567"/>
                    <span class="error phone-error" style="display:none;"></span>
                </div>
				<div id="spinner"></div>
				<div class="input-group mt-4 f-14px">
					<button class="green_btn w-100 edit-profile-btn" id="signupButton">
                        Sign Up
					</button>
				</div>
				<div class="text-center mt-4 login-popup-privacy">
					By continuing you are agreeing to the Terms and Conditions of sadaticket.com
				</div>

			</div>
			
		</div>
	</div>
	<!-- sighup popup end -->