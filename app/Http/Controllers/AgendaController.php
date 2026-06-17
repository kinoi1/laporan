<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_agenda' => 'required|max:255|unique:agendas',
            'tanggal_diterima' => 'required|date',
            'nomor_surat' => 'required|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'pengirim' => 'required|max:255',
            'attachment' => 'nullable|file|mimes:pdf|max:10024'
        ]);

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request
                ->file('attachment')
                ->store('agenda', 'public');
        }

        $agenda = Agenda::create([
            'nomor_agenda' => $validated['nomor_agenda'],
            'tanggal_diterima' => $validated['tanggal_diterima'],
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'perihal' => $validated['perihal'],
            'pengirim' => $validated['pengirim'],
            'attachment' => $attachmentPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil disimpan',
            'data' => $agenda
        ]);
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'nomor_agenda' => 'required|unique:agendas,nomor_agenda,' . $agenda->id,
            'tanggal_diterima' => 'required|date',
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'pengirim' => 'required',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
        ]);

        if ($request->hasFile('attachment')) {

            if ($agenda->attachment) {
                \Storage::disk('public')->delete($agenda->attachment);
            }

            $validated['attachment'] = $request
                ->file('attachment')
                ->store('agenda', 'public');
        }

        $agenda->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil diperbarui'
        ]);
    }

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
        $data = $query
            ->orderBy('tanggal_diterima', 'desc')
            ->paginate($request->input('limit', 10));

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

    public function generateNomorAgenda()
    {
        $year = Carbon::now()->year;

        $count = Agenda::whereYear('tanggal_diterima', $year)->count();

        return response()->json([
            'nomor_agenda' => $count + 1
        ]);
    }
    public function destroy($id)
    {
        Agenda::findOrFail($id)->delete();

        return redirect()->back()->with(
            'success',
            'Data agenda berhasil dihapus'
        );
    }
}
