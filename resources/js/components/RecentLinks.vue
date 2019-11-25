<template>
    <div class="w-full">
        <h1 class="text-title mb-2"><a href="shorten/list">Recent Links</a></h1>
        <div v-for="(link, index) in links" class="p-4 border bg-white"
             :class="((links.length -1) === index) ?'':'border-b-0'">

            <a class="block text-link text-blue" :href="url + link.word">{{ url + link.word }}</a>
            <span class="block text-base">{{ link.updated_at }}</span>
            <span class="block">{{ url + link.url }}</span>

        </div>
    </div>

</template>

<script>


    export default {
        props: ['links','url'],

        data() {
            return {
                isOpen: false
            }
        },
        methods: {}
    }
</script>

