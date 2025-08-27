<?php

namespace App\Support;

use Illuminate\Support\Facades\Session;

class SessionReader
{
    protected array $excluded;
    protected array $excludedPrefixes;

    public function __construct()
    {
        $this->excluded = config('session_reader.excluded', []);
        $this->excludedPrefixes = config('session_reader.excluded_prefixes', []);
    }

    /**
     * 只回傳使用者自己定義的 session
     */
    public function all(): array
    {
        $all = Session::all();

        return collect($all)
            ->reject(fn ($value, $key) => $this->isExcluded($key))
            ->toArray();
    }

    /**
     * 取得單一 key（只限使用者自定義的）
     */
    public function get(string $key, $default = null)
    {
        return $this->isExcluded($key)
            ? $default
            : Session::get($key, $default);
    }

    /**
     * 判斷 key 是否應該排除
     */
    protected function isExcluded(string $key): bool
    {
        if (in_array($key, $this->excluded)) {
            return true;
        }

        foreach ($this->excludedPrefixes as $prefix) {
            if (str_starts_with($key, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
