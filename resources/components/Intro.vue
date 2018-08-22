<template>
    <div v-if="!activeQuestion && !result">
        <TextInput v-model="name" label="Your name" />
        <SelectDropdown v-model="activeQuizId" label="Pick your quiz" :options="getQuizzes()" />
        <div>
            <button @click="onStart">Start</button>
        </div>
    </div>
</template>
<script>
    import {mapActions} from 'vuex';
    import TextInput from './forms/input.text';
    import SelectDropdown from "./forms/select.dropdown";

    export default {
        name: 'Intro',
        components: {SelectDropdown, TextInput},
        computed: {
            allQuizzes: {
                get() {
                    return this.$store.state.allQuizzes
                }
            },
            activeQuestion: {
                get() {
                    return this.$store.state.activeQuestion;
                }
            },
            activeQuizId: {
                get() {
                    return this.$store.state.activeQuizId;
                },
                set(newValue) {
                    this.setActiveQuizId(newValue);
                }
            },
            result: {
                get() {
                    return this.$store.state.result;
                }
            },
            name: {
                get() {
                    return this.$store.state.name;
                },
                set(newName) {
                    this.setName(newName);
                }
            },
        },
        methods: Object.assign({}, mapActions([
            'setAllQuizzes',
            'setActiveQuizId',
            'setName',
            'start',
        ]), {
            onStart() {
                if (!this.name) {
                    alert('Give me your name');
                    return;
                }
                if (!this.activeQuizId) {
                    alert('Pick a quiz!');
                    return;
                }
                this.start();
            },
            getQuizzes() {
                return [].concat([{id: '', name: '---'}], this.allQuizzes.map(quiz => quiz.toArray()));
            }
        }),
        created() {
            this.setAllQuizzes();
        }
    }
</script>