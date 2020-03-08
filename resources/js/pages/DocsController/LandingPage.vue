<template>
<div>
  <div class="mb-8">
    <div class="absolute w-full h-80 bg-pink-550 transform -skew-y-3 shadow-2xl -z-1" />
    <div class="absolute w-full h-80 bg-blue-500 transform skew-y-3 shadow-2xl -z-1" />
    <div class="h-80 flex items-center justify-center flex-wrap relative text-dark">
      <h1 class="z-10 flex items-center justify-center w-full text-center relative text-10xl font-display transform -skew-y-12 text-shadow-lg -mb-24">
        Phase
      </h1>
      <div class="absolute bottom-0 ml-32 -mb-2 transform scale-50 rotate-45 z-10">
        <StarBadge :tag="$store.state.phase.releases.latest.tag_name" />
      </div>
      <h2 class="text-base font-sans font-bold z-10 text-shadow-md">AN EZ PZ SSR PHP VUE SPA ASAP. OMG!</h2>
    </div>
    <a class="absolute top-0 right-0 py-2 px-4 bg-green-300 rounded-lg m-2 hover:shadow-2xl cursor-pointer transform hover:scale-110 duration-200">Docs</a>
  </div>

  <div class="flex justify-center w-full">
    <div class="bg-gray-300 text-dark m-4 md:m-16 w-full max-w-4xl rounded-lg px-4 md:px-16 py-4 md:py-12 text-xl text-center shadow-2xl">
    Introducing Phase, a collection of glue code and helpers so that you can build your Laravel Backed Vue.js single page app easier than ever
    </div>
  </div>

  <div class="flex flex-wrap justify-center max-w-4xl mx-auto">
    <div class="w-full flex justify-end mb-4 md:mb-16 px-2"><pre class="w-full md:w-2/3 shadow-2xl"><code class="language-php" v-text="phpExample" /></pre></div>
    <!-- <div class="w-full flex max-w-4xl justify-start mb-16"><pre class="w-2/3 shadow-2xl"><code class="language-js" v-text="jsExample" /></pre></div> -->
    <div class="w-full flex max-w-4xl justify-start px-2"><pre class="w-full md:w-2/3 shadow-2xl"><code class="language-html" v-text="vueExample" /></pre></div>
    <!-- <div class="w-full flex max-w-4xl justify-start"><pre class="w-2/3 shadow-2xl"><code class="language-html" v-text="htmlExample" /></pre></div> -->
  </div>
</div>
</template>

<script>
import StarBadge from '@/components/StarBadge'
export default {
  components: {
    StarBadge
  },

  data: () => ({
    phpExample: `public function LandingPage() {
  Vuex::state([
    'project' => 'Phase',
    'author'  => 'Reed Jones <reedjones@reedjones.com>',
    'repo'    => 'reed-jones/phase'
  ]);

  return Phase::view();
}`,
    jsExample: `import Vue from 'vue';
import Vuex, { Store } from 'vuex'
import { hydrate } from '@phased/state'
Vue.use(Vuex)
export default new Store(hydrate({
    state: {
        project: '',
        author: '',
        repo: '',
    },
}))`,
    vueExample: `<div>
  <a :href="\`//github.com/\${$store.state.repo}\`">
    <h1>{{ $store.state.project }}</h1>
    <h2>{{ $store.state.author }}</h2>
    <h3>github: {{ $store.state.repo }}</h3>
  </a>
</div>`,
    htmlExample: `<div>
  <a href="//github.com/reed-jones/phase">
    <h1>Phase</h1>
    <h2>Reed Jones <reedjones@reedjones.com></h2>
    <h3>github: reed-jones/phase</h3>
  </a>
</div>`
  })
}
</script>
