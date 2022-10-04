<?php

namespace Weareframework\CleverSearch\Http\Controllers\Api;

use Fuse\Fuse;
use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;
use Weareframework\CleverSearch\Library\Errors\GeneralError;
use Weareframework\CleverSearch\Library\Files\SettingsFile;
use Weareframework\CleverSearch\Library\Settings\CollectSettings;

class SearchController extends CpController
{
    /**
     * @var SettingsFile
     */
    protected $file;

    public function __construct(Request $request, SettingsFile $file)
    {
      $this->file = $file;

      parent::__construct($request);
    }

    public function index(Request $request)
    {
        try {
            $query = $request->input('q');
            $optionsIn = $request->input('options') ?? null;
            $settings = (new CollectSettings($this->file))->handle();

            $fields = (!empty($settings->values['clever_search_which_fields'])) ? array_keys($settings->values['clever_search_which_fields']) : ['*'];
            $list = (!empty($settings->values['clever_search_results'])) ? $settings->values['clever_search_results'] : [];

            $options = [];
            if (! is_null($optionsIn)) {
                $options = $optionsIn;
            }

            $options['keys'] = $fields;

            $fuse = new Fuse($list, $options);
            $results = $fuse->search($query);
            return response()->json([
                'success' => true,
                'message' => 'index',
                'data' => $results
            ]);
        } catch (\Exception $exception) {
            return GeneralError::api($exception);
        }
    }
}
