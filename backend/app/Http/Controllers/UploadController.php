<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upload; 
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function storeFoto(Request $request, $categoria, $id){
        $validator = Validator::make($request->all(), UploadController::rulesFotos(), UploadController::messages());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
       
        $files[] = $request->file('foto');
        
        UploadController::saveFileInDatabase($files, $categoria, $id);
        
        
        return redirect()->back()->with('message', 'Sucesso ao adicionar foto!');
    }

    public function storeArquivo(Request $request, $categoria, $id){
        $validator = Validator::make($request->all(), UploadController::rulesArquivos(), UploadController::messages());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        
        $files = $request->file('arquivos');
    
        UploadController::saveFileInDatabase($files, $categoria, $id);
        
        
        return redirect()->back()->with('message', 'Sucesso ao adicionar arquivo!');
    }

    public function saveFileInDatabase($files, $categoria, $id){
        foreach($files as $file){
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $without_extension = basename($filename, ".$extension");

            
            $filename = $file->store('fotos');
            Upload::create([
                $categoria => $id,
                'mime' => $extension,
                'filename' => $without_extension,
                'path' => $filename
            ]);
                
        }
        return;
    }

    public function rulesFotos(){
        return [
            'fotos' => 'image'
        ];
    }

    public function rulesArquivos(){
        return [
            'arquivos' => 'required',
            'arquivos.*' => 'mimes:doc,pdf,xls'

        ];
    }

    public function messages(){
        return [
            'fotos.image' => 'O campo Fotos deve conter apenas imagens.',
            'arquivos.required' => 'Um arquivo deve ser inserido.',
            'arquivos.*.mimes' => 'Arquivos aceitos apenas nos formatos: doc, psf e xls.'
        ];
    }
}
