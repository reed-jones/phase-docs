<template>
    <div dusk="landing-page">
        <div class="mb-8">
            <div class="absolute w-full h-80 bg-pink-550 transform -skew-y-3 shadow-2xl -z-1" />
            <div class="absolute w-full h-80 bg-blue-500 transform skew-y-3 shadow-2xl -z-1" />
            <div class="h-80 flex items-center justify-center flex-wrap relative text-dark">
                <h1
                    class="z-10 flex items-center justify-center w-full text-center relative text-10xl font-display transform -skew-y-12 text-shadow-lg -mb-24"
                >Phase</h1>
                <div class="absolute bottom-0 ml-32 -mb-2 transform scale-50 rotate-45 z-10">
                    <StarBadge :tag="$store.state.phase.releases.latest.tag_name" />
                </div>
                <h2

                    class="text-base font-sans font-bold z-10 text-shadow-md"
                >AN EZ PZ SSR PHP VUE SPA ASAP. OMG!</h2>
            </div>
            <div class="absolute top-0 right-0 flex p-4 z-10">
              <a href="//github.com/reed-jones/phase" dusk="github-link">
                <img class="h-10 mr-4" src="/images/GitHub-Mark-64px.png" alt="github-logo" />
              </a>
              <RouterLink
                :to="{ name: 'DocsController@DocumentationHandler', params: { version: 'master', section: 'getting-started'} }"
                v-slot="{ href, navigate }"
              >
            <a
              :href="href"
              @click="navigate"
              dusk="docs-link"
              class="docs h-10 flex items-center justify-center py-2 px-4 bg-green-300 rounded-lg hover:shadow-2xl cursor-pointer transform hover:scale-110 duration-200"
            >Docs</a>
              </RouterLink>
            </div>
        </div>

        <div class="flex justify-center w-full">
            <div
                class="bg-gray-300 text-dark m-4 md:m-16 w-full max-w-4xl rounded-lg px-4 md:px-16 py-4 md:py-12 text-xl text-center shadow-2xl"
            >Introducing Phase, a collection of glue code, helper functions, and attempted automation so that you can build your Laravel-backed Vue.js Single Page App easier than ever.</div>
        </div>

        <div class="flex flex-wrap justify-center max-w-4xl mx-auto my-4">
            <div class="w-full flex justify-end mb-4 px-4 transform md:-skew-y-3 md:skew-x-3">
              <pre class="w-full md:w-2/3 shadow-2xl rounded-lg language-php"><code>{{ phpRoutesExample }}</code></pre>
            </div>
            <div class="w-full flex max-w-4xl justify-start mb-4 px-4 transform md:skew-y-3 md:-skew-x-3">
              <pre class="w-full md:w-2/3 shadow-2xl rounded-lg language-html"><code>{{ vueRouterLinkExample }}</code></pre>
            </div>

            <div class="w-full flex justify-end mb-4 px-4 transform md:-skew-y-3 md:skew-x-3">
              <pre class="w-full md:w-2/3 shadow-2xl rounded-lg language-php" language="php"><code class="language-php">{{ phpExample }}</code></pre>
            </div>
            <div class="w-full flex max-w-4xl justify-start mb-4 px-4 transform md:skew-y-3 md:-skew-x-3">
              <pre class="w-full md:w-2/3 shadow-2xl rounded-lg language-html" language="html"><code class="language-html">{{ vueExample }}</code></pre>
            </div>
            <div class="w-full flex justify-end  px-4 transform md:-skew-y-3 md:skew-x-3">
              <pre class="w-full md:w-2/3 shadow-2xl rounded-lg language-html"><code>{{ ssrExample }}</code></pre>
            </div>
        </div>

        <div class="flex justify-center w-full">
            <div
                class="bg-gray-300 text-dark m-4 md:mx-16 md:my-12 w-full max-w-4xl rounded-lg shadow-2xl px-4 md:px-16 py-4 md:py-12 "
            >
                <h2 class="text-2xl mb-2 mx-4 md:mx-0">Changelog</h2>
                <div class="flex items-stretch mb-2 h-6">

                  <a href="https://www.npmjs.com/package/@phased/phase" class="shadow-md mr-2 h-full">
                    <img class="h-full" alt="npm (scoped)" src="https://img.shields.io/npm/v/@phased/phase">
                  </a>

                  <a href="https://packagist.org/packages/phased/phase" class="mr-2 h-full">
                    <img class="shadow-md h-full" alt="Packagist Version" src="https://img.shields.io/packagist/v/phased/phase?label=composer">
                  </a>

                  <div class="shadow-md mr-2 h-full">
                    <img class="h-full" alt="Chipper CI" src="https://app.chipperci.com/projects/9b19fe8f-bd39-4f36-aa2f-f7d313e23b58/status/master">
                  </div>
                </div>
                <div class="changelog px-4 md:px-0" v-html="changelog" />

                <div class='text-xs font-bold mt-8 w-full flex justify-end'><a href="https://github.com/reed-jones/phase/releases">More...</a></div>
            </div>
        </div>
    </div>
</template>

<script>
import StarBadge from "@/components/StarBadge";
import marked from "marked";
import Prism from 'prismjs'

export default {
    components: {
        StarBadge
    },

    computed: {
        changelog() {
            return marked(this.$store.state.phase.releases.latest.body);
        },
    },

    mounted() {
        Prism.highlightAll();
    },

    data: () => ({
        phpExample: `// Load data from the Controller
public function LandingPage() {
  Vuex::state([
    'project' => 'Phase',
    'author'  => 'Reed Jones <reedjones@reedjones.com>',
    'repo'    => 'reed-jones/phase'
  ]);

  return Phase::view();
}`,
        vueExample: `<!-- And access from the .Vue -->
<div>
  <a :href="\`//github.com/\${$store.state.repo}\`">
    <h1>{{ $store.state.project }}</h1>
    <h2>{{ $store.state.author }}</h2>
    <h3>github: {{ $store.state.repo }}</h3>
  </a>
</div>`,
        ssrExample: `<!-- Fully Server Rendered -->
<div>
  <a href="//github.com/reed-jones/phase">
    <h1>Phase</h1>
    <h2>Reed Jones <reedjones@reedjones.com></h2>
    <h3>github: reed-jones/phase</h3>
  </a>
</div>`,
      phpRoutesExample: `// Define your routes/web.php
Route::phase('/', 'HomeController@HomePage');
Route::phase('/about', 'HomeController@AboutPage');
`,
      vueRouterLinkExample: `<!-- And navigate there! -->
<RouterLink to="/">
  Go Home
</RouterLink>

<RouterLink :to="{ name: 'HomeController@AboutPage' }">
  About
</RouterLink>
`
    })
};
</script>
