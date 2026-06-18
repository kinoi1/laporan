<script setup>
import { onMounted } from "vue";
defineOptions({
    layout: null,
});

const props = defineProps({
    agenda: Object,
});

onMounted(() => {
    setTimeout(() => {
        window.print();
    }, 500);
});
</script>

<template>
    <div class="print-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <img
                    src="/logo/logo-polban.png"
                    alt="Logo"
                    class="w-20"
                />
            </div>

            <div class="header-text">
                <h4>Kementerian Pendidikan Tinggi, Sains, dan Teknologi</h4>
                <h1>Politeknik Negeri Bandung</h1>
                <h2>Tim Kerja Bidang Kepegawaian</h2>

                <p>
                    Jln. Gegerkalong Hilir, Ds. Ciwaruga, Bandung 40012,
                    Kotak Pos 1234, Telp (022) 2013789
                </p>

                <p>
                    Homepage : www.polban.ac.id Email : polban@polban.ac.id
                </p>
            </div>
        </div>

        <!-- Judul -->
        <div class="title-section">
            <h1>Lembar Disposisi</h1>

            <div class="priority">
                <label><input type="checkbox" /> Rahasia</label>
                <label><input type="checkbox" /> Batas</label>
                <label><input type="checkbox" /> Biasa</label>
                <label><input type="checkbox" /> Segera</label>
                <label><input type="checkbox" /> Sangat Segera</label>
            </div>
        </div>

        <!-- Informasi Surat -->
        <div class="info-section">
            <table>
                <tbody>
                    <tr>
                        <td>No. Agenda</td>
                        <td>: {{ agenda.no_agenda }}</td>
                    </tr>

                    <tr>
                        <td>Tgl. Diterima</td>
                        <td>: {{ agenda.tanggal_diterima }}</td>
                    </tr>

                    <tr>
                        <td>No. Surat</td>
                        <td>: {{ agenda.no_surat }}</td>
                    </tr>

                    <tr>
                        <td>Tanggal Surat</td>
                        <td>: {{ agenda.tanggal_surat }}</td>
                    </tr>

                    <tr>
                        <td>Asal Surat</td>
                        <td>: {{ agenda.pengirim }}</td>
                    </tr>

                    <tr>
                        <td>Perihal Surat</td>
                        <td>: {{ agenda.perihal }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Diteruskan -->
        <div class="forward-section">
            <div>
                <input type="checkbox" />
                Diteruskan Kepada :
            </div>

            <div class="forward-list">
                ..................................
                <br />
                ..................................
                <br />
                ..................................
            </div>
        </div>

        <!-- Isi Disposisi -->
        <div class="disposisi-section">
            <h3>Isi Disposisi :</h3>

            <div class="disposisi-content">
                {{ agenda.disposisi }}
            </div>
        </div>

        <!-- TTD -->
        <div class="signature">
            <p>
                Bandung,
                ...........................................
            </p>

            <div class="signature-name">
                <strong>
                    Yanny Christiany, S.H., M.Kn.
                </strong>
            </div>
        </div>
    </div>
</template>

<style scoped>
.print-container {
    width: 210mm;
    min-height: 297mm;
    margin: auto;
    background: white;
    border: 1px solid #000;
    font-family: Arial, sans-serif;
}

.header {
    display: flex;
    border-bottom: 1px solid black;
    padding: 15px;
}

.logo {
    width: 100px;
}

.header-text {
    flex: 1;
    text-align: center;
}

.header-text h1 {
    font-size: 32px;
    font-weight: bold;
}

.header-text h2 {
    font-size: 22px;
    font-weight: bold;
}

.title-section {
    border-bottom: 1px solid black;
    padding: 20px;
    text-align: center;
}

.title-section h1 {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
}

.priority {
    display: flex;
    justify-content: space-around;
}

.info-section {
    border-bottom: 1px solid black;
    padding: 20px;
}

.info-section table {
    width: 100%;
}

.info-section td {
    font-size: 22px;
    padding: 6px;
}

.info-section td:first-child {
    width: 220px;
    font-weight: bold;
}

.forward-section {
    border-bottom: 1px solid black;
    padding: 20px;
    min-height: 120px;
}

.forward-list {
    margin-left: 100px;
    margin-top: 10px;
    line-height: 35px;
}

.disposisi-section {
    padding: 20px;
    min-height: 550px;
}

.disposisi-section h3 {
    font-size: 24px;
    font-weight: bold;
}

.disposisi-content {
    margin-top: 20px;
    white-space: pre-line;
}

.signature {
    text-align: center;
    margin-top: 180px;
    margin-bottom: 50px;
}

.signature-name {
    margin-top: 150px;
    font-size: 22px;
}

@media print {
    body {
        margin: 0;
        padding: 0;
    }

    .print-container {
        border: none;
        width: 100%;
        min-height: auto;
    }
}
</style>