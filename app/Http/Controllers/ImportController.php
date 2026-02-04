<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Importers\MarcImporter;
use App\Services\Importers\RisImporter;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function importMarc(Request $request, MarcImporter $importer)
    {
        $validated = $request->validate([
            'record' => ['required', 'array'],
        ]);

        $book = $importer->import($validated['record']);

        return response()->json($book->load(['authors', 'subjects', 'publisher']));
    }

    public function importRis(Request $request, RisImporter $importer)
    {
        $validated = $request->validate([
            'record' => ['required', 'array'],
        ]);

        $article = $importer->import($validated['record']);

        return response()->json($article->load(['authors', 'subjects']));
    }
}
