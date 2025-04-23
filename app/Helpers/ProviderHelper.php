<?php
namespace App\Helpers;

use App\Models\Provider;

class ProviderHelper
{
    public function useTrait($api)
    {
        $provider = Provider::where('identifier', strtolower($api))->first();
        
        $namespace = $provider->namespace;
        if (trait_exists($namespace)) {
            // Dynamically create a class using eval
            $dynamicClass = 'return new class { use ' . $namespace . '; };';
            return eval($dynamicClass);
        }
        return null;
    }
}
