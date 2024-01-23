<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\People;
use App\Shared\Log;
use App\Shared\PeopleType;
use Illuminate\Support\Facades\DB;
use Exception;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $post = $request->all();
        if ($post) {
            $post    = (object) $post;
            $user = User::where('username', $post->username)
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
        $users = User::all();
        return view('user.all.all', compact(['users'])); 
    }

    public function create(Request $request)
    {
        try {
            $post = $request->all();        
            if($post == null) throw new Exception("Error de información enviada");
            $post = (object) $post;
            $validation = User::where('username', $post->username)->first();
            if($validation != null){
                throw new Exception("El nombre de usuario ya se encuentra registrado");
            }
            $user = new User;
            $user->status = 1;
            $user->created_by_id = session("id");
            
            $user->fill($request->all());
            $user->password = md5($post->password);
            $user->people_id = $this->getPeopleFromText($post->people);
            if(!$user->save()){
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
            $user = User::find($post->id);
            if($user == null) throw new Exception("El usuario no existe");
            $validation = User::where('username', $post->username)
                              ->where('id', '<>', $post->id)
                              ->first();
            if($validation != null){
                throw new Exception("El nombre de usuario ya se encuentra registrado");
            }
            $user->fill($request->all());
            $user->people_id = $this->getPeopleFromText($post->people);
            $user->password = md5($post->password);
            if(!$user->save()){
                throw new Exception("Ocurrio un error interno al actualizar el usuario, comuniquese con el administrador del sistema");
            }
            Log::save("Actualizo información de usuario [".$post->username."]");
            return $this->responseApi(false, "Usuario actualizado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function getPeopleFromText($text_people)
    {
        $array = explode("(Tel: ", $text_people);
        if(count($array) != 2) throw new Exception("El registro de base de datos enviado no es valido");
        $phone = explode(")", $array[1])[0];
        if($phone == null || $phone == "") throw new Exception("El registro de base de datos enviado no cumple la estructura definida");
        $people = People::where('phone', $phone)->first();
        if($people == null) throw new Exception("El registro de base de datos enviado no es valido segun su numero de telefono");
        return $people->id;
    }
}