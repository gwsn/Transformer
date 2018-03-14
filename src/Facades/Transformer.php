<?php
namespace Gwsn\LumenTransformer\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Transformer extends BaseFacade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'gwsn.transformer'; }
}