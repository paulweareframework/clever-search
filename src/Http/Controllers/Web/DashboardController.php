<?php

namespace Weareframework\CleverSearch\Http\Controllers\Web;

use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;
use Weareframework\CleverSearch\Library\Files\SettingsFile;
use Weareframework\CleverSearch\Library\Settings\CollectSettings;

class DashboardController extends CpController
{

    public function index(Request $request, SettingsFile $file)
    {
        $settings = (new CollectSettings($file))->handle();
        return view('clever-search::dashboard.index', [
            'settings' => $settings
        ]);
    }

}
