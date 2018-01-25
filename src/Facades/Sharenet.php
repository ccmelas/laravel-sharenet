<?php
/*
 * This file is part of the Laravel Sharenet package.
 *
 * (c) Chiemela Chinedum <chiemelachinedum@gmail.com>
 *
 */

namespace Melas\Sharenet\Facades;

use Illuminate\Support\Facades\Facade;

class Sharenet extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-sharenet';
    }
}