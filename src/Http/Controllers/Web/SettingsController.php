<?php

namespace Weareframework\CleverSearch\Http\Controllers\Web;

use Statamic\Facades\Entry;
use Weareframework\CleverSearch\Library\Files\SettingsFile;
use Statamic\Facades\Site;
use Illuminate\Http\Request;
use Statamic\Facades\Blueprint;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\UploadedFile;
use Statamic\Http\Controllers\CP\CpController;
use Weareframework\CleverSearch\Library\Results\StoreSearchResults;
use Weareframework\CleverSearch\Library\Settings\CollectSettings;

class SettingsController extends CpController
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
        $settings = (new CollectSettings($this->file))->handle();

        return view('clever-search::settings.index', [
            'blueprint' => $settings->blueprint->toPublishArray(),
            'values'    => $settings->fields->values(),
            'meta'      => $settings->fields->meta(),
        ]);
    }

    public function update(Request $request)
    {
        $settings = (new CollectSettings($this->file))->handle();
        $settings->updateValues($request->all());
    }

    public function updateIndexes(Request $request)
    {
      try {
        $result = (new StoreSearchResults($this->file))->handle();

        if (! $result) {
            throw new \Exception('It did not save');
        }

        session()->flash('success', 'Product Color Swatch updated successfully');
      } catch(\Exception $exception) {
        session()->flash('error', $exception->getMessage());
      }
      return redirect()->route('statamic.cp.weareframework.clever-search.settings.index');
    }

}
