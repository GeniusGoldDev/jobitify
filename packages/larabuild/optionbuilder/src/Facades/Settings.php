<?php

namespace Larabuild\Optionbuilder\Facades;

use Illuminate\Support\Facades\Facade;

/**
    * @method  boolean store($section, $key, $value)
    * @method  boolean get($key)
    * @method  boolean getSectionSetting($params, $fields)
 *
 * @see \Optionbuillder\Settings\Settings
 */
class Settings extends Facade {

    protected static function getFacadeAccessor() {
        return 'settings';
    }
}
