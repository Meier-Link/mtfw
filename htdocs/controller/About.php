<?php

class About extends Controller
{
  public function home()
  {
    $this->title = "Infos";
  }
  
  public function licence()
  {
    $this->title = "Licence";
  }
  
  public function contact()
  {
    $this->title = "Contact";
    
    if (isset($_POST['msg']))
    {
      $error = 0;
      $msg = $_POST['msg'];
      if (empty($msg['object']))
      {
        Log::err("Le sujet est obligatoire !");
        $error++;
      }
      if (empty($msg['message']))
      {
        Log::err("Vous n'avez pas rédigé de message !");
        $error++;
      }
      if (!$this->isValidCaptcha($msg['captcha']))
      {
        Log::err("Vous avez mal recopié le captcha !");
        $error++;
      }
      
      if ($error == 0)
      {
        if (empty($msg['mail']))
          $headers = 'From: ' . Conf::get('DEFAULT_SEND');
        else
          $headers = 'From: ' . $msg['mail'];
        $object = trim(Conf::get('MAIL_TAG') . ' ' . $msg['object']);
        
        if (mail(Conf::get('OWNER_MAIL'), $object, $msg['message'], $headers))
          Log::inf("Le message a été correctement envoyé !");
        else
          Log::war("Impossible d'envoyer le mail ! (à priori, cette fonctionnalité n'est pas encore disponible sur le serveur)");
      }
    }
  }
}
