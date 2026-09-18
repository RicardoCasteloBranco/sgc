<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParecerTecnico;

class ParecerTecnicoController extends Controller
{
    public function visualizar($id)
    {
        $parecer = ParecerTecnico::findOrFail($id);

        return response($parecer->file_data)
        ->header('Content-Type', $parecer->mime_type)
        ->header(
            'Content-Disposition',
            'inline; filename"'.$parecer->name.'"'
        );
    }
}
