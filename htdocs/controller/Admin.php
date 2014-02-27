<?php

class Main extends Controller
{
  public function hook()
  {
    // Check if current user can access to administration section
    if (!$this->isAdmin())
      $this->forbidden();
  }
  
  public function home()
  {
    $this->title = "Accueil";
  }
}
