<template>
  <Head title="Surat" />

  <div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">
          Agenda Surat Masuk
        </h1>

        <p class="text-slate-500">
          Kelola data surat masuk
        </p>
      </div>

      <button
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl"
        @click="openCreate"
      >
        + Tambah Surat
      </button>
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
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-slate-50 border-b">
              <th>No</th>
              <th class="px-4 py-3 text-left">No Agenda</th>
              <th class="px-4 py-3 text-left">Tanggal Diterima</th>
              <th class="px-4 py-3 text-left">Asal Surat</th>
              <th class="px-4 py-3 text-left">Perihal Surat</th>
              <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="(item, index) in paginatedData"
              :key="item.id"
              class="border-b hover:bg-slate-50"
            >
              <td class="px-6 py-4">
                {{
                  (pagination.current_page - 1) * pagination.per_page +
                  index +
                  1
                }}
              </td>

              <td class="px-6 py-4">
                {{ item.nomor_agenda }}
              </td>
              <td class="px-6 py-4">
                {{ item.tanggal_diterima }}
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
                    @click="printData(item)"
                    class="px-3 py-2 rounded-lg bg-blue-100 text-blue-600"
                  >
                    <font-awesome-icon icon="print" />
                  </button>

                  <button
                    @click="openEdit(item)"
                    class="rounded bg-yellow-500 px-2 py-1 text-white"
                  >
                    Edit
                  </button>

                  <button
                    @click.prevent="deleteData(item)"
                    class="px-3 py-2 rounded-lg bg-red-100 text-red-600"
                  >
                    <font-awesome-icon icon="trash" />
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="paginatedData.length === 0">
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
    <ModalAgenda
      :show="showModal"
      :data="selectedAgenda"
      @close="showModal = false"
      @save="saveAgenda"
    />
  </div>
</template>
<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { surat } from "@/routes";
import { ref, computed, onMounted } from "vue";
import ModalAgenda from "@/components/agenda/ModalAgenda.vue";
import axios from "axios";
import { confirmDelete, errorAlert, successAlert } from "@/lib/swal";
import Swal from "sweetalert2";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "Agenda Surat Masuk",
        href: surat(),
      },
    ],
  },
});

const search = ref("");
const currentPage = ref(1);
const perPage = 10;
const selectedAgenda = ref({});
const agendas = ref([]);
const pagination = ref({});
const limit = ref(10);

const filteredData = computed(() => {
  const keyword = search.value.toLowerCase();

  return agendas.value.filter((item) => {
    return (
      item.nomor_agenda?.toLowerCase().includes(keyword) ||
      item.nomor_surat?.toLowerCase().includes(keyword) ||
      item.pengirim?.toLowerCase().includes(keyword) ||
      item.perihal?.toLowerCase().includes(keyword)
    );
  });
});


const startIndex = computed(() => (currentPage.value - 1) * perPage);

const paginatedData = computed(() => {
  return filteredData.value.slice(startIndex.value, startIndex.value + perPage);
});

const showModal = ref(false);

const saveAgenda = async (formData, id) => {
  try {
    if (id) {
      await axios.post(`/agenda/${id}`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });
    } else {
      await axios.post("/agenda/save", formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });
    }

    showModal.value = false;

    loadData();
  } catch (error) {
    console.error(error);
  }
};
const openCreate = async () => {
  try {
    const response = await axios.get("/agenda/generate-number");

    selectedAgenda.value = {
      nomor_agenda: response.data.nomor_agenda,
    };

    showModal.value = true;
  } catch (error) {
    console.error(error);
  }
};

const openEdit = (item) => {
  selectedAgenda.value = {
    ...item,
  };

  showModal.value = true;
};

const loadData = async (page = 1) => {
  try {
    const response = await axios.get("/agenda", {
      params: {
        page,
        search: search.value,
        limit: limit.value,
      },
    });

    agendas.value = response.data.data;
    pagination.value = response.data.pagination;
  } catch (error) {
    console.error(error);
  }
};

const deleteData = async (item) => {
  const result = await confirmDelete();

  if (!result.isConfirmed) {
    return;
  }

  try {
    await axios.post(`/agenda/delete/${item.id}`);

    // Refresh data tabel
    await loadData();

    await successAlert("Data berhasil dihapus");
  } catch (error) {
    console.error(error);

    await errorAlert(
      error.response?.data?.message || "Terjadi kesalahan saat menghapus data"
    );
  }
};
const changePage = (page) => {
  if (page < 1 || page > pagination.value.last_page) {
    return;
  }

  loadData(page);
};
const printData = async (item) => {
  const result = await Swal.fire({
    title: `Cetak lembar disposisi surat dengan nomor agenda ${item.nomor_agenda}?`,
    text: "Anda akan diarahkan ke halaman cetak.",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Ya, Cetak",
    cancelButtonText: "Batal",
    confirmButtonColor: "#2563eb",
  });

  if (result.isConfirmed) {
    window.open(`/arsip/print/${item.nomor_agenda}`, "_blank");
  }
};
onMounted(() => {
  loadData();
});
</script>
