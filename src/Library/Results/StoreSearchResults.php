<?php

namespace Weareframework\CleverSearch\Library\Results;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Weareframework\CleverSearch\Library\Files\SettingsFile;
use Weareframework\CleverSearch\Library\Settings\CollectSettings;

class StoreSearchResults
{
    protected $file;

    public function __construct(SettingsFile $file)
    {
        $this->file = $file;
    }

    public function handle()
    {
        try {
            $settings = (new CollectSettings($this->file))->handle();

            $collection = (!empty($settings->values['clever_search_which_collection'])) ? $settings->values['clever_search_which_collection'] : null;
            $fields = (!empty($settings->values['clever_search_which_fields'])) ? array_keys($settings->values['clever_search_which_fields']) : ['*'];
            $results = Entry::query()
                ->where('collection', $collection)
                ->get($fields);

            if ($results->count() === 0) {
                throw new \Exception('No results');
            }

            $values = $settings->values;

            $values['clever_search_results'] = $results->toArray();
            $settings->updateValues($values);
            return true;
        } catch(\Exception $exception) {
            Log::info($exception->getMessage());
            return false;
        }

    }

}
