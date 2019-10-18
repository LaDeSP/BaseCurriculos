<div class="container d-flex justify-content-center">
    <div class="col">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span class="badge badge-danger badge-pill">
                    {{ $error }}
                </span>
            @endforeach
        @endif
        @if( \Session::has('error') )
            @foreach(session()->get('error') as $key => $ms)
                <span id="{{ $key }}error" class="badge badge-danger badge-pill">
                    {{ $ms }}
                    <a id="excluir" onClick="excluirElement('{{ $key }}error')"></a>
                </span>
            @endforeach
        @endif
        @if( \Session::has('message') )
            <span id="success" class="badge badge-success badge-pill">
                {{ \Session::get('message') }}
                    <a id="excluir" onClick="excluirElement('success')"></a>
            </span>
        @endif
    </div>
</div>
<div class="container bg-black border-radius">
    <h2 class="d-flex justify-content-center text-white text-white">Adicionar Foto</h2>
    <hr>
    <div class="col-lg-12 d-flex justify-content-center">
        <form id="delete-form" method="POST" action="{{ route('fotos.store', ['categoria'=>'users_id', 'id'=>'1']) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="fotos">Fotos <a class="required">*</a></label>
                <input type="file" aria-label="file" id="file" name="file" class="form-control" accept="image/x-png, image/gif, image/jpeg, image/jpg" required/>
                <small id="fotosHelp" class="form-text text-muted">Arquivos nos formatos: gif, png, jpg e jpeg.</small>
            </div>
            <div class="d-flex justify-content-center" id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Adicionar </button>
            </div>
        </form>
    </div>
</div>

<div class="container bg-black border-radius">
    <h2 class="d-flex justify-content-center text-white text-white">Adicionar Arquivos</h2>
    <hr>
    <div class="col-lg-12 d-flex justify-content-center">
        <form id="delete-form" method="POST" action="{{ route('arquivos.store', ['categoria'=>'curriculos_id', 'id'=>'2']) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="fotos">Arquivos <a class="required">*</a></label>
                <input type="file" aria-label="foto" id="foto" name="arquivos[]" class="form-control" accept="application/pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, .doc" multiple required/>
                <small id="fotosHelp" class="form-text text-muted">Arquivos nos formatos: pdf, xls, doc.</small>
            </div>
            <div class="d-flex justify-content-center" id="formFooter">
                <button type="submit" id="submit" class="fadeIn fourth btn btn-primary"> Adicionar </button>
            </div>
        </form>
    </div>
</div>