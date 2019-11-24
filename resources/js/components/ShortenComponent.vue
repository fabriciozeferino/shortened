<template>
    <div>
        <div class="flex flex-wrap w-full mb-8">

            <!-- URL input -->
            <div class="w-full md:w-2/5 mb-2 px-2 md:pr-0">
                <div class="flex flex-wrap items-stretch">
                    <div class="flex -mr-px appearance-none border p-1"><span
                        class="leading-tight">{{ globalUrl }}/</span></div>
                    <input
                        v-model="searchUrl"
                        class="placeholder-gray inline-block flex-shrink flex-grow flex-auto"
                        type="text"
                        placeholder="Long URL (required)"
                    >
                </div>
            </div>

            <!-- Word selector -->
            <div class="w-full md:w-2/5 mb-2 px-2">
                <Autocomplete v-model="selectedWord" :options="options" :search="searchWord"
                              @search="newSearchText => {searchWord = newSearchText}"/>
            </div>

            <!-- Private checkbox -->
            <div class="w-auto mb-2 px-2 align-middle">
                <input id="privateCheckbox" class="leading-tight" type="checkbox" name="private">
                <label class="text-sm leading-tight" for="privateCheckbox">Private?</label>
            </div>

            <!-- Shorten submit button-->
            <div class="w-4/6 mb-2 px-2 md:w-1/12">
                <button
                    @click="saveUrl" v-bind:disabled="searchUrl === ''"
                    :class="(searchUrl === '') ? 'bg-blue-lighter' : '' "
                >
                    Shorten
                </button>
                {{searchUrl}}
            </div>
        </div>

        <div class="flex flex-wrap w-full p-2">
            <RecentLinks :links="recentLinks" :url="globalUrl + '/'"/>
        </div>

    </div>
</template>

<script>
    import Autocomplete from "./Autocomplete";
    import RecentLinks from "./RecentLinks";

    export default {
        name: 'shorten',
        components: {
            Autocomplete,
            RecentLinks
        },
        props: ['globalUrl'],
        data() {
            return {
                searchUrl: '',
                selectedWord: null,
                searchWord: '',
                words: [],
                lastShortened: [],
                recentLinks: []
            }
        },
        computed: {
            options() {
                return this.words.filter(item => {
                    return item.toLowerCase().startsWith(this.searchWord.toLowerCase())
                })
            }
        },
        mounted() {
            this.fetchWords();
            this.fetchRecentLinks();
        },
        methods: {

            fetchWords() {
                return axios.get('shorten/fetch/', {params: {word: this.searchWord}})
                    .then(response => {
                        this.words = [];
                        this.words = (response.data);
                    })
            },

            fetchRecentLinks() {
                return axios.get('shorten/fetchRecentLinks/')
                    .then(response => {
                        this.recentLinks = [];
                        this.recentLinks = (response.data);
                    })
            },


            saveUrl() {
                axios.put(`shorten/${this.selectedWord}`, {
                    word: this.selectedWord,
                    url: this.searchUrl
                }).then(response => {
                    this.selectedWord = null;
                    this.searchUrl = '';
                    this.fetchWords();
                    this.fetchRecentLinks();
                })
            }
        }
    }
</script>

<style>
    .btn {
        appearance: none;
    }
</style>
