<?php

namespace App\Http\Controllers;

use App\Models\Iframe;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $iframe = Iframe::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->first();
        $usuario = Usuario::where('usuario', Auth::user()->usuario)
            ->with('roles')
            ->first();
        return view('home', compact('usuario', 'iframe'));
    }
}
