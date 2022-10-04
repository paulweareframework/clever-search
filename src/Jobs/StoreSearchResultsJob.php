<?php

namespace Weareframework\CleverSearch\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Statamic\Facades\Collection as CollectionFacade;
use Statamic\Facades\Entry;
use Statamic\Facades\File;
use Statamic\Facades\Stache;
use Statamic\Support\Arr;
use Weareframework\ApiProductImporter\Actions\Products\ImportApiProductAction;
use Weareframework\ApiProductImporter\Library\CheckData\FieldIsSet;
use Weareframework\ApiProductImporter\Models\ApiProduct;
use Weareframework\CleverSearch\Library\Results\StoreSearchResults;
use Weareframework\ProductImporter\Jobs\Imports\ImportConfigurableFwkProductToStatamic;
use Weareframework\ProductImporter\Models\FwkProduct;

class StoreSearchResultsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use FieldIsSet;
    private $file;

    public function __construct(
        $file
    ) {
        $this->file = $file;
    }

    public function handle()
    {
        $result = (new StoreSearchResults($this->file))->handle();
        return false;
    }
}
