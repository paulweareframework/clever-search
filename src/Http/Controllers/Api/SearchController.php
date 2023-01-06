<?php

namespace Weareframework\CleverSearch\Http\Controllers\Api;

use Fuse\Fuse;
use Illuminate\Http\Request;
use Statamic\Http\Controllers\Controller;
use Weareframework\CleverSearch\Library\Errors\GeneralError;
use Weareframework\CleverSearch\Library\Files\SettingsFile;
use Weareframework\CleverSearch\Library\Settings\CollectSettings;
use Illuminate\Support\Arr;

class SearchController extends Controller
{
    /**
     * @var SettingsFile
     */
    protected $file;

    protected $sortBy = null;
    protected $sortDirection = null;

    public function __construct(Request $request, SettingsFile $file)
    {
      $this->file = $file;
    }

    public function index(Request $request)
    {
        try {
            $query = $request->input('q');
            $optionsIn = $request->input('options') ?? null;

            $this->sortBy = $request->input('sort_by') ?? null;
            $this->sortDirection = $request->input('sort_direction') ?? null;

            $settings = (new CollectSettings($this->file))->handle();

            $fields = (!empty($settings->values['clever_search_which_fields'])) ? array_keys($settings->values['clever_search_which_fields']) : ['*'];
            $searchFields = (!empty($settings->values['clever_search_which_search_fields'])) ? array_keys($settings->values['clever_search_which_search_fields']) : ['*'];

            $list = (!empty($settings->values['clever_search_results'])) ? $settings->values['clever_search_results'] : [];

            $options = [];
            $options['isCaseSensitive'] = false;
            $options['includeScore'] = false;
            $options['shouldSort'] = true;
            $options['includeMatches'] = false;
            $options['findAllMatches'] = false;
            $options['threshold'] = 0.1;
            $options['minMatchCharLength'] = 3;
            $options['threshold'] = 0.1;
            $options['location'] = 0;
            $options['threshold'] = 0.4;
            $options['distance'] = 100;
            $options['useExtendedSearch'] = false;
            $options['ignoreLocation'] = false;
            $options['ignoreFieldNorm'] = false;
            $options['fieldNormWeight'] = 1;
//            $options['sortFn'] = $this->sortBy()

            if (! is_null($optionsIn)) {
                $options = $optionsIn;
            }

            $options['keys'] = $searchFields;

            $fuse = new Fuse($list, $options);
            $results = $fuse->search($query);

            if (! is_null($this->sortBy)) {
                uasort($results, [$this, 'my_sort']);
                dd($results);
            }

            return response()->json([
                'success' => true,
                'message' => 'index',
                'data' => $results
            ]);
        } catch (\Exception $exception) {
            return GeneralError::api($exception);
        }
    }

    protected function my_sort($a, $b)
    {
        $aField = (isset($a['item'][$this->sortBy])) ? $a['item'][$this->sortBy] : $a;
        $bField = (isset($b['item'][$this->sortBy])) ? $b['item'][$this->sortBy] : $b;

        if ($aField === $bField) return 0;

        if ($this->sortDirection === 'DESC') {
            return ($aField > $bField) ? -1 : 1;
        }

        return ($aField < $bField) ? -1 : 1;
    }
}
