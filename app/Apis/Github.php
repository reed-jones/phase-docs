<?php

namespace App\Apis;

use Phased\State\Traits\Vuexable;
use ReedJones\ApiBuilder\ApiBuilder;

class Github extends ApiBuilder
{
    use Vuexable;

    protected $baseUrl = 'https://api.github.com/';

    protected $guarded = [];

    public function releases($repo)
    {
        return $this->get("repos/$repo/releases")
            ->prepare();
    }

    protected function release($repo, $releaseId)
    {
        // return $this->get("repos/$repo/releases/{$releaseId}")
        //     ->prepare(fn ($data) => [$data]);
        return collect([static::make(json_decode('{
            "url": "https://api.github.com/repos/reed-jones/phase/releases/24321907",
            "assets_url": "https://api.github.com/repos/reed-jones/phase/releases/24321907/assets",
            "upload_url": "https://uploads.github.com/repos/reed-jones/phase/releases/24321907/assets{?name,label}",
            "html_url": "https://github.com/reed-jones/phase/releases/tag/v0.3.0",
            "id": 24321907,
            "node_id": "MDc6UmVsZWFzZTI0MzIxOTA3",
            "tag_name": "v0.3.0",
            "target_commitish": "master",
            "name": "v0.3.0",
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
            "created_at": "2020-03-08T03:25:01Z",
            "published_at": "2020-03-08T03:31:00Z",
            "assets": [

            ],
            "tarball_url": "https://api.github.com/repos/reed-jones/phase/tarball/v0.3.0",
            "zipball_url": "https://api.github.com/repos/reed-jones/phase/zipball/v0.3.0",
            "body": "## [v0.3.0](https://github.com/reed-jones/phase/compare/v0.2.0...v0.3.0) - 2020-03-07\r\n### Added\r\n- Server Side Rendering option available in `config(\'phase.ssr\')` (true/false)\r\n- Client Hydration via `config(\'phase.hydrate\')` (SSR & no JS bundle)\r\n- `NODE_PATH=` env variable has been added and is required for SSR support to operate\r\n- `phased/phase` composer meta package is now available to make installation just that much easier\r\n### Changed\r\n- ** Breaking ** main vue app should now `export default new Vue` and not mount the app (no `el: \'#app\'`). This allows for SSR to be toggled on/off.\r\n- ** Breaking ** It is now mandatory & non-configurable that the main entry is `app.js`.\r\n### Removed\r\n- ** Breaking ** `js` option in assets configuration is no longer used since SSR option has been added, and has been removed. If your js bundle was named something other than `app.js` this is a breaking change.\r\n### Fixed\r\n- `@phased/state` no longer relies on `window` making it usable for other environments (primarily SSR, potentially NativeScript-vue)\r\n\r\n"
          }', true))]);
    }

    public function repo($repo)
    {
        return $this->get("repos/$repo")
            ->prepare(fn ($data) => [$data]);
    }

    protected function users($since = 0)
    {
        return $this->get('users', ['since' => $since])
                ->prepare(); // not data manipulation needed
    }

    protected function user($name)
    {
        return $this->get("users/$name")
                ->prepare(function ($data) {
                    return [$data]; // the single 'user' needs to be in an array to become a proper collection
                });
    }
}
