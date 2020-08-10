<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function create(Request $request)
    {

        $account = new Account;
        $account->userName = $request->username;
        // $account->password = $request->password;
        $account->save();
        return response()->json([
            'Created: ' => $request->username,
        ]);
    }

    public function read($username)
    {
        $account = Account::where('userName', $username)->get();
        return response()->json([
            'Account: ' => $account,
        ]);
    }

    public function delete(Request $request)
    {
        Account::where('userName', $request->username)->delete();
        return response()->json([
            'Deleted: ' => $request->username,
        ]);
    }

    public function update(Request $request)
    {
        DB::table('accounts')
            ->where('userName', $request->oldUsername)
            ->update(['userName' => $request->newUsername]);
        return response()->json([
            'Username changed to: ' => $request->newUsername,
        ]);
    }

    public function search(Request $request)
    {
      $account = Account::where('userName', 'like', '%' . $request->username . '%')->get();
      return response()->json([
          'Account: ' => $account,
      ]);
    }

}
