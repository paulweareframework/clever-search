@extends('statamic::layout')
@section('title', 'Clever Search')

@section('content')
    <div class="flex items-center mb-3">
        <h1 class="flex-1 font-bold">Clever Search Dashboard</h1>
        <p>The dashboard</p>
    </div>
    <div class="flex flex-col items-start justify-start mb-3">
      <p class="mb-1">Head to settings:</p>
      <a href="{{ cp_route('weareframework.clever-search.settings.index') }}" class="btn">settings</a>
    </div>
@stop
