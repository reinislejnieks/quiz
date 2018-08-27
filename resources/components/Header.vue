<template>
    <div class="header l-header">
        <div class="logo">
            <Logo />
        </div>

    </div>
</template>
<script>
    import Logo from '../assets/logo.svg';
    export default {
        name:'Header',
        components: {Logo}
    }
</script>