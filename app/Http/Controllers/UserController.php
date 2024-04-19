<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\People;
use App\Models\Application;
use App\Models\ApplicationSession;
use App\Shared\Log;
use App\Shared\ProfileID;
use App\Shared\Util\Encryptor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\External\Http;
use Exception;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $post = $request->all();
        if ($post) {
            $post    = (object) $post;
            
            if(!isset($post->key) || $post->key == "" || $post->key == null) {
                return back()->withErrors(['error' => 'Acceso denegado por clave de aplicación, comunicate con el administrador del sistema.']);
            }
            //Validamos que la aplicación q esta consumiendo el recurso este activa y registrada
            $application = Application::where('private_key', $post->key)
                ->where('status', 1)
                ->first();
            if($application == null){
                return back()->withErrors(['error' => 'Acceso denegado por clave de aplicación, comunicate con el administrador del sistema.']);
            }

            $user = User::where('username', str_replace(" ", "", $post->username))
                ->where('status', 1)
                ->first();
            if ($user) {
                $password = md5($post->password);
                if (trim($user->password) == trim($password)) {
                    if ($user->status == 0) {
                        return back()->withErrors(['error' => 'Acceso denegado']);
                    }
                    $current = date('Y-m-d H:i:s');
                    $data = [
                        'id' => $user->id,
                        'fullname' => $user->people->fullname,
                        'lastname' => $user->people->lastname,
                        'gender' => $user->people->gender,
                        'profile' => $user->profile->name,
                        'expired' => date('Y-m-d H:i:s', strtotime($current . "+1 days"))
                    ];
                    $token = Encryptor::encrypt(json_encode($data));
                    $params = "?key=$token";
                    return Redirect::to($application->webhook_url . $params);
                    
                }
                return back()->withErrors(['error' => 'Credenciales invalidas']);
            } else {
                return back()->withErrors(['error' => 'Credenciales invalidas']);
            }
        }
    }

    public function validate_token(Request $request)
    {
        $data = $request->all();
        if($data){
            $data = (object) $data;
            $token = $data->key;
            $user = User::find($data->identity->id);
            session([
                'id'              => $user->id,
                'people_id'       => $user->people_id,
                'profile_id'      => $user->profile_id,
                'red'             => $user->red
            ]);
            return redirect()->route('panel');
        }else{
            echo "acceso denegado";
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
            $entity->password = $entity->password != $post->password ? md5($post->password) : $post->password;
            if(!$entity->save()){
                throw new Exception("Ocurrio un error interno al actualizar el usuario, comuniquese con el administrador del sistema");
            }
            Log::save("Actualizo información de usuario [".$post->username."]");
            return $this->responseApi(false, "Usuario actualizado exitosamente");
        } catch (Exception $e) {
            return $this->responseApi(true, $e->getMessage());
        }
    }

    public function identity(Request $request)
    {
        $data = $request->all();
        $data = (object) $data;
        return response()->json($data);
    }
}