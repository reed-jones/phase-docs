<template>
<div>
  <div class="mb-8">
    <div class="absolute w-full h-80 bg-pink-550 transform -skew-y-3 shadow-2xl -z-1" />
    <div class="absolute w-full h-80 bg-blue-500 transform skew-y-3 shadow-2xl -z-1" />
    <div class="h-80 flex items-center justify-center flex-wrap relative">
      <h1 class="flex items-center justify-center w-full text-center relative text-10xl font-display transform -skew-y-12 text-shadow-lg text-gray-00 opacity-75 -mb-24">
        Phase
      </h1>
      <div class="absolute bottom-0 ml-32 -mb-2 transform scale-50 rotate-45">
        <StarBadge :tag="$store.state.phase.releases.latest.tag_name" />
        </div>
      <h2 class="text-base font-sans font-bold z-10 text-shadow-md">AN EZ PZ SSR PHP VUE SPA ASAP. OMG!</h2>
    </div>
    <a class="absolute top-0 right-0 py-2 px-4 bg-green-300 rounded-lg m-2 hover:shadow-2xl cursor-pointer transform hover:scale-110 duration-200">Docs</a>
  </div>

  <div class="flex justify-center w-full">
    <div class="bg-white m-16 w-full max-w-4xl rounded-lg px-16 py-12 text-xl text-center shadow-2xl">
    Introducing Phase, a collection of glue code and helpers so that you can build your Laravel Backed Vue.js single page app easier than ever
    </div>
  </div>
</div>
</template>

<script>
import StarBadge from '@/components/StarBadge'
export default {
  components: {
    StarBadge
  }
}
</script>
