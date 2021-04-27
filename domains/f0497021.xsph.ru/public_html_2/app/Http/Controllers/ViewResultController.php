<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


class ViewResultController extends Controller
{
    public function index()
    {
        return view('view-result.home')
            ->with('resultsPaginator', Auth::user()->results()->orderBy('created_at', 'DESC')->paginate(3));
    }
}
