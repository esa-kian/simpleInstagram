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
        $follow = new Follower;
        $follow->follower_id = $request->follower_id;
        $follow->following_id = $request->following_id;
        $follow->save();
        $account = DB::table('accounts')->select('userName')->where('id', $request->following_id)->get();
        return response()->json([
            'Followed: ' => $account,
        ]);
    }

    public function unfollow(Request $request)
    {
        Follower::where('follower_id', $request->follower_id)->Where('following_id', $request->following_id)->delete();
        $account = DB::table('accounts')->select('userName')->where('id', $request->following_id)->get();
        return response()->json([
            'Unfollowed: ' => $account,
        ]);
    }

    public function followers(Request $request)
    {
        $followers = DB::table('accounts')
            ->leftJoin('followers', 'accounts.id', '=', 'followers.follower_id')->where('following_id', $request->accountId)->get();
        
        return response()->json([
            'Followers: ' => $followers,
        ]);
    }

    public function followings(Request $request)
    {
        $following = DB::table('accounts')
            ->leftJoin('followers', 'accounts.id', '=', 'followers.following_id')->where('follower_id', $request->accountId)->get();
        
        return response()->json([
            'Followers: ' => $following,
        ]);
    }
}
