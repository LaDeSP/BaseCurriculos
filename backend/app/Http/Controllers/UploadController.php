<?php

namespace App\Http\Controllers;

use Response;

use Illuminate\Http\Request;
use App\Upload; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function storeFoto(Request $request, $categoria, $id){
        $validator = Validator::make($request->all(), UploadController::rulesFotos(), UploadController::messages());
        if ($validator->fails()) {
            return Response::json([
                'error' => $validator->messages()
            ], 201);
        }
        if (Upload::where('fisicas_id',  auth()->user()->id)->exists()){
            return Response::json([
                'error' => 'Já tem foto'
            ], 201);
        }

       
        $files[] = $request->file('file');
        
        UploadController::saveFileInDatabase($files, $categoria, $id);
        
        
        return Response::json([
            'message'=>'Sucesso'
           ], 200);
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
            'file' => 'required|image'
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
