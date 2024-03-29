<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\People;
use App\Shared\Log;
use App\Shared\ProfileID;
use Illuminate\Support\Facades\DB;
use Exception;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $post = $request->all();
        if ($post) {
            $post    = (object) $post;
            $user = User::where('username', str_replace(" ", "", $post->username))
                ->where('status', 1)
                ->first();

            if ($user) {
                $password = md5($post->password);
                if (trim($user->password) == trim($password)) {
                    if ($user->status == 0) {
                        return back()->withErrors(['error' => 'Acceso denegado']);
                    }
                    session([
                        'id'              => $user->id,
                        'people_id'       => $user->people_id,
                        'profile_id'      => $user->profile_id,
                        'red'             => $user->red,
                        'user_fullname'   => $user->fullname,
                    ]);
                    return redirect()->route('panel');
                }
                return back()->withErrors(['error' => 'Credenciales invalidas']);
            } else {
                return back()->withErrors(['error' => 'Credenciales invalidas']);
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    public function all()
    {
        $profile_id = session('profile_id');
        $red = session('red');
        $users = [];
        if($profile_id == ProfileID::SUPER_ADMIN) $users = User::all();
        if($profile_id == ProfileID::RED_AUDITOR) $users = User::all()->where('red', $red);
        if($profile_id != ProfileID::SUPER_ADMIN and $profile_id != ProfileID::RED_AUDITOR) $users = User::all()->where('created_by_id', session('id'));
        return view('user.all.all', compact(['users'])); 
    }

    public function create(Request $request)
    {
        try {
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $entity = new User;
            $entity->status = 1;
            $entity->created_by_id = session("id");
            $entity->fill($request->all());
            $entity->validate();
            $entity->password = md5($post->password);
            $entity->people_id = $this->getPeopleFromText($post->people);
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al almacenar el usuario, comuniquese con el administrador del sistema");
            }
            Log::save("Registro un nuevo usuario [".$post->username."]");
            return $this->responseApi(false, "Usuario registrado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function changeStatus($id, $status)
    {
        try {
            $user = User::find($id);    
            if($user == null) throw new Exception("Usuario no valido");
            $user->status = $status;
            if(!$user->save()){
                throw new Exception("Ocurrio un error interno al actualizar el usuario, comuniquese con el administrador del sistema");
            }
            Log::save("Cambio el estado del usuario a [".($status ? "ACTIVO" : "INACTIVO")."]");
            return $this->responseApi(false, "Cambio de estado realizado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $entity = User::find($post->id);
            if($entity == null) throw new Exception("El usuario no existe");
            $entity->fill($request->all());
            $entity->validate();
            $entity->people_id = $this->getPeopleFromText($post->people);
            if($entity->password != $post->password) $entity->password = md5($post->password);
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al actualizar el usuario, comuniquese con el administrador del sistema");
            }
            Log::save("Actualizo información de usuario [".$post->username."]");
            return $this->responseApi(false, "Usuario actualizado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }
}