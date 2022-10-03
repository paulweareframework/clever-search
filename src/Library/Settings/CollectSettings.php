<?php

namespace Weareframework\CleverSearch\Library\Settings;


use Illuminate\Http\Request;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Site;
use Weareframework\CleverSearch\Library\Files\SettingsFile;

class CollectSettings
{
    protected $file;
    protected $blueprint;
    protected $fields;
    protected $values;

    public function __construct(SettingsFile $file)
    {
        $this->file = $file;
    }

    public function handle()
    {
        $this->getSettings();

        return $this;
    }

    public function getSettings()
    {
        $this->setLocale();

        $this->blueprint = Blueprint::makeFromSections(config('statamic.clever-search.settings-blueprint'));
        $fields = $this->blueprint->fields();

        $this->values = $this->file->read(false);

        $fields = $fields->addValues($this->values);

        $this->fields = $fields->preProcess();
    }

    public function updateValues($values)
    {
        $fields = $this->blueprint->fields()->addValues($values);

        // Perform validation. Like Laravel's standard validation, if it fails,
        // a 422 response will be sent back with all the validation errors.
        $fields->validate();

        // Perform post-processing. This will convert values the Vue components
        // were using into values suitable for putting into storage.
        $this->file->write($fields->process()->values()->toArray());
    }

    private function setLocale()
    {
        $this->file->setLocale(
            session('statamic.cp.selected-site') ?
                Site::get(session('statamic.cp.selected-site'))->locale() :
                Site::current()->locale());
    }

    function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        } else if(property_exists($this,$name)){
            // Getter/Setter not defined so return property if it exists
            return $this->$name;
        }
        return null;
    }
}
