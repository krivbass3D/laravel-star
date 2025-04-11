<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    },
    type: {
        type: String,
        default: 'text'
    },
    id: {
        type: String,
        required: true
    },
    class: {
        type: String,
        default: ''
    },
    required: {
        type: Boolean,
        default: false
    },
    autocomplete: {
        type: String,
        default: ''
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        :type="type"
        :id="id"
        :class="class"
        :value="modelValue"
        :required="required"
        :autocomplete="autocomplete"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
</template>
