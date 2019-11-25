<template>
    <div class="relative" v-on-clickaway="() => { isOpen ? cancel() : null }">
        <div ref="input" class="appearance-none w-full border py-1 px-1 mb-1 leading-tight bg-white placeholder-black"
             :class="{ 'shadow-focus': isOpen }" @click="open" tabindex="0" @keydown.up.prevent="open"
             @keydown.down.prevent="open" @keydown.space.prevent="open">
            <span v-if="value !== null">{{ value }}</span>
            <span v-else>Short URL keyword (optional)</span>
        </div>
        <div v-show="isOpen" class="absolute pin-x bg-gray p-2 rounded shadow z-50">
            <input :value="search" @input="e => { $emit('search', e.target.value) }" ref="search" type="text"
                   class="appearance-none w-full border py-1 px-1 mb-3 leading-tight"
                   style="outline: 0;"
                   @keydown.up="highlightPrev" @keydown.down="highlightNext" @keydown.enter.prevent="commitSelection"
                   @keydown.esc="cancel" @keydown.tab.prevent>
            <ul ref="options" v-show="options.length > 0" class="list-reset relative overflow-y-auto scrolling-touch"
                style="max-height: 200px;">
                <li ref="option" v-for="(option, i) in options" :key="option"
                    class="px-3 py-2 text-white cursor-pointer rounded"
                    :class="[i === highlightedIndex ? 'bg-blue' : 'hover:bg-grey-darker']" @click="select(i)">{{ option
                    }}
                </li>
            </ul>
            <div v-show="options.length === 0" class="px-3 py-2 text-grey">No results found for "{{ search }}"</div>
        </div>
    </div>
</template>

<script>
    import {mixin as clickaway} from 'vue-clickaway'

    export default {
        mixins: [clickaway],
        props: ['value', 'search', 'options'],

        data() {
            return {
                isOpen: false,
                highlightedIndex: 0
            }
        },
        methods: {
            open() {
                this.isOpen = true;
                this.$nextTick(() => {
                    this.$refs.search.focus()
                })
            },
            close() {
                this.isOpen = false;
                this.$nextTick(() => {
                    this.$refs.input.focus()
                })
            },
            cancel() {
                this.close()
            },
            commitSelection() {
                this.$emit('input', this.options[this.highlightedIndex]);
                this.$emit('search', '');
                this.close()
            },
            select(index) {
                this.highlightedIndex = index;
                this.commitSelection()
            },
            highlight(index) {
                this.open();
                this.highlightedIndex = index;
                this.$nextTick(() => {
                    this.$refs.option[index].scrollIntoView({block: 'nearest'})
                })
            },
            highlightPrev() {
                this.highlight(
                    this.highlightedIndex - 1 < 0
                        ? this.options.length - 1
                        : this.highlightedIndex - 1
                )
            },
            highlightNext() {
                this.highlight(
                    this.highlightedIndex + 1 >= this.options.length
                        ? 0
                        : this.highlightedIndex + 1
                )
            }
        }
    }
</script>

<style>
    .shadow-focus {
        box-shadow: 0 0 0 2px rgba(52, 144, 220, 0.5);
    }

    .focus\:shadow-focus:focus {
        box-shadow: 0 0 0 2px rgba(52, 144, 220, 0.5);
    }

    .focus\:outline-0:focus {
        outline: 0;
    }
</style>
<!-- Source: https://codesandbox.io/s/znlxq6lxrl -->
