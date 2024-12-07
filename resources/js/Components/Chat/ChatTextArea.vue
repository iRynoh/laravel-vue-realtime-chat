<script setup>

import {ref} from "vue";

const emit = defineEmits(['valid', 'typing']);
const model = ref('');

/**
 * We want to be able to emit valid on Enter key if any valid message
 * is present. Shift+Enter is used to create a linebreak.
 * @param event
 */
const handleEnter = (event) => {
    const isShiftPressed = event.shiftKey;
    const message = model.value.trim();
    if (isShiftPressed && message.length) {
        model.value += '\n';
        return;
    }

    if (message.length) {
        emit('valid', message);
        model.value = '';
        handleFinishedTyping();
    }
}

let typingTimeout = null;

/**
 * Handle typing event with 3 seconds timeout.
 */
const handleTyping = () => {
    clearTimeout(typingTimeout);

    emit('typing', true);

    typingTimeout = setTimeout(handleFinishedTyping, 3000);
}

const handleFinishedTyping = () => {
    clearTimeout(typingTimeout);

    emit('typing', false);
}

</script>

<template>
    <textarea
        rows="4"
        id="body"
        class="rounded-md border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        placeholder="Say Something..."
        v-model="model"
        @keydown="handleTyping"
        @keydown.enter.prevent="handleEnter($event)"/>
</template>
