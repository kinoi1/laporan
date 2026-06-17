<?php

namespace Database\Factories;

use App\Models\Agenda;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Agenda>
 */
class AgendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggalSurat = $this->faker->dateTimeBetween('-3 months', 'now');
        $tanggalDiterima = (clone $tanggalSurat)->modify('+' . rand(0, 7) . ' days');

        return [
            'nomor_agenda' => (string) $this->faker->unique()->numberBetween(1, 99999),

            'tanggal_diterima' => $tanggalDiterima->format('Y-m-d'),

            'nomor_surat' => sprintf(
                '%03d/%s/%s/%s',
                rand(1, 999),
                strtoupper($this->faker->lexify('???')),
                rand(1, 12),
                date('Y')
            ),

            'tanggal_surat' => $tanggalSurat->format('Y-m-d'),

            'perihal' => $this->faker->randomElement([
                'Undangan Rapat Koordinasi',
                'Permohonan Data Akademik',
                'Pemberitahuan Kegiatan Mahasiswa',
                'Permintaan Narasumber Seminar',
                'Laporan Pelaksanaan Kegiatan',
                'Permohonan Kerja Sama',
                'Undangan Sosialisasi Program',
                'Penyampaian Informasi Penting',
                'Permohonan Izin Kegiatan',
                'Pengajuan Proposal Kegiatan',
            ]),

            'pengirim' => $this->faker->randomElement([
                'Universitas Indonesia',
                'Institut Teknologi Bandung',
                'Universitas Padjadjaran',
                'Universitas Terbuka',
                'Dinas Pendidikan Jawa Barat',
                'Kementerian Pendidikan',
                'Badan Kepegawaian Negara',
                'Pemerintah Kabupaten Subang',
                'PT Teknologi Nusantara',
                'CV Maju Bersama',
            ]),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
