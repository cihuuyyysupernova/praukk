<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Report;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $reports;

    /**
     * Konstruktor untuk menerima data laporan
     * @param \Illuminate\Support\Collection $reports
     */
    public function __construct($reports = null)
    {
        $this->reports = $reports ?: Report::with('user')->get();
    }

    /**
     * Mengembalikan header kolom Excel
     * Return: Array header kolom
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelapor',
            'Email Pelapor',
            'Kategori',
            'Judul Laporan',
            'Deskripsi',
            'Lokasi',
            'Status',
            'Tanggal Dibuat',
            'Tanggal Diperbarui'
        ];
    }

    /**
     * Mapping data untuk setiap baris Excel
     * @param mixed $report
     * Return: Array data yang sudah diformat
     */
    public function map($report): array
    {
        return [
            $report->id,
            $report->user->name,
            $report->user->email,
            $this->getCategoryLabel($report->category),
            $report->title,
            $report->description,
            $report->location,
            $this->getStatusLabel($report->status),
            $report->created_at->format('d/m/Y H:i'),
            $report->updated_at->format('d/m/Y H:i')
        ];
    }

    /**
     * Mengembalikan koleksi data laporan
     * Return: Collection data laporan
     */
    public function collection()
    {
        return $this->reports;
    }

    /**
     * Mengubah kode kategori menjadi label
     * @param string $category
     * Return: String label kategori
     */
    private function getCategoryLabel($category)
    {
        $categories = [
            'infrastruktur' => 'Infrastruktur',
            'akademik' => 'Akademik',
            'sarana' => 'Sarana & Prasarana',
            'layanan' => 'Layanan',
            'lainnya' => 'Lainnya'
        ];

        return $categories[$category] ?? $category;
    }

    /**
     * Mengubah kode status menjadi label
     * @param string $status
     * Return: String label status
     */
    private function getStatusLabel($status)
    {
        $statuses = [
            'pending' => 'Menunggu',
            'proses' => 'Diproses',
            'selesai' => 'Selesai',
            'tolak' => 'Ditolak'
        ];

        return $statuses[$status] ?? $status;
    }
}
