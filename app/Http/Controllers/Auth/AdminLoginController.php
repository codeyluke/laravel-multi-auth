<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest:admin');
  }
  public function showLoginForm()
  {
    return view('admin.login');
  }

  public function login(Request $request)
  {
    // Validate form data
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required|min:6'
    ]);
    // attempt to login the user in
    // if successful then redirect to their intended location
    if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remembers)) {
      return redirect()->intended(route('admin.dashboard'));
    }

    // if unsuccessful then redirect back to the login form datas
    return redirect()->back()->withInput($request->only('email', 'remember'));
  }
}
