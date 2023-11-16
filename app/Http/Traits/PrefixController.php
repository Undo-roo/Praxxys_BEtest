<?php

namespace App\Http\Traits;

use Inertia\Inertia;

trait PrefixController{
    
    public function render($data = [], $filename){
        return Inertia::render( $this->prefix . $filename, $data);
    }
}