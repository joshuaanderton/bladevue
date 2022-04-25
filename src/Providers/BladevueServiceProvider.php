<?php

namespace Polarize\Bladevue\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;
use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Support\ServiceProvider;

class BladevueServiceProvider extends ServiceProvider 
{
  private string $pathTo = __DIR__ . '/../..';

  public function boot()
  {
    $this->loadViews();
    $this->loadComponents();
    $this->loadRoutes();
    $this->loadTranslations();
  }

  private function loadViews()
  {
    $this->loadViewsFrom(
      "{$this->pathTo}/resources/views", 'bladevue'
    );
  }

  private function loadComponents()
  {
    Blade::componentNamespace(
      'Bladevue\\View\\Components', 
      'bladevue'
    );
  }
  
  public function loadRoutes() 
  {
    $this->loadRoutesFrom(
      "{$this->pathTo}/routes/web.php"
    );
  }

  public function loadTranslations() 
  {
    $this->loadTranslationsFrom(
      "{$this->pathTo}/lang", 
      'bladevue'
    );
  }
}