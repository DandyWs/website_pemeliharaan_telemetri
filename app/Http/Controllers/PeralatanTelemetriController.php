<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\JenisPeralatan;
use App\Models\PeralatanTelemetri;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PeralatanTelemetriStoreRequest;
use App\Http\Requests\PeralatanTelemetriUpdateRequest;

class PeralatanTelemetriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', PeralatanTelemetri::class);

        $search = $request->get('search', '');

        $peralatanTelemetris = PeralatanTelemetri::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.peralatan_telemetris.index',
            compact('peralatanTelemetris', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', PeralatanTelemetri::class);

        $jenisPeralatans = JenisPeralatan::pluck('namaJenisAlat', 'id');

        return view(
            'app.peralatan_telemetris.create',
            compact('jenisPeralatans')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        PeralatanTelemetriStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', PeralatanTelemetri::class);

        $validated = $request->validated();

        $peralatanTelemetri = PeralatanTelemetri::create($validated);

        return redirect()
            ->route('peralatan-telemetris.edit', $peralatanTelemetri)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        PeralatanTelemetri $peralatanTelemetri
    ): View {
        $this->authorize('view', $peralatanTelemetri);

        return view(
            'app.peralatan_telemetris.show',
            compact('peralatanTelemetri')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        PeralatanTelemetri $peralatanTelemetri
    ): View {
        $this->authorize('update', $peralatanTelemetri);

        $jenisPeralatans = JenisPeralatan::pluck('namaJenisAlat', 'id');

        return view(
            'app.peralatan_telemetris.edit',
            compact('peralatanTelemetri', 'jenisPeralatans')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PeralatanTelemetriUpdateRequest $request,
        PeralatanTelemetri $peralatanTelemetri
    ): RedirectResponse {
        $this->authorize('update', $peralatanTelemetri);

        $validated = $request->validated();

        $peralatanTelemetri->update($validated);

        return redirect()
            ->route('peralatan-telemetris.edit', $peralatanTelemetri)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        PeralatanTelemetri $peralatanTelemetri
    ): RedirectResponse {
        $this->authorize('delete', $peralatanTelemetri);

        $peralatanTelemetri->delete();

        return redirect()
            ->route('peralatan-telemetris.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
