<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;


use Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\User;


class AuthController extends Controller
{
    use SendsPasswordResetEmails, ResetsPasswords {
        SendsPasswordResetEmails::broker insteadof ResetsPasswords;
        ResetsPasswords::credentials insteadof SendsPasswordResetEmails;
    }

    public function sendPasswordResetLink(Request $request)
    {
        if(!User::where('email', $request->email)->exists()){
            return response()->json([
                'errorEmail' => ['Email não cadastrado no nosso sistema.'],
            ]);
        }
        
        return $this->sendResetLinkEmail($request);
    }

    protected function sendResetLinkResponse($response)
    {
        return response()->json([
            'message' => ['Email de recuperação de senha enviado com sucesso!'],
            'data' => $response
        ]);
    }
    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => ['O email não pôde ser enviado para esse endereço de email.']]);
    }
    
    public function callResetPassword(Request $request)
    {
        return $this->reset($request);
    }
    
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
    }

    protected function sendResetResponse($response)
    {
        return response()->json(['message' => ['Senha atualizada com sucesso!']]);
    }
    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => ['Token inválido - Email incorreto.']]);
    }
}