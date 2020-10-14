<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileFormRequest;
use App\User;

class UserController extends Controller
{
    public function profile()
    {
        return view('site.profile.profile');
    }

    public function profileUpdate(UpdateProfileFormRequest $request)
    {
        $user = auth()->user();
        $data = $request->all();

        if ($data['password'] != null)
            $data['password'] = bcrypt($data['password']);
        else
            unset($data['password']);
        
        $data['image'] = $user->image;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($user->image)
                $name = $user->image;
            else
                $name = $user->id.trim(kebab_case($user->name));
            
            $extension = $request->image->extension();
            $nameFile = "{$name}.{$extension}";

            $data['image'] = $nameFile;

            $upload = $request->image->storeAs('users', $nameFile);

            if (!$upload)
                return redirect()
                            ->back()
                            ->with('error', 'Falha ao fazer o upload da image');
        }

        $update = $user->update($data);

        if ($update)
            return redirect()
                        ->route('profile')
                        ->with('success', 'Perfil atualizado com sucesso');
        
        return redirect()
                    ->back()
                    ->with('error', 'Falha ao atualizar o perfil...');
    }
}