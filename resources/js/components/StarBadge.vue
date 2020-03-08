<template>
    <div class="star-badge-wrapper">
        <div class="star-badge">
            <div class="star-badge__inner">
                <p>
                    <span class="star-badge__text--big">{{ tag }}</span>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['tag']
};
</script>
