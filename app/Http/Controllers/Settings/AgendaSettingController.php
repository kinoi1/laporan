<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AgendaSettingController extends Controller
{
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Agenda', [
            'tes' => 'gefe',
            'status' => 'fff',
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        Settings::updateOrCreate(
            ['key' => 'agenda_prefix'],
            ['value' => $request->custom]
        );


        Inertia::flash('toast', ['type' => 'success', 'message' => __('Agenda updated.')]);

        return to_route('agenda.settings.edit');
    }
}
