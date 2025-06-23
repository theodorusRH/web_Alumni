<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showForm()
    {
        $role = Role::where('status_active', 1)->get();
        $gender = $this->getGender('employees', 'gender');
        return view('auth.register',compact('role','gender'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'phone'       => 'required',
            'email'       => 'required|email|unique:employees,email',
            'username'    => 'required|string|unique:users,username',
            'password'    => 'required',
            'address'     => 'required',
            'gender'      => 'required',
            'roles_id'    => 'required'
        ]);

        // $employee = new Employee();
        // $employee->name          = $request->name;
        // $employee->phone_number  = $request->phone;
        // $employee->email         = $request->email;
        // $employee->address       = $request->address;
        // $employee->gender        = $request->gender;
        // $employee->status_active = 1;
        // $employee->save();

        $user = new User();
        $user->username      = $request->username;
        $user->password      = Hash::make($request->password);
        $user->roles_id      = $request->roles_id;
        $user->employees_id  = $employee->id;
        $user->status_active = 1;
        $user->save();

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    public function getGender($table, $column)
    {
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'")[0]->Type;
    
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = [];
        foreach(explode(',', $matches[1]) as $value) {
            $enum[] = trim($value, "'");
        }
        return $enum;
    }
}

