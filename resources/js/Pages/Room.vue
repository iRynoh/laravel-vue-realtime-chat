<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    room: Object,
});

</script>

<template>
    <Head title="Room" />

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
                    <div class="p-6 text-gray-900">
                        Messages
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
