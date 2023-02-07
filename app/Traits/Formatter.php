<?php

namespace App\Traits;

trait Formatter
{
     public function formatPhone(string $phone): string
     {
         return str_replace(['(',')','-'],'', $phone);
     }
}
