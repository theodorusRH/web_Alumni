<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan dashboard admin
    public function index()
    {
        $employee = Employee::all();  // Ambil semua data employee
        return view('dashboard.index', compact('employee'));
    }
}
