<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_agenda', 'like', "%{$search}%")
                    ->orWhere('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('pengirim', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        if ($request->sort === 'latest') {
            $query->orderBy('tanggal_diterima', 'desc');
        } elseif ($request->sort === 'oldest') {
            $query->orderBy('tanggal_diterima', 'asc');
        }

        $data = $query->paginate(
            $request->input('limit', 10)
        );

        $data->getCollection()->transform(function ($item) {
            $item->attachment_url = $item->attachment
                ? Storage::url($item->attachment)
                : null;

            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ]
        ]);
    }
    public function print(Agenda $agenda)
    {
        return view('agenda.print-disposisi', compact('agenda'));
    }

    public function printAttachment(Agenda $agenda)
    {
        return view('agenda.print-attachment', compact('agenda'));
    }
}
