<template>
  <Head title="Arsip" />

  <div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">
          Arsip
        </h1>

        <p class="text-slate-500">
          Kelola data surat masuk
        </p>
      </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
      <div class="relative">
        <font-awesome-icon
          icon="search"
          class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
        />

        <input
          v-model="search"
          type="text"
          placeholder="Cari nomor surat, perihal, atau pengirim..."
          class="w-[350px] border border-slate-200 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <!-- Filter Urutan -->
      <div class="relative">
        <div>
          <font-awesome-icon
            icon="filter"
            class="absolute left-2 top-3/5 -translate-y-1/2 text-slate-400 mr-2"
          />
        </div>

        <select
          v-model="sort"
          class="border border-slate-200 rounded-xl pl-8 pr-8 py-2 mt-2 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          <option value="">Semua Data</option>
          <option value="latest">Terbaru</option>
          <option value="oldest">Terlama</option>
        </select>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-slate-50 border-b">
              <th>No</th>
              <th class="px-4 py-3 text-left">No Agenda</th>
              <th class="px-4 py-3 text-left">Asal Surat</th>
              <th class="px-4 py-3 text-left">Perihal</th>
              <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="(item, index) in data"
              :key="item.id"
              class="border-b hover:bg-slate-50"
            >
              <td class="px-6 py-4">
                {{ startIndex + index + 1 }}
              </td>

              <td class="px-6 py-4">
                {{ item.nomor_agenda }}
              </td>

              <td class="px-6 py-4">
                {{ item.pengirim }}
              </td>
              <td class="px-6 py-4">
                {{ item.perihal }}
              </td>

              <td class="px-6 py-4">
                <div class="flex justify-center gap-2">
                  <button
                    @click="openLihat(item)"
                    class="rounded bg-yellow-500 px-2 py-1 text-white"
                  >
                    <font-awesome-icon icon="eye" />
                  </button>
                  <button
                    @click="printData(item)"
                    class="px-3 py-2 rounded-lg bg-blue-100 text-blue-600"
                  >
                    <font-awesome-icon icon="print" />
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="data.length === 0">
              <td colspan="6" class="text-center py-8 text-slate-500">
                Data tidak ditemukan
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Footer -->
      <div
        class="flex flex-col md:flex-row justify-between items-center p-4 border-t"
      >
        <div class="text-sm text-slate-500 mb-3 md:mb-0">
          Menampilkan
          {{ pagination.current_page }}
          dari {{ pagination.total }}

          data
        </div>

        <div class="flex gap-2">
          <button
            :disabled="pagination.current_page === 1"
            @click="changePage(pagination.current_page - 1)"
            class="px-4 py-2 border rounded-lg disabled:opacity-50"
          >
            Previous
          </button>

          <button
            v-for="page in pagination.last_page"
            :key="page"
            @click="changePage(page)"
            :class="[
              'px-4 py-2 rounded-lg',
              page === pagination.current_page
                ? 'bg-blue-600 text-white'
                : 'border',
            ]"
          >
            {{ page }}
          </button>

          <button
            :disabled="pagination.current_page === pagination.last_page"
            @click="changePage(pagination.current_page + 1)"
            class="px-4 py-2 border rounded-lg disabled:opacity-50"
          >
            Next
          </button>
        </div>
      </div>
    </div>

    <ModalArsip
      :show="showModal"
      :data="selectedArsip"
      @close="showModal = false"
    />
  </div>
</template>

<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { arsip } from "@/routes";
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import ModalArsip from "@/components/arsip/ModalArsip.vue";
import { watchDebounced } from "@vueuse/core";
import Swal from "sweetalert2";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "Arsip",
        href: arsip(),
      },
    ],
  },
});
const data = ref([]);
const search = ref("");
const currentPage = ref(1);
const pagination = ref({});
const showModal = ref(false);
const selectedArsip = ref({});
const limit = ref(10);
const sort = ref("");

const openLihat = (item) => {
  selectedArsip.value = {
    ...item,
  };

  showModal.value = true;
};

const startIndex = computed(() => {
  return (pagination.value.current_page - 1) * pagination.value.per_page;
});

const loadData = async (page = 1) => {
  try {
    const response = await axios.get("/arsip-data", {
      params: {
        page,
        search: search.value,
        limit: limit.value,
        sort: sort.value,
      },
    });
    console.log(response);
    data.value = response.data.data;
    pagination.value = response.data.pagination;
  } catch (error) {
    console.error(error);
  }
};

const changePage = (page) => {
  if (page < 1 || page > pagination.value.last_page) {
    return;
  }
  currentPage.value = page;
  loadData(page);
};

watchDebounced(
  [search, sort],
  () => {
    console.log(sort);
    loadData();
  },
  {
    debounce: 500,
    maxWait: 1000,
  }
);

const printData = async (item) => {
  const result = await Swal.fire({
    title: `Apakah anda akan melakukan cetak gambar?`,
    text: "Anda akan diarahkan ke halaman cetak.",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Ya, Cetak",
    cancelButtonText: "Batal",
    confirmButtonColor: "#2563eb",
  });

  if (result.isConfirmed) {
    window.open(`/arsip/print-attachment/${item.id}`, "_blank");
  }
};
onMounted(() => {
  loadData();
});
</script>
