<?php

namespace App\Http\Controllers;

use App\DTO\UserDto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Client;
use App\Models\Staff;
use App\Models\User;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $client = Client::where('user_id',Auth::id())->first();
        if($client){
            $staff = Staff::where('client_admin_id',$client->id)->pluck('user_id');
            // dd($staff);
            $data = User::whereIn('id',$staff)->latest()->paginate(5);

        }else{
            $data = User::latest()->paginate(5);
        }



        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {

        if(Auth::user()->roles[0]->interface == 'client'){
            $roles = Role::where('position_name','client')->pluck('name', 'name')->all();
        }else{
            $roles = Role::where('position_name','admin')->pluck('name', 'name')->all();
        }


        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
       public function store(UserRequest $request): RedirectResponse
    {


        $data = $request->all();

        $user = $this->userService->createUser($data);

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);

        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        // $user = User::find($id);
        $user = User::where('id',$id)->with('client')->first();
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $isEditMode = true;

        return view('users.edit',compact('user','roles','userRole','isEditMode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id): RedirectResponse
    // {
    //     $this->validate($request, [
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email,'.$id,
    //         'password' => 'same:confirm-password',
    //         'roles' => 'required'
    //     ]);

    //     $input = $request->all();
    //     if(!empty($input['password'])){
    //         $input['password'] = Hash::make($input['password']);
    //     }else{
    //         $input = Arr::except($input,array('password'));
    //     }

    //     $user = User::find($id);
    //     $user->update($input);
    //     DB::table('model_has_roles')->where('model_id',$id)->delete();

    //     $user->assignRole($request->input('roles'));

    //     return redirect()->route('users.index')
    //                     ->with('success','User updated successfully');
    // }
    public function update(UserRequest $request, string $id)
    {



        $data = $this->userService->updateUser( $id,$request->all());

        if ($data) {
            return redirect()->route('users.index')->with('success', "Օգտատերը ստեղծվել է հաջողությամբ");
        }

        return redirect()->back()->withErrors('Failed to update the user.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
