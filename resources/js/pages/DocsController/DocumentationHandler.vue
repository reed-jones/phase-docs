<template>
    <div class="min-h-screen bg-gray-200 flex items-start">
        <div class="w-64 p-4 flex-shrink-0">
            <select @input="$router.push({ name: 'DocsController@DocumentationHandler', params: { version: $event, section: $route.params.section } })">
                <option
                    v-for="version in $store.state.phase.docs.versions"
                    :key="version.id"
                >{{ version.branch }}</option>
            </select>

            <ul>
                <RouterLink
                    :to="{ name: 'DocsController@DocumentationHandler', params: { version: section.version.branch, section: section.slug } }"
                    v-slot="{ href, navigate }"
                    v-for="section in $store.state.phase.docs.sections[$route.params.version]"
                    :key="section.id"
                >
                    <li>
                        <a :href="href" @click="navigate">{{ section.title }}</a>
                    </li>
                </RouterLink>

            <RouterLink :to="{ name: 'DocsController@LandingPage' }" v-slot="{ href, navigate }">
                <li>
                    <a :href="href" @click="navigate" class="text-md">Go Home</a>
                </li>
            </RouterLink>
            </ul>
        </div>
        <div class="docs p-4">
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
            return marked(this.$store.state.phase.docs.active.content)
        }
    },

    watch: {
        content(to) {
            // Lets just call this less than ideal
            this.$nextTick(_ => Prism.highlightAll())
        }
    }
};
</script>
