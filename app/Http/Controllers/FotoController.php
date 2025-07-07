<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class FotoController extends Controller
{
    public function destroy($id)
    {
        $foto = \App\Models\Foto::findOrFail($id);
        // Remove o arquivo do storage
        Storage::disk('public')->delete($foto->caminho);
        $foto->delete();
        return response()->json(['success' => true]);
    }
    public function definirCapa($id)
    {
        $foto = \App\Models\Foto::findOrFail($id);
        // Remove a capa das outras fotos do mesmo veículo
        \App\Models\Foto::where('veiculo_id', $foto->veiculo_id)->update(['capa' => false]);
        // Define a capa para a foto clicada
        $foto->capa = true;
        $foto->save();

        return response()->json(['success' => true]);
    }
}
