<?php

if (!function_exists('isActive')) {
    function isActive(mixed $patterns): string
    {
        if (request()->routeIs($patterns)) {
            return 'bg-lime-600 text-gray-100 font-semibold';
        }
        return 'text-gray-600 hover:bg-lime-200 hover:text-gray-900';
    }
}
