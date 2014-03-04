<h2>Formulaire de contact</h2>
<?php
$controller->genCaptchaCode();
if (isset($_POST['msg']))
{
  $obj     = $_POST['msg']['object'];
  $mail    = $_POST['msg']['mail'];
  $message = $_POST['msg']['message'];
}
else
{
  $obj     = "";
  $mail    = "";
  $message = "";
}
?>
<form style="float:left; width:100%" method="POST" action="/about/contact">
  <div style="float:left; width:99%">
    <div style="float:left; width:1%; margin-left:10%">*</div>
    <div style="float:left; width:19%;">Objet :</div>
    <div style="float:left; width:66%"><input type="text" name="msg[object]" value="<?= $obj ?>" /></div>
  </div>
  <div style="float:left; width:99%">
    <div style="float:left; width:19%; margin-left:11%">Votre e-mail :</div>
    <div style="float:left; width:66%"><input type="text" name="msg[mail]" value="<?= $mail ?>" /></div>
  </div>
  <div style="float:left; width:99%">
    <div style="float:left; width:1%; margin-left:10%">*</div>
    <div style="float:left; width:19%;">Message :</div>
    <div style="float:left; width:66%"><textarea name="msg[message]" rows="8" cols="42"><?= $message ?></textarea></div>
  </div>
  <div style="float: left; text-align:left; margin-left:10%; width:20%;">
    <img class="captcha" style="border-radius:5px" src="/includes/img/captcha.php?w=140" alt="Captcha Image" />
    <input type="hidden" name="id" value="captchaId" />
  </div>
  <div style="float: left; text-align: left; width: 50%; padding-top: 10px">
    Recopier le captcha :<br/>
    <input type="text" name="msg[captcha]" value="" />
  </div>
  <div style="float:left; width:99%; text-align:center;">
    <input type="submit" name="mail" value="Envoyer" />
  </div>
  <div style="float:left; width:99%;">
    <span class="i">* Champs obligatoires</span>
  </div>
</form>
