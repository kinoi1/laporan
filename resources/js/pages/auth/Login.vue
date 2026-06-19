<script setup lang="ts">
import { Form, Head } from "@inertiajs/vue3";
import InputError from "@/components/InputError.vue";
import PasswordInput from "@/components/PasswordInput.vue";
import TextLink from "@/components/TextLink.vue";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Spinner } from "@/components/ui/spinner";
import { register } from "@/routes";
import { store } from "@/routes/login";
import { request } from "@/routes/password";

defineOptions({
  layout: {
    title: "PENCATATAN AGENDA SURAT MASUK",
    description: "Tim Kerja Bidang Kepegawaian Politeknik Negeri Bandung",
  },
});

defineProps<{
  status?: string;
  canResetPassword: boolean;
  canRegister: boolean;
}>();
</script>

<template>
  <Head title="PENCATATAN AGENDA SURAT MASUK" />

  <div
    v-if="status"
    class="mb-4 text-center text-sm font-medium text-green-600"
  >
    {{ status }}
  </div>

  <Form
    v-bind="store.form()"
    :reset-on-success="['password']"
    v-slot="{ errors, processing }"
    class="flex flex-col gap-6"
  >
  <div class="flex flex-col gap-2 pt-6 border-t-sky-600 border-t-2 border-x-none border-b-none">
    <span class="font-medium">SELAMAT DATANG!</span>
    <span class="text-xs">Silakan masukkan Email dan Password</span>
  </div>
    <div class="grid gap-6">
      <div class="grid gap-2">
        <Label for="email" class="text-gray-900">Email address</Label>
        <Input
          id="email"
          type="email"
          name="email"
          class="placeholder:text-gray-900 text-gray-900"
          required
          autofocus
          :tabindex="1"
          autocomplete="email"
          placeholder="email@example.com"
        />
        <InputError :message="errors.email ? 'Username atau password yang Anda masukkan salah.' : ''" />
      </div>

      <div class="grid gap-2">
        <Label for="password" class="text-gray-900">Password</Label>

        <PasswordInput
          id="password"
          name="password"
          class="placeholder:text-gray-900 text-gray-900"
          required
          :tabindex="2"
          autocomplete="current-password"
          placeholder="Password"
        />
        <InputError :message="errors.password ? 'Username atau password yang Anda masukkan salah.' : ''"
 />
      </div>

      <Button
        type="submit"
        class="mt-4 w-full bg-green-500"
        :tabindex="4"
        :disabled="processing"
        data-test="login-button"
      >
        <Spinner v-if="processing" />
        Log in
      </Button>
    </div>

  </Form>
</template>
