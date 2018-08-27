<template>
    <div class="form__group">
        <label class="form__label">{{label}}</label>
        <input class="form__input" type="text" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" />
    </div>
</template>
<script>
    export default {
        name: 'TextInput',
        props: {
            value: String,
            label: String
        }
    }
</script>