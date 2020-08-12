<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
  public function create(Request $request)
  {
    return Account::create($request->all());
  }

  public function read($id)
  {
    return Account::find($id);
  }

  public function update(Request $request, $id)
  {
    $account = Account::findOrFail($id);
    $account->update($request->all());

    return $account;
  }

  public function delete($id)
  {
    $account = Account::findOrFail($id);
    $account->delete();

    return 204;
  }

  public function search(Request $request)
  {
    $account = Account::where('userName', 'like', '%' . $request->username . '%')->get();

    return $account;
  }
}
