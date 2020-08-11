<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function create(Request $request)
    {
      $account = Account::where('userName', $request->username)->get();

      if(count($account) == 0)
      {
        $account = new Account;
        $account->userName = $request->username;
        $account->save();
        return response()->json([
            'Created: ' => $request->username,
        ]);
      }
      else
      {
        return response()->json([
            'Try another one, The username is already exists: ' => $request->username,
        ]);
      }
    }

    public function read($username)
    {
        $account = Account::where('userName', $username)->get();

        if(count($account) == 0)
        {
          return response()->json([
              'The username does not exist: ' => $username,
          ]);
        }
        else
        {
          return response()->json([
              'Account: ' => $account,
          ]);
        }
    }

    public function delete(Request $request)
    {
      $account = Account::where('userName', $request->username)->where('deleted_at', null)->get();

      if(count($account) == 0)
      {
          return response()->json([
              'The username does not exist: ' => $request->username,
          ]);
      }
      else
       {
          Account::where('userName', $request->username)->delete();

          return response()->json([
              'Deleted: ' => $request->username,
          ]);
      }
    }

    public function update(Request $request)
    {
      $account = Account::where('userName', $request->oldUsername)->whereNull('deleted_at')->get();

      if(count($account) == 0)
      {
          return response()->json([
              'The username does not exist: ' => $request->oldUsername,
          ]);
      }
      else
      {
        $newAccount = Account::where('userName', $request->newUsername)->whereNull('deleted_at')->get();
        
        if(count($newAccount) == 0)
        {
          DB::table('accounts')
              ->where('userName', $request->oldUsername)
              ->update(['userName' => $request->newUsername]);

          return response()->json([
              'Username changed to: ' => $request->newUsername,
          ]);
        }
        else
        {
          return response()->json([
              'Try another one, The username is already exists: ' => $request->newUsername,
          ]);
        }
      }
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
