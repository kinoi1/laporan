<script setup lang="ts">
import { Form, Head, Link, usePage } from "@inertiajs/vue3";
import { computed, reactive } from "vue";
import Heading from "@/components/Heading.vue";
import { edit } from "@/routes/agenda/settings";
import { useForm } from '@inertiajs/vue3';
import AgendaSettingController from "@/actions/App/Http/Controllers/Settings/AgendaSettingController";
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

type Props = {
  mustVerifyEmail: boolean;
  status?: string;
};

defineProps<Props>();

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "Set Nomor agenda",
        href: edit(),
      },
    ],
  },
});

const page = usePage();
const user = computed(() => page.props.auth.user);


const form = useForm({
    type: 'default',
    custom_value: '',
});

</script>

<template>
  <Head title="Agenda settings" />

  <h1 class="sr-only">Profile settings</h1>

  <div class="flex flex-col space-y-6">
    <Heading
      variant="small"
      title="Profile information"
      description="Update your name and email address"
    />
  </div>
  <Form 
  v-bind="AgendaSettingController.update.form()"
  v-slot="{ errors, processing }"
  class="space-y-6">
    <!-- Select -->
    <div>
      <label
        for="type"
        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
      >
        Tipe Setting
      </label>

      <select
        id="type"
        v-model="form.type"
        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
      >
        <option value="default">Default</option>
        <option value="custom">Custom</option>
      </select>

      <p v-if="form.errors.type" class="mt-1 text-sm text-red-600">
        {{ form.errors.type }}
      </p>
    </div>

    <!-- Custom Input -->
    <div v-if="form.type === 'custom'">
      <label
        for="custom_value"
        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
      >
        Custom Value
      </label>

      <input
        id="custom_value"
        v-model="form.custom_value"
        name="custom"
        type="text"
        placeholder="Masukkan nilai custom"
        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
      />

      <p v-if="form.errors.custom_value" class="mt-1 text-sm text-red-600">
        {{ form.errors.custom_value }}
      </p>
    </div>

    <!-- Submit Button -->
    <div>
      <Button :disabled="processing"
        type="submit"
        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-50"
      >
        <svg
          v-if="form.processing"
          class="mr-2 h-4 w-4 animate-spin"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
          />
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8v8H4z"
          />
        </svg>

        Simpan
      </Button>
    </div>
  </Form>
</template>
