function janrainInjectCaptureWidget(targetId, widgetHtml) {
    var s = document.getElementById(targetId);
    var e = document.createElement('div');
    e.id = 'janrainCaptureWidget';
    e.innerHTML = '<div id="janrainWidgetWrapper">' + widgetHtml + '</div>';
    s.parentNode.insertBefore(e, s);
}

(function () {
    janrainDefaultSettings();
    janrain.settings.capture.registerFlow = 'socialRegistration';
    janrain.settings.capture['returnExperienceUserData'] = ['displayName'];

    janrainInitLoad();

    janrainInjectCaptureWidget('janrainCaptureScript', '<div style="display:none;" id="signIn">\n' +
'    <div class="capture_header">\n' +
'        <h1>Sign In or Create a New Account</h1>\n' +
'        <h3>Welcome to oreilly.com. To access your account, complete the form below.</h3>\n' +
'    </div>\n' +
'    <div class="capture_signin">\n' +
'        <h2>Sign in or create an O\'Reilly account.</h2>\n' +
'           {* #userInformationForm *}\n' +
'                {* traditionalSignIn_emailAddress *}\n' +
'                {* traditionalSignIn_password *}\n' +
'                <div class="capture_form_item forgot_password_line">\n' +
'                    <a href="#" data-capturescreen="forgotPassword">Forgot your password?</a>\n' +
'                </div>\n' +
'                <div class="capture_leftText">\n' +
'                    {* traditionalSignIn_signInButton *}{* traditionalSignIn_createButton *}\n' +
'                </div>\n' +
'           {* /userInformationForm *}\n' +
'    </div>\n' +
'    <div class="capture_signin em-li">\n' +
'        <h2 class="social_login_message">Connect with LinkedIn</h2>\n' +
'        {* loginWidget *} <br />\n' +
'    </div>\n' +
'</div>\n' +
'<div style="display:none;" id="returnSocial">\n' +
'    <div class="capture_header">\n' +
'        <h1>Sign In</h1>\n' +
'    </div>\n' +
'    <div class="capture_signin">\n' +
'        <h2>Hi {* welcomeName *}. Please sign in.</h2>\n' +
'        {* loginWidget *}\n' +
'        <div class="capture_centerText switchLink"><a href="#" data-cancelcapturereturnexperience="true">Switch accounts</a></div>\n' +
'    </div>\n' +
'</div>\n' +
'<div style="display:none;" id="returnTraditional">\n' +
'    <div class="capture_header">\n' +
'        <h1>Sign In</h1>\n' +
'    </div>\n' +
'    <h2 class="capture_centerText"><span id="traditionalWelcomeName">Hi</span>. Please sign in.</h2>\n' +
'            <div class="capture_signin_returning">\n' +
'                {* #userInformationForm *}\n' +
'                    {* traditionalSignIn_emailAddress *}\n' +
'                    {* traditionalSignIn_password *}\n' +
'                    <div class="capture_form_item forgot_password_line">\n' +
'                    <a href="#" data-capturescreen="forgotPassword">Forgot your password?</a>\n' +
'                    </div>\n' +
'                    <div class="capture_form_item capture_leftText">\n' +
'                        {* traditionalSignIn_signInButton *}\n' +
'                    <div class="switchLink"><a href="#" data-cancelcapturereturnexperience="true">Switch accounts</a></div>\n' +
'                    </div>\n' +
'                {* /userInformationForm *}\n' +
'    </div>\n' +
'</div>\n' +
'<div style="display:none;" id="socialRegistration">\n' +
'    <div class="capture_header">\n' +
'        {* backButton *}\n' +
'        <h1>Almost Done</h1>\n' +
'    </div>\n' +
'      <h2>Please confirm the information below before signing in.</h2>\n' +
'        {* #socialRegistrationForm *}\n' +
'            {* socialRegistration_firstName *}\n' +
'            {* socialRegistration_lastName *}\n' +
'            {* socialRegistration_displayName *}\n' +
'            {* socialRegistration_emailAddress *}\n' +
'            {* providerName *}\n' +
'            {* profileURL *}\n' +
'            {* profilePreferredUsername *}\n' +
'            {* profileIdentifier *}\n' +
'            <div class="capture_footer">\n' +
'                <div class="capture_left">\n' +
'                  By clicking "Sign in", you confirm that you accept our\n' +
'                  <a href="http://oreilly.com/terms/" target="_blank">terms of service</a>.<br/>\n' +
'                  We protect your <a href="http://oreilly.com/oreilly/privacy.csp" target="_blank">privacy</a>.\n' +
'                </div>\n' +
'                <div class="capture_right">\n' +
'                {* socialRegistration_signInButton *}\n' +
'                </div>\n' +
'            </div>\n' +
'        {* /socialRegistrationForm *}\n' +
'</div>\n' +
'<div style="display:none;" id="registrationNewVerification">\n' +
'    <div class="capture_header">\n' +
'        <h1>Thank you for registering!</h1>\n' +
'    </div>\n' +
'    <h2>Signing in...</h2>\n' +
'</div>\n' +
'<div style="display:none;" id="traditionalRegistration">\n' +
'    <div class="capture_header">\n' +
'        {* backButton *}\n' +
'        <h1>Almost Done</h1>\n' +
'    </div>\n' +
'    <h2>Please confirm the information below to create a new account. <br />\n' +
'      If you already have an account, <a href="#" data-capturescreen="signIn">sign in.</a>\n' +
'    </h2>\n' +
'        {* #registrationForm *}\n' +
'            {* traditionalRegistration_firstName *}\n' +
'            {* traditionalRegistration_lastName *}\n' +
'            {* traditionalRegistration_displayName *}\n' +
'            {* traditionalRegistration_emailAddress *}\n' +
'            {* traditionalRegistration_password *}\n' +
'            {* traditionalRegistration_passwordConfirm *}\n' +
'            <div class="capture_footer">\n' +
'                <div class="capture_left">\n' +
'                  By clicking "Create Account", you confirm that you accept our\n' +
'                  <a href="http://oreilly.com/terms/" target="_blank">terms of service</a>.<br/>\n' +
'                  We protect your <a href="http://oreilly.com/oreilly/privacy.csp" target="_blank">privacy</a>.\n' +
'                </div>\n' +
'                <div class="capture_right">\n' +
'                {* createAccountButton *}\n' +
'                </div>\n' +
'            </div>\n' +
'        {* /registrationForm *}\n' +
'</div>\n' +
'<div style="display:none;" id="forgotPassword">\n' +
'    <div class="capture_header">\n' +
'        {* backButton *}\n' +
'        <h1>Forgot your password?</h1>\n' +
'    </div>\n' +
'    <h2>We\'ll send you a link to create a new password.</h2>\n' +
'    {* #forgotPasswordForm *}\n' +
'        {* traditionalSignIn_emailAddress *}\n' +
'        <div class="capture_footer">\n' +
'            <div class="capture_right">\n' +
'                {* forgotPassword_sendButton *}\n' +
'            </div>\n' +
'        </div>\n' +
'    {* /forgotPasswordForm *}\n' +
'</div>\n' +
'<div style="display:none;" id="forgotPasswordSuccess">\n' +
'    <div class="capture_header">\n' +
'        <h1>Password reset email sent</h1>\n' +
'    </div>\n' +
'      <h2>We\'ve sent an email with instructions to create a new password. Your existing password has not been changed.</h2>\n' +
'</div>\n' +
'<div style="display:none;" id="mergeAccounts">\n' +
'    {* mergeAccounts *}\n' +
'</div>\n' +
'<div style="display:none;" id="traditionalAuthenticateMerge">\n' +
'    <div class="capture_header">\n' +
'        {* backButton *}\n' +
'        <h1>Sign In and Merge</h1>\n' +
'    </div>\n' +
'    <h2 class="capture_centerText">Please sign in to complete account merge.</h2>\n' +
'    <div class="capture_signin capture_signin_returning">\n' +
'    {* #tradAuthenticateMergeForm *}\n' +
'        {* traditionalSignIn_emailAddress *}\n' +
'        {* mergePassword *}\n' +
'        {* traditionalSignIn_signInButton *}\n' +
'     {* /tradAuthenticateMergeForm *}\n' +
'    </div>\n' +
'</div>');
})();
