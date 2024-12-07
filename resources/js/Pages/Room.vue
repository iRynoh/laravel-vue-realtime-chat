<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import ChatTextArea from '@/Components/Chat/ChatTextArea.vue';
import {useMessagesStore} from '@/Store/useMessagesStore.js';
import ChatMessages from "@/Components/Chat/ChatMessages.vue";

const props = defineProps({
    room: Object,
});

const messagesStore = useMessagesStore();

messagesStore.fetchState(props.room.slug);

const storeMessage = (payload) => {
    messagesStore.storeMessage(props.room.slug, payload)
}

</script>

<template>
    <Head title="Room"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                {{ room.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-12 gap-6">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg col-span-3"
                >
                    <div class="p-6 text-gray-900">
                        Users online
                    </div>
                </div>
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg col-span-9"
                >
                    <div class="p-6 text-gray-900 space-y-3">
                        <ChatMessages :room="room" />
                        <ChatTextArea
                            class="w-full"
                            v-on:valid="storeMessage({ body: $event })"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
