<?php

namespace Weareframework\CleverSearch\Listeners;

use Statamic\Events\EntrySaved;
use Weareframework\CleverSearch\Jobs\StoreSearchResultsJob;
use Weareframework\CleverSearch\Library\Files\SettingsFile;

class UpdateCleverSearchStoredResults
{
    protected $file;

    public function __construct(SettingsFile $file)
    {
        $this->file = $file;
    }

    public function handle(EntrySaved $entrySaved)
    {
        StoreSearchResultsJob::dispatch($this->file);
    }
}
