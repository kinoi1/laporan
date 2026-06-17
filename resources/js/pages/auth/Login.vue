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
    <div class="grid gap-6">
      <div class="grid gap-2">
        <Label for="email" class="text-white">Email address</Label>
        <Input
          id="email"
          type="email"
          name="email"
          class="placeholder:text-white text-white"
          required
          autofocus
          :tabindex="1"
          autocomplete="email"
          placeholder="email@example.com"
        />
        <InputError :message="errors.email" />
      </div>

      <div class="grid gap-2">
        <div class="flex items-center justify-between">
          <Label for="password" class="text-white">Password</Label>
          <TextLink
            v-if="canResetPassword"
            :href="request()"
            class="text-sm text-white"
            :tabindex="5"
          >
            Forgot password?
          </TextLink>
        </div>
        <PasswordInput
          id="password"
          name="password"
          class="placeholder:text-white text-white"
          required
          :tabindex="2"
          autocomplete="current-password"
          placeholder="Password"
        />
        <InputError :message="errors.password" />
      </div>

      <div class="flex items-center justify-between">
        <Label for="remember" class="flex items-center text-white space-x-3">
          <Checkbox id="remember" name="remember" :tabindex="3" />
          <span>Remember me</span>
        </Label>
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

    <div class="text-center text-sm text-white" v-if="canRegister">
      Don't have an account?
      <TextLink :href="register()" :tabindex="5" class="text-white">Sign up</TextLink>
    </div>
  </Form>
</template>
