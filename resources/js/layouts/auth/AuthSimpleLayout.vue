<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-svh flex-col items-center justify-center gap-6 bg-background p-6 md:p-10"
        style="background-image: url('/bg.webp')"
    >
        <div class="w-full max-w-md bg-white p-8 rounded-3xl">
            <div class="flex flex-col gap-8">
                <div class="flex flex-row items-center gap-2">
                    <Link
                        :href="home()"
                        class="flex flex-col items-center gap-2 font-medium"
                    >
                        <div
                            class="flex h-9 w-9 items-center justify-center"
                        >
                            <AppLogoIcon
                                class="fill-current text-gray-900 dark:text-gray-900"
                            />
                        </div>
                        <span class="sr-only">{{ title }}</span>
                    </Link>
                    <div class="">
                        <h1 class="text-gray-800 text-sm font-bold">{{ title }}</h1>
                        <p class="text-sky-900 text-xs font-semibold text-nowrap">
                            {{ description }}
                        </p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
