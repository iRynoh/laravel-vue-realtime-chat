<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    rooms: Array,
})
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div v-for="room in props.rooms"
                                 class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow transition hover:shadow-lg"
                            >
                                <div class="p-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ room.title }}
                                        </h3>
                                        <Link
                                            :href="route('room.show', room.slug)"
                                            class="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-indigo-500"
                                        >
                                            Join
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
