<template>
  <Head title="Dashboard" />
  <div class="min-h-screen bg-slate-50 p-6">
    <!-- Header -->
    <div class="flex items-start justify-between mb-8">
      <div>
        <h3 class="text-2xl text-slate-600 mb-1">
          Selamat Datang,
        </h3>

        <h1 class="text-4xl font-bold text-slate-800">
          Admin Tim Kerja Bidang Kepegawaian dan Tata Laksana
        </h1>
      </div>

      
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
      <!-- Card 1 -->
      <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center">
          <div
            class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl"
          >
            <i class="bi bi-file-earmark-text"></i>
          </div>

          <div class="ml-4">
            <p class="text-slate-500 text-sm">
              Total Surat Masuk
            </p>

            <h2 class="text-4xl font-bold text-blue-500">
              {{ statistik.tertinggi?.total ?? 0 }}
            </h2>

            <p class="text-slate-400 text-sm">
              Tahun {{ statistik.tertinggi?.tahun ?? "" }}
            </p>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center">
          <div
            class="w-16 h-16 rounded-full bg-green-500 flex items-center justify-center text-white text-2xl"
          >
            <i class="bi bi-graph-up-arrow"></i>
          </div>

          <div class="ml-4">
            <p class="text-slate-500 text-sm">
              Rata-rata / Bulan
            </p>

            <h2 class="text-4xl font-bold text-green-500">
              {{ Number(statistik.rata_rata ?? 0).toFixed(1) }}
            </h2>

            <p class="text-slate-400 text-sm">
              Surat
            </p>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center">
          <div
            class="w-16 h-16 rounded-full bg-purple-500 flex items-center justify-center text-white text-2xl"
          >
            <i class="bi bi-calendar-event"></i>
          </div>

          <div class="ml-4">
            <p class="text-slate-500 text-sm">
              Bulan Tertinggi
            </p>

            <h2 class="text-4xl font-bold text-purple-500">
              {{ statistik.tertinggi?.total ?? "" }}
            </h2>

            <p class="text-slate-400 text-sm">
              {{ namaBulan(statistik.tertinggi?.bulan) }}
            </p>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center">
          <div
            class="w-16 h-16 rounded-full bg-amber-500 flex items-center justify-center text-white text-2xl"
          >
            <i class="bi bi-calendar-x"></i>
          </div>

          <div class="ml-4">
            <p class="text-slate-500 text-sm">
              Bulan Terendah
            </p>

            <h2 class="text-4xl font-bold text-amber-500">
              {{ statistik.tertinggi?.total ?? "" }}
            </h2>

            <p class="text-slate-400 text-sm">
              {{ namaBulan(statistik.terendah?.bulan) }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm p-6">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-slate-800">
          Statistik Agenda Surat Masuk Tahun 2026
        </h2>

        <select class="border border-slate-200 rounded-xl px-4 py-2">
          <option>2026</option>
          <option>2025</option>
        </select>
      </div>

      <div class="h-[400px]">
        <canvas ref="chartCanvas"></canvas>
      </div>

      <div
        class="mt-6 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-500"
      >
        Data diperbarui secara otomatis setiap kali ada penambahan agenda surat
        masuk baru.
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { dashboard } from "@/routes";
import { onMounted, ref } from "vue";
import Chart from "chart.js/auto";
import axios from "axios";

const namaBulan = (bulan) => {
  const bulanIndonesia = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];

  return bulanIndonesia[bulan - 1] || "-";
};

const statistik = ref({
  total: 0,
  tertinggi: null,
  terendah: null,
  rata_rata: 0,
  chart: null,
});

const loadStatistik = async () => {
  try {
    const response = await axios.get("/dashboard-data");

    statistik.value = response.data;
  } catch (error) {
    console.error(error);
  }
};

const chartCanvas = ref(null);
defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "Dashboard",
        href: dashboard(),
      },
    ],
  },
});

const statistics = [
  {
    title: "Total Surat Masuk",
    value: "578",
    subtitle: "Tahun 2026",
    icon: "bi-file-earmark-text",
    color: "blue",
  },
  {
    title: "Rata-rata / Bulan",
    value: "48,17",
    subtitle: "Surat",
    icon: "bi-graph-up-arrow",
    color: "green",
  },
  {
    title: "Bulan Tertinggi",
    value: "80",
    subtitle: "Oktober",
    icon: "bi-calendar-event",
    color: "purple",
  },
  {
    title: "Bulan Terendah",
    value: "20",
    subtitle: "Agustus",
    icon: "bi-calendar-x",
    color: "amber",
  },
];

onMounted(async () => {
  await loadStatistik();

  console.log(statistik.value.chart);

  new Chart(chartCanvas.value, {
    type: "bar",
    data: {
      labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "Mei",
        "Jun",
        "Jul",
        "Ags",
        "Sep",
        "Okt",
        "Nov",
        "Des",
      ],
      datasets: [
        {
          data: statistik.value.chart,
          borderRadius: 12,
          backgroundColor: [
            "#3B82F6",
            "#8B5CF6",
            "#F59E0B",
            "#FACC15",
            "#FB7185",
            "#EC4899",
            "#06B6D4",
            "#22C55E",
            "#84CC16",
            "#A3A300",
            "#F59E0B",
            "#FDBA74",
          ],
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          grid: {
            display: false,
          },
        },
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 20,
          },
        },
      },
    },
  });
});
</script>
