<?php

namespace App\Http\Service\ZarulIzham\src\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ZarulIzham\OCRmyPDF\OCRmyPDF
 */
class OCRmyPDF extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ZarulIzham\OCRmyPDF\OCRmyPDF::class;
    }
}
