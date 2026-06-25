<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
  >
    <div
      class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-lg bg-white shadow-lg"
    >
      <!-- Header -->
      <div class="flex items-center justify-between border-b px-6 py-4">
        <h3 class="text-lg font-semibold">
          {{ form.id ? "Edit Agenda Surat" : "Tambah Agenda Surat" }}
        </h3>

        <button
          @click="$emit('close')"
          class="text-gray-500 hover:text-gray-700"
        >
          ✕
        </button>
      </div>

      <!-- Body -->
      <form @submit.prevent="submitForm">
        <div class="grid grid-cols-1 gap-4 p-6 md:grid-cols-2">
          <!-- Nomor Agenda -->
          <div>
            <label class="mb-1 block text-sm font-medium">
              Nomor Agenda
            </label>
            <input
              v-model="form.nomor_agenda"
              type="text"
              readonly
              class="w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:outline-none"
              placeholder="Masukkan nomor agenda"
            />
          </div>

          <!-- Tanggal Diterima -->
          <div>
            <label class="mb-1 block text-sm font-medium">
              Tanggal Diterima
            </label>
            <input
              v-model="form.tanggal_diterima"
              type="date"
              class="w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:outline-none"
            />
          </div>

          <!-- Nomor Surat -->
          <div>
            <label class="mb-1 block text-sm font-medium">
              Nomor Surat
            </label>
            <input
              v-model="form.nomor_surat"
              type="text"
              class="w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:outline-none"
              placeholder="Masukkan nomor surat"
            />
          </div>

          <!-- Tanggal Surat -->
          <div>
            <label class="mb-1 block text-sm font-medium">
              Tanggal Surat
            </label>
            <input
              v-model="form.tanggal_surat"
              type="date"
              class="w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:outline-none"
            />
          </div>

          <!-- Perihal -->
          <div class="md:col-span-2">
            <label class="mb-1 block text-sm font-medium">
              Perihal
            </label>
            <textarea
              v-model="form.perihal"
              rows="3"
              class="w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:outline-none"
              placeholder="Masukkan perihal surat"
            ></textarea>
          </div>

          <!-- Pengirim -->
          <div class="md:col-span-2">
            <label class="mb-1 block text-sm font-medium">
              Pengirim
            </label>
            <input
              v-model="form.pengirim"
              type="text"
              class="w-full rounded-lg border px-3 py-2 focus:border-blue-500 focus:outline-none"
              placeholder="Masukkan nama pengirim"
            />
          </div>

          <!-- Attachment -->
          <div class="md:col-span-2">
            
            <FilePond
              name="attachment"
              label-idle="Tarik file ke sini atau <span class='filepond--label-action'>Pilih File</span>"
              :allow-multiple="false"
              max-file-size="10MB"
              :files="files"
              :server="server"
              credits="false"
              accepted-file-types="
                application/pdf
            "
              @updatefiles="handleUpdateFiles"
            />
            <label for="attachment"
              >Dokumen yang diterima hanya pdf. maksimal 10mb</label
            >
          </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 border-t px-6 py-4">
          <button
            type="button"
            @click="$emit('close')"
            class="rounded-lg border px-4 py-2 text-gray-700 hover:bg-gray-100"
          >
            Batal
          </button>

          <button
            type="submit"
            class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
          >
            {{ form.id ? "Update" : "Simpan" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch, ref } from "vue";
// FilePond
import vueFilePond from "vue-filepond";

// CSS
import "filepond/dist/filepond.min.css";
// import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
// Plugin
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
// import FilePondPluginImagePreview from "filepond-plugin-image-preview";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginFileValidateSize
  // FilePondPluginImagePreview
);

const attachment = ref(null);

const handleUpdateFiles = (files) => {
  attachment.value = files.length ? files[0].file : null;
  form.attachment = files.length ? files[0].file : null;
};
const form = reactive({
  nomor_agenda: "",
  tanggal_diterima: "",
  nomor_surat: "",
  tanggal_surat: "",
  perihal: "",
  pengirim: "",
  attachment: null,
});
const props = defineProps({
  show: Boolean,
  data: {
    type: Object,
    default: () => ({}),
  },
});
const files = ref([]);
const server = {
  load: (source, load, error) => {
    window
      .fetch(source)
      .then((response) => response.blob())
      .then(load)
      .catch(error);
  },
};
watch(
  () => props.data,
  (value) => {
    console.log("props.data", value);
    console.log(value);
    form.id = value?.id ?? null;
    form.nomor_agenda = value?.nomor_agenda ?? "";
    form.tanggal_diterima = value?.tanggal_diterima ?? "";
    form.nomor_surat = value?.nomor_surat ?? "";
    form.tanggal_surat = value?.tanggal_surat ?? "";
    form.perihal = value?.perihal ?? "";
    form.pengirim = value?.pengirim ?? "";
    files.value = value?.attachment_url
      ? [
          {
            source: value.attachment_url,
            options: {
              type: "local",
            },
          },
        ]
      : [];
    // form.attachment = value?.attachment_url ?? null;
    // attachment.value = value?.attachment ?? null;
  },
  { immediate: true }
);

const emit = defineEmits(["close", "save"]);

const handleFile = (event) => {
  form.attachment = event.target.files[0];
};

const submitForm = () => {
  const formData = new FormData();
  console.log(form);
  formData.append("nomor_agenda", form.nomor_agenda);
  formData.append("tanggal_diterima", form.tanggal_diterima);
  formData.append("nomor_surat", form.nomor_surat);
  formData.append("tanggal_surat", form.tanggal_surat);
  formData.append("perihal", form.perihal);
  formData.append("pengirim", form.pengirim);

  if (form.attachment) {
    formData.append("attachment", form.attachment);
  }
  emit("save", formData, form.nomor_agenda);
};
</script>
