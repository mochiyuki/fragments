<div id="logo">
  <img src="1x/logo.png"></img>
  <p id="app-name"> Fragments </p>
</div>

<form method="" action="" id="login-form" name="login-form">
  <label class="label-logging"> Username <br> <input id="username" class="logging" name="username" type="text"> </label>
  <label class="label-logging"> Password <br> <input id="password" class="logging" name="password" type="password"> </label>
  <button id="login-button"> <p> LOG IN </p> </button>
  <span id="login_error1" class="none"> Account is not activated </span>
  <span id="login_error2" class="none"> Wrong password </span>
  <span id="login_error3" class="none"> Account does not exist </span>
  <span id="login_error4" class="none"> Empty field </span>
  <a id="info"> Why should I register? </a>
  <p id="inforeply"> This app is exclusively reserved to members </p>
  <p> Don't have an account? <a id="register-redirection"> <b> Register now </b> </a> </p>
  <a href="forgotpass.php" id="pass-recover"> <em> Forgot your password? </em> </a>
</form>

<form method="" action="" id="register-form" name="register-form">
  <label class="label-registering"> Username <br> <input class="username registering" name="username" type="text"> </label>
  <span id="username_error1" class="none"> Username already taken </span>
  <span id="username_error2" class="none"> Username must be min 2 characters long </span>
  <label class="label-registering"> Password <br> <input class="password registering" name="password" type="password"> </label>
  <label class="label-registering"> Re-type password <br> <input class="passwordver registering" name="passwordver" type="password"> </label>
  <span id="passwordver_error" class="none"> Passwords don't match </span>
  <label class="label-registering"> E-mail <br> <input class="email registering"name="email" type="email"> </label>
  <span id="email_error1" class="none"> E-mail already in use </span>
  <span id="email_error2" class="none"> E-mail not valid </span>
  <button type="submit" id="register-button"> <p> REGISTER </p> </button>
  <span id="fields_error" class="none"> Please fill every field </span>
</form>