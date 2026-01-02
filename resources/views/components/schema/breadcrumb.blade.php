@props([
    'name',
    'params' => []
])

{!! \Diglactic\Breadcrumbs\Breadcrumbs::view('breadcrumbs::json-ld', $name, ...$params) !!}
