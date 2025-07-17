<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        $imports = \App\Models\Import::with('admin')->orderByDesc('date')->paginate(10);
        return view('admin.import.index', compact('imports'));
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

}
