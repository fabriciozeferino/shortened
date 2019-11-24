<template>
    <div>
        <div class="flex flex-wrap w-full mb-8">
            <!-- URL input -->
            <div class="w-full md:w-2/5 px-2 md:pr-2">
                <input
                    v-model="searchUrl"
                    class="placeholder-gray"
                    type="text"
                    placeholder="Long URL (required)">
                <p class="text-red-500 text-xs italic hidden">Please fill out this field.</p>
            </div>
            <div class="flex flex-wrap items-stretch w-full mb-4 relative">
                <div class="flex -mr-px">
                    <span class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">https://example.com/users/</span>
                </div>
                <input type="text" class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-l-none px-3 relative" >
            </div>


            <!-- Word selector -->
            <div class="w-full md:w-2/5 px-2">
                <Autocomplete v-model="selectedWord" :options="options" :search="searchWord"
                              @search="newSearchText => {searchWord = newSearchText}"/>
            </div>

            <!-- Private checkbox -->
            <div class="w-auto px-2 align-middle">
                <input id="privateCheckbox" class="leading-tight" type="checkbox" name="private">
                <label class="text-sm leading-tight" for="privateCheckbox">Private?</label>
            </div>

            <!-- Shorten submit button-->
            <div class="w-4/6 md:w-1/12 px-2">
                <button @click="saveUrl">Shorten</button>
            </div>
        </div>
        <div>
            <h1 class="text-title font-bold">Recent links</h1>
        </div>

    </div>
</template>

<script>
    import Autocomplete from "./Autocomplete";

    export default {
        name: 'shorten',
        components: {
            Autocomplete
        },
        props: ['globalUrl'],
        data() {
            return {
                searchUrl: '',
                selectedWord: null,
                searchWord: '',
                words: [],
                lastShortened: []
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
        },
        methods: {

            fetchWords() {
                return axios.get('shorten/fetch/', {params: {word: this.searchWord}})
                    .then(response => {
                        this.words = [];
                        this.words = (response.data);
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
