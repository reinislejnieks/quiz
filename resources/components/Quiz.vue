<template>
    <div class="container">
        <Header/>
        <Intro/>
        <MainFlow/>
        <Results/>
    </div>
</template>

<script>
    import Header from "./Header";
    import Intro from "./Intro";
    import MainFlow from "./MainFlow";
    import Results from './Results';

    export default {
        name: 'Quiz',
        components: {Header, Intro, MainFlow, Results}
    }
</script>