<?php
$controller->genCaptchaCode();
?>
<h2>Login</h2>
<form method="POST" action="/main/login">
  <div class="default" style="width:10%; margin-left: 40%">Login : </div>
  <div class="default" style="width:49%"><input type="text" name="log[name]" value="" /></div>
  <div class="default" style="width:10%; margin-left: 40%">Password : </div>
  <div class="default" style="width:49%"><input type="password" name="log[pwd]" value="" /></div>
  <div style="float: left; text-align:left; margin-left:35%; width:15%;">
    <img class="captcha" style="border-radius:5px" src="/includes/img/captcha.php?w=140" alt="Captcha Image" />
    <input type="hidden" name="id" value="captchaId" />
  </div>
  <div style="float: left; text-align: left; width: 50%; padding-top: 10px">
    Recopier le captcha :<br/>
    <input type="text" name="log[captcha]" value="" />
  </div>
  <div class="default" style="width:99%; text-align: center"><input type="submit" value="Connexion" /></div>
</form>
