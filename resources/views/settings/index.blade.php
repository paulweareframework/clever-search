@extends('statamic::layout')
@section('title', 'Clever Search')
@section('content')
    <div class="flex items-center mb-3">
        <h1 class="flex-1">Clever Search Settings</h1>
    </div>

    <div>
        <publish-form
            title="Settings"
            action="{{ cp_route('weareframework.clever-search.settings.update') }}"
            :blueprint='@json($blueprint)'
            :meta='@json($meta)'
            :values='@json($values)'
        ></publish-form>

        @if(isset($values['clever_search_which_collection']) && !is_null($values['clever_search_which_collection']) && !empty($values['clever_search_which_collection']))
          <div class="flex flex-col items-start justify-start mb-3">
            <p class="mb-1">No we have the settings you can:</p>
            <a href="{{ cp_route('weareframework.clever-search.settings.update-search-indexes') }}" class="btn mb-1">Update Search Indexes</a>
            <p>We have <strong>{{ is_array($values['clever_search_results']) ? count($values['clever_search_results']) : 0 }}</strong> records indexed for search</p>
            <p>Test the results with the api search results: {{ config('app.url') }}/clever-search/search?q={name,sku,description}</p>
          </div>
        @endif
    </div>
@stop
