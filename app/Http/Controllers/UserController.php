<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\User;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('isadmin');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
        ]);
    }

    public function search() {
        $users = User::orderby('id', 'desc')->paginate(10); //show only 5 items at a time in descending order

        return view('users.search', compact('users'));
    }

    public function index() {
        $users = User::orderby('id', 'desc')->paginate(10); //show only 5 items at a time in descending order

        return view('users.search', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        
        $tasks= \App\Task::get_calendar_user_tasks();
        return view('users.calendar', compact('tasks'));
    }
    public function create()
    {
        return view('users.create');
    }

    public function show($id)
    {
        $user = User::findOrFail($id); //Find User of id = $id

        return view ('users.show', compact('user'));

    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->name = $request["name"];
        
        $oldrole=$user->role;
        $newrole=$request["role"];
        
        if($oldrole=='admin' && $newrole=='customer')
        {
            if(User::where('role', 'admin')->count() == 1)
            {
                return redirect()->route('users', $user->id)->with('flash_message', 'Can not change user '. $user->name. ' "admin" status to customer since it is the only admin defined.');
            }
        }
        $user->role = $request["role"];

        $user->save();

        return redirect()->route('users', $user->id)->with('flash_message', 'User, '. $user->name.' updated');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users')
            ->with('flash_message', 'User deleted!');
    }
}
