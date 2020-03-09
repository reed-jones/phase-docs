<template>
    <div class="min-h-screen bg-gray-200 flex flex-wrap items-center justify-center text-center">
        <div>
            <h1 class="text-4xl">Coming Soon...</h1>
            <RouterLink :to="{ name: 'DocsController@LandingPage' }" v-slot="{ href, navigate }">
                <a :href="href" @click="navigate" class="text-md">Go Home</a>
            </RouterLink>
        </div>
    </div>
</template>

<script>
export default {
    //
};
</script>
