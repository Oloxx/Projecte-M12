<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

class TesterController extends Controller
{
    public function test()
    {
        return dd(Hash::make('12345678'));
    }
}