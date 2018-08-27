<template>
    <div class="form__group">
        <label class="form__label">{{ label }}</label>
        <select class="form__select" v-bind:value="value" v-on:input="$emit('input', $event.target.value)">
            <option v-for="option in options" :value="option.id">{{ option.name }}</option>
        </select>
    </div>
</template>
<script>
    export default {
        name: 'SelectDropdown',
        props: {
            label: {
                type: String,
                required: true,
            },
            value: {
                type: String,
            },
            options: {
                type: Array,
                required: true,
            }
        }
    }
</script>