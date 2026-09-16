<?php

if (!function_exists('__t')) {
    /**
     * Terjemahan sederhana berbasis array.
     * Mendukung fallback ke bahasa Indonesia.
     */
    function __t(string $key): string
    {
        $locale = session('locale', 'id');

        $translations = [
            'id' => \App\Lang\id::all(),
            'en' => \App\Lang\en::all(),
        ];

        $strings = $translations[$locale] ?? $translations['id'];

        return $strings[$key] ?? $translations['id'][$key] ?? $key;
    }
}
