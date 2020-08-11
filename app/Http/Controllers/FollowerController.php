<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follower;
use App\Account;
use Illuminate\Support\Facades\DB;

class FollowerController extends Controller
{
    public function follow(Request $request)
    {
        $account = Account::where('id', $request->following_id)->get();
        $following = Follower::where('follower_id', $request->follower_id)->where('following_id', $request->following_id)->get();

        if(($request->follower_id) != ($request->following_id))
        {
            if(count($account) != 0)
            {
                if(count($following) == 0)
                {
                    $follow = new Follower;
                    $follow->follower_id = $request->follower_id;
                    $follow->following_id = $request->following_id;
                    $follow->save();

                    return response()->json([
                        'Followed: ' => $account,
                    ]);
                }
                else
                {
                  return response()->json([
                      'You followed the account before: ' => $account,
                  ]);
                }
            }
            else
            {
              return response()->json([
                  'The account does not exist: ' => $account,
              ]);
            }
        }
        else
        {
          echo "Dude...! What's wrong with you?! you can't follow yourself!";
        }
    }

    public function unfollow(Request $request)
    {
        $account = Account::where('id', $request->following_id)->get();
        $following = Follower::where('follower_id', $request->follower_id)->where('following_id', $request->following_id)->get();

        if($request->following_id != $request->follower_id)
        {
            if(count($account) != 0)
            {
                if(count($following) != 0)
                {
                    Follower::where('follower_id', $request->follower_id)->Where('following_id', $request->following_id)->delete();

                    return response()->json([
                        'Unfollowed: ' => $account,
                    ]);
                }
                else
                {
                  return response()->json([
                      'You unfollowed the account before: ' => $account,
                  ]);
                }
            }
            else
            {
              return response()->json([
                  'The account does not exist: ' => $account,
              ]);
            }
        }
        else
        {
            echo "Dude...! What's wrong with you?! you can't unfollow yourself!";
        }
    }

    public function followers(Request $request)
    {
        $account = Account::where('id', $request->accountId)->get();

        if (count($account) != 0)
        {
          $followers = DB::table('accounts')
              ->leftJoin('followers', 'accounts.id', '=', 'followers.follower_id')
              ->where('following_id', $request->accountId)->get();

          return response()->json([
              'Followers: ' => $followers,
          ]);
        }
        else
        {
          return response()->json([
              'The account does not exist: ' => $account,
          ]);
        }
    }

    public function followings(Request $request)
    {
        $account = Account::where('id', $request->accountId)->get();

        if (count($account) != 0)
        {
            $following = DB::table('accounts')
                ->leftJoin('followers', 'accounts.id', '=', 'followers.following_id')
                ->where('follower_id', $request->accountId)->get();

            return response()->json([
                'Followers: ' => $following,
            ]);
        }
        else
        {
          return response()->json([
              'The account does not exist: ' => $account,
          ]);
        }
    }
}
