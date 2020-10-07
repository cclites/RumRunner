<template>
    <div class="text-center">
        <b-pagination
            v-if="rows>perPage"
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            first-text="⏮"
            prev-text="⏪"
            next-text="⏩"
            last-text="⏭"
            class="mt-4"
        >
        </b-pagination>
    </div>

</template>

<script>

    export default {

        props: {
            rows: '',
            currentPage: '',
            perPage: '',
        },

        components: {},

        mixins: [],

        data() {
            return {

            }
        },

        computed: {},

        methods: {},

        mounted() {
        },

        watch: {},
    }
</script>

<style scoped>

</style>
