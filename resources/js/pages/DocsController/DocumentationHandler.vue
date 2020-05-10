<template>
    <div class="min-h-screen bg-gray-100 flex items-start justify-start">
        <div
            class="w-1/3 flex-grow-0 flex-shrink-0 sticky top-0 text-right border-r-2 border-pink-550 min-h-screen shadow-2xl bg-blue-500 text-dark text-lg py-4"
        >
        <div class="flex justify-end mb-8">
            <RouterLink :to="{ name: 'DocsController@LandingPage' }" v-slot="{ href, navigate }">
                <a
                    :href="href"
                    @click="navigate"
                    class="flex items-center justify-end text-6xl font-display transform -skew-y-12 text-shadow-lg mx-8 pt-4"
                >Phase</a>
            </RouterLink>
        </div>
            <ul class="mt-4">
                <RouterLink
                    :to="{ name: 'DocsController@DocumentationHandler', params: { version: section.version.branch, section: section.slug } }"
                    v-slot="{ href, navigate, isExactActive }"
                    v-for="section in $store.state.phase.docs.sections[$route.params.version]"
                    :key="section.id"
                >
                    <li
                        class="px-4 flex flex justify-end cursor-pointer hover:bg-blue-600"
                        @click="navigate"
                    >
                        <a
                            :class="isExactActive ? 'border-pink-550': 'border-transparent'"
                            class="w-full border-b-2 p-4"
                            :href="href"
                        >{{ section.title }}</a>
                    </li>
                </RouterLink>

                <RouterLink
                    :to="{ name: 'DocsController@LandingPage' }"
                    v-slot="{ href, navigate }"
                >
                    <li class="px-4 flex justify-end hover:bg-blue-600">
                        <a :href="href" @click="navigate" class="p-4 text-md w-full">Go Home</a>
                    </li>
                </RouterLink>
            </ul>
        </div>
        <div class="documentation p-4 flex-1 w-full h-screen overflow-y-scroll">
            <div v-html="content" />
            <a :href="editLink">Edit This Page</a>
        </div>
    </div>
</template>

<script>
import marked from "marked";
import Prism from 'prismjs'

export default {
    async beforeRouteUpdate(to, from, next) {
        await axios.get(to.fullPath, { params: { phase: true }});
        next();
    },

    computed: {
        content() {
            return marked(this.$store.state.phase.docs.active.content);
        },
        editLink() {
            const repo = this.$store.state.repo
            const version = this.$store.state.phase.docs.active.version.branch
            const slug = this.$store.state.phase.docs.active.slug
            return `https://github.com/${repo}-docs/edit/master/storage/app/docs/${version}/${slug}.md`
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
