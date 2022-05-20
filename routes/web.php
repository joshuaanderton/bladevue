<?php

use Illuminate\Support\Facades\{
  File,
  Route
};

Route::get('bladevue/app.js', fn () => File::get(__FILE__ . '.../public/js/bladevue.js'));