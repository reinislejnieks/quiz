<template>
    <div v-if="!activeQuestion && !result" class="l-main main">
        <div>
            <div class="intro">
                <h1 class="intro__headline">Hei, vēlies pārbaudīt, kādas ir Tavas spējas?</h1>
                <p class="intro__text">Izvēlies kādu no tēmām, izpildi testu un noskaidro!</p>
            </div>
            <div class="login form">
                <TextInput v-model="name" label="Tavs vārds" />
                <SelectDropdown v-model="activeQuizId" label="Izvēlies testu" :options="getQuizzes()" />
                <button class="form__submit btn" @click="onStart">Sākt pildīt testu!</button>
            </div>
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
                    console.log('Give me your name');
                    return;
                }
                if (!this.activeQuizId) {
                    console.log('Pick a quiz!');
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