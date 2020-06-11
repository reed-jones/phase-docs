<template>
    <div
        class="h-screen bg-gray-100 flex items-start justify-start overflow-y-scroll"
        :dusk="`docs/${$store.state.phase.docs.active.slug}`"
    >
        <div
            class="w-1/3 flex-grow-0 flex-shrink-0 sticky top-0 text-right border-r-2 border-pink-550 min-h-screen shadow-2xl bg-blue-500 text-dark text-lg py-4"
        >
            <div class="flex justify-end mb-8">
                <RouterLink
                    :to="{ name: 'DocsController@LandingPage' }"
                    v-slot="{ href, navigate }"
                >
                    <a
                        :href="href"
                        @click="navigate"
                        class="flex items-center justify-end text-6xl font-display transform -skew-y-12 text-shadow-lg mx-8 pt-4"
                    >Phase</a>
                </RouterLink>
            </div>

            <ais-instant-search class="w-full" :search-client="searchClient" index-name="sections">
                <AisSearchBox placeholder="Search..." v-model="searchTerm" @blur="clearAfterAMoment"/>

                <ais-state-results>
                    <template #default="{ query }">
                        <ais-hits v-if="query.length > 0">
                            <template #item="{ item }">
                                <RouterLink
                                    :to="{ name: 'DocsController@DocumentationHandler', params: { version: 'master', section: item.slug } }"
                                >
                                    <h1 v-html="item._highlightResult.title.value" class="border-b-pink-550 border-b-2" />
                                    <div
                                        class="text-base"
                                        v-html="item._highlightResult.content.value.substring(item._highlightResult.content.value.indexOf('<mark'), item._highlightResult.content.value.indexOf('mark') + 100)"
                                    />
                                </RouterLink>
                            </template>
                        </ais-hits>
                        <span v-else />
                    </template>
                </ais-state-results>
            </ais-instant-search>
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
                            :dusk="`sidebar/${section.slug}`"
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
        <div class="documentation p-8 w-full flex-grow-1 flex-1 min-h-screen">
            <div v-html="content" />
            <a :href="editLink">Edit This Page</a>
        </div>
    </div>
</template>

<script>
import marked from "marked";
import Prism from "prismjs";
import algoliasearch from "algoliasearch/lite";

export default {
    async beforeRouteUpdate(to, from, next) {
        await axios.get(to.fullPath, { params: { phase: true } });
        next();
    },

    data: () => ({
        searchTerm: '',
        searchClient: algoliasearch(
            "18KESLF2CV",
            "a84786d1d540cd661be924c651b70a4c"
        )
    }),

    computed: {
        content() {
            return marked(this.$store.state.phase.docs.active.content);
        },
        editLink() {
            const repo = this.$store.state.repo;
            const version = this.$store.state.phase.docs.active.version.branch;
            const slug = this.$store.state.phase.docs.active.slug;
            return `https://github.com/${repo}-docs/edit/master/storage/app/docs/${version}/${slug}.md`;
        }
    },

    mounted() {
        Prism.highlightAll();
    },

    methods: {
        clearAfterAMoment() {
            setTimeout(() => {
                this.searchTerm = ''
            }, 100)
        }
    },

    watch: {
        content(to) {
            // Lets just call this less than ideal
            this.$nextTick(_ => Prism.highlightAll());
        }
    }
};
</script>

<style lang="scss">
.ais-InstantSearch {
    // @apply bg-red-500;
}
.ais-SearchBox-form {
    position: relative;
    display: flex;
    flex-flow: row wrap;
    align-items: center;
    justify-content: flex-end;
    button {
        position: absolute;
        display: none;
    }
}
.ais-SearchBox-input {
    width: 100%;
    background: transparent;
    margin: 0 .5rem;
    padding: 1rem .5rem;
    border-radius: 0.5rem;
    text-align: right;
    border: 2px transparent solid;
    &:focus {
        outline: none;
        border: 2px #eb3abc solid;
    }
    &::placeholder {
        color: white;
    }
}
.ais-Hits {
    position: absolute;
    left: 0;
    right: 0;
    background: #4299e1;
    &-item {
        margin: 1rem;
        padding: 1rem;
        background: #fff;
        border-radius: 0.5rem;
    }
}
mark {
    background-color: #eb3abc;
    color: white;
}
</style>
