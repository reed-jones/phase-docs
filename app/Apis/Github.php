<?php

namespace App\Apis;

use Illuminate\Support\Facades\Cache;
use Phased\State\Traits\Vuexable;
use ReedJones\ApiBuilder\ApiBuilder;

class Github extends ApiBuilder
{
    use Vuexable;

    protected $baseUrl = 'https://api.github.com/';

    protected $guarded = [];

    protected function releases($repo)
    {
        return $this->get("repos/{$repo}/releases")
            ->prepare();
    }

    protected function repo($repo)
    {
        return $this->get("repos/{$repo}")
            ->prepare(fn ($data) => [$data]);
    }

    protected function release($repo, $releaseId)
    {
        $cache = 'release-info';

        if (!Cache::has($cache)) {
            Cache::put(
                $cache,
                $this->get("repos/{$repo}/releases/{$releaseId}")->prepare(fn ($data) => [$data])->first(),
                now()->addHour()
            );
        }
        return Cache::get($cache);
    }

    protected function users($since = 0)
    {
        return $this->get('users', ['since' => $since])
            ->prepare(); // not data manipulation needed
    }

    protected function user($name)
    {
        // the single 'user' needs to be in
        // an array to become a proper collection
        return $this->get("users/{$name}")
            ->prepare(fn ($data) => [$data]);
    }
}
