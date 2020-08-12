<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

use App\User;
class Vaga extends Model
{
	use SoftDeletes, SoftCascadeTrait;

	protected $fillable = [
		'titulo', 'cargo', 'salario', 'beneficio', 'jornada',
		'requisito', 'juridicas_id', 'areas_id', 'quantidade', 'status', 'descricao'
	];

	public function candidatura(){
		return $this->hasMany(Candidatura::class, 'vagas_id');
	}

    public function area(){
    	return $this->belongsTo(Area::class, 'areas_id');
	}

    public function juridica(){
    	return $this->belongsTo(Juridica::class, 'juridicas_id');
	}

	public function candidaturaContratada(){
		return $this->hasMany(Candidatura::class, 'vagas_id')->where('status', 'CONTRATADO');
	}

	public function myCandidatura(){
		$user_id = auth()->user()->id;
		$user = User::with(['fisica.curriculo'])->findOrFail($user_id);
		$curriculo = $user->fisica->curriculo;
	
		
		return $this->hasOne(Candidatura::class, 'vagas_id')->where(function ($query) {
            $query->where('status', "EM AGENDAMENTO")
                  ->orWhere('status', "AGUARDANDO")
                  ->orWhere('status', "ENTREVISTA CONFIRMADA")
                  ->orWhere('status', "CONTRATADO");
		})
		->where('curriculos_id', $curriculo->id);
	}

	public function convite(){
		return $this->hasMany(Convite::class, 'vagas_id');
	}

	public function myConvite(){
		$user_id = auth()->user()->id;
		$user = User::with(['fisica.curriculo'])->findOrFail($user_id);
		$curriculo = $user->fisica->curriculo;
	
		
		return $this->hasOne(Convite::class, 'vagas_id')->where('curriculos_id', $curriculo->id);
	}
}