<template>
    <div class="min-h-screen bg-gray-100 flex items-start">
        <div
            class="w-64 flex-shrink-0 sticky top-0 text-right border-r-2 border-pink-550 min-h-screen shadow-2xl mr-8 bg-blue-500 text-dark text-lg py-4"
        >
            <RouterLink :to="{ name: 'DocsController@LandingPage' }" v-slot="{ href, navigate }">
                <a
                    :href="href"
                    @click="navigate"
                    class="flex items-center justify-end text-6xl font-display transform -skew-y-12 text-shadow-lg mx-4 py-4"
                >Phase</a>
            </RouterLink>

            <ul class="mt-4">
                <RouterLink
                    :to="{ name: 'DocsController@DocumentationHandler', params: { version: section.version.branch, section: section.slug } }"
                    v-slot="{ href, navigate, isExactActive }"
                    v-for="section in $store.state.phase.docs.sections[$route.params.version]"
                    :key="section.id"
                >
                    <li
                        class="p-4 flex flex justify-end cursor-pointer hover:bg-blue-600"
                        @click="navigate"
                    >
                        <a
                            :class="isExactActive ? 'border-pink-550': 'border-transparent'"
                            class="w-full border-b-2"
                            :href="href"
                        >{{ section.title }}</a>
                    </li>
                </RouterLink>

                <RouterLink
                    :to="{ name: 'DocsController@LandingPage' }"
                    v-slot="{ href, navigate }"
                >
                    <li class="p-4 flex justify-end hover:bg-blue-600">
                        <a :href="href" @click="navigate" class="text-md">Go Home</a>
                    </li>
                </RouterLink>
            </ul>
        </div>
        <div class="documentation p-4">
            <div v-html="content" />
        </div>
    </div>
</template>

<script>
import marked from "marked";

export default {
    async beforeRouteUpdate(to, from, next) {
        await axios.get(to.fullPath);
        next();
    },

    computed: {
        content() {
            return marked(this.$store.state.phase.docs.active.content);
        }
    },

    mounted() {
        Prism.highlightAll();
    },

    watch: {
        content(to) {
            // Lets just call this less than ideal
            this.$nextTick(_ => Prism.highlightAll());
        }
    }
};
</script>
