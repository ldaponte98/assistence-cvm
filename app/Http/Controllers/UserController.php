<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\People;
use App\Shared\PeopleType;

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

    public function get($id)
    {
        $user = User::find($id);
        $readonly = true;
        if($user == null) { echo "Acceso denegado"; die; }
        return view('user.form.form', compact(['user', 'readonly']));
    }

    public function form(Request $request, $id = null)
    {
        $readonly = false;
        $post = $request->all();
        $user = new User;
        $user->status = 1;
        $user->people = new People;
        $original_password=null;
        if($id != null){
            $user = User::find($id);
            if($user == null) { echo "Acceso denegado"; die; }
            $original_password = $user->password;
        }
        if($post){
            $post = (object) $post;
            $user = new User;
            if($id != null) $user = User::find($id);
            $user->fill($request->all());
            $people = $user->people;
            if($people == null) $people = new People;
            $people->fill($request->all());
            $people->save();
            $user->people_id = $people->id;
            if($post->password != $original_password){
                $password = md5($post->password);
                $user->password = $password;
            }
            if(!$user->save()){
                echo "Ocurrio el siguiente inconveniente: <br>";
                dd($user->errors);
            }
            return redirect()->route('user/all');
        }
        return view('user.form.form', compact(['user', 'readonly']));
    }
}