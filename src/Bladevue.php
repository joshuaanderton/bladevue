<?php

namespace Bladevue;

use ReflectionClass;
use Bladevue\Support\CreateBladeView;
use Illuminate\Routing\Route;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\{ View, Log, File };
use Illuminate\Support\{ Str, Collection, Js };
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Component;

abstract class Bladevue extends Component
{
  public array $stateData = [
    'mounted' => false,
    'counter' => 0,
  ];

  public function render() {}

  public function __invoke(Container $container, Route $route)
  {
    return $this->renderWithLayout();
  }

  public function renderWithLayout()
  {
    $content = $this->renderLayout(
      $this->render()
    );

    return View::make(CreateBladeView::fromString($content), [
      'state' => Js::from($this->stateData()),
    ]);
  }

  private function renderLayout(mixed $content): string
  {
    return <<<'blade'
      @extends('bladebox::app')
      @section('content')
        <div v-scope="{{ $state }}" v-cloak @vue:mounted="mounted = true; if(window.location.hash.length && (components[window.location.hash] || false)){ component = components[window.location.hash] }">
          <div v-if="mounted">
            {{ $content }}
          </div>
        </div>
      @endsection
    blade;
  }
  
  public function data()
  {
    $this->except = array_merge([
      'hasJsView',
      'stateData',
      'renderWithLayout',
      'attributes',
      'componentName'
    ], $this->except);

    return parent::data();
  }

  public function stateData(array $mergeData = []): array
  {
    $data = (new Collection(

      $this->data()

    ))->map(function($value){

      if ($value instanceof Model) :

        return $value->toArray();

      elseif ($value instanceof Builder) :

        return $value->get()->map(function($value){

          if ($value instanceof Model) :

            return $value->toArray();

          endif;

          return $value;

        })->all();

      elseif (
        $value instanceof EloquentCollection ||
        $value instanceof Collection
      ) :

        return $value->map(function($value){

          if ($value instanceof Model) :

            return $value->toArray();

          endif;

          return $value;

        })->all();

      endif;

      return $value;

    })->all();

    return array_merge($data, $mergeData, [
      'bladevue_component' => get_called_class(),
    ]);
  }
}