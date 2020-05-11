<?php

namespace App\Apis;

use Phased\State\Traits\Vuexable;
use ReedJones\ApiBuilder\ApiBuilder;

class Github extends ApiBuilder
{
    use Vuexable;

    protected const CURRENT_VERSION = '{
        "url": "https://api.github.com/repos/reed-jones/phase/releases/24540851",
        "assets_url": "https://api.github.com/repos/reed-jones/phase/releases/24540851/assets",
        "upload_url": "https://uploads.github.com/repos/reed-jones/phase/releases/24540851/assets{?name,label}",
        "html_url": "https://github.com/reed-jones/phase/releases/tag/v0.4.0",
        "id": 24540851,
        "node_id": "MDc6UmVsZWFzZTI0NTQwODUx",
        "tag_name": "v0.4.0",
        "target_commitish": "master",
        "name": "v0.4.0",
        "draft": false,
        "author": {
          "login": "reed-jones",
          "id": 11511864,
          "node_id": "MDQ6VXNlcjExNTExODY0",
          "avatar_url": "https://avatars0.githubusercontent.com/u/11511864?v=4",
          "gravatar_id": "",
          "url": "https://api.github.com/users/reed-jones",
          "html_url": "https://github.com/reed-jones",
          "followers_url": "https://api.github.com/users/reed-jones/followers",
          "following_url": "https://api.github.com/users/reed-jones/following{/other_user}",
          "gists_url": "https://api.github.com/users/reed-jones/gists{/gist_id}",
          "starred_url": "https://api.github.com/users/reed-jones/starred{/owner}{/repo}",
          "subscriptions_url": "https://api.github.com/users/reed-jones/subscriptions",
          "organizations_url": "https://api.github.com/users/reed-jones/orgs",
          "repos_url": "https://api.github.com/users/reed-jones/repos",
          "events_url": "https://api.github.com/users/reed-jones/events{/privacy}",
          "received_events_url": "https://api.github.com/users/reed-jones/received_events",
          "type": "User",
          "site_admin": false
        },
        "prerelease": false,
        "created_at": "2020-03-15T19:00:45Z",
        "published_at": "2020-03-15T19:19:58Z",
        "assets": [],
        "tarball_url": "https://api.github.com/repos/reed-jones/phase/tarball/v0.4.0",
        "zipball_url": "https://api.github.com/repos/reed-jones/phase/zipball/v0.4.0",
        "body": "## [v0.4.0](https://github.com/reed-jones/phase/compare/v0.3.0...v0.4.0) - 2020-03-15\r\n### Added\r\n- Now follows any axios redirects (with page transition, enabled by default)\r\n- Customizable `<head>` section (meta tags, etc) using optional `parts/head.blade.php`\r\n- Route code splitting now available using the option `codeSplit: true` in `webpack.mix.js`\r\n\r\n### Changed\r\n- All automated ajax requests append `phase=true` to the query string.\r\n\r\n### Fixed\r\n- After using vue-router, then navigating to an external site, pressing \'back\' no longer displays json"
      }';

    protected $baseUrl = 'https://api.github.com/';

    protected $guarded = [];

    public function releases($repo)
    {
        return $this->get("repos/{$repo}/releases")
            ->prepare();
    }

    public function repo($repo)
    {
        return $this->get("repos/{$repo}")
            ->prepare(fn ($data) => [$data]);
    }

    protected function release($repo, $releaseId)
    {
        if (config('app.use_live_changelog')) {
            return $this->get("repos/{$repo}/releases/{$releaseId}")
                ->prepare(fn ($data) => [$data]);
        }

        // Until a good caching solution is found,
        // this will be hardcoded to avoid rate limiting.
        return collect([
            static::make(json_decode(self::CURRENT_VERSION, true)),
        ]);
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
