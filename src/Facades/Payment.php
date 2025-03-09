<?php

namespace Mrfansi\Payment\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mrfansi\Payment\Payment
 */
class Payment extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Mrfansi\Payment\Payment::class;
    }
}
