<?php

namespace App\Http\Controllers\Link;

use Illuminate\Routing\Controller;
use Auth;
use App\User;
use App\Sharecode;
use App\Linkshare;
use App\Link;

class CodeController extends Controller {

    public function create($link_id) {
        $user = Auth::user();
        $user_id = $user->id;

        // 验证 link_id

        $code = Sharecode::create([
            'user_id' => $user_id,
            'link_id' => $link_id,
            'expire_at' => date('Y-m-d H:i:s', strtotime('+10 minute'))
        ]);

        $sharecode = substr(time(), 7, 3);
        for($i = 0; $i<3; $i++) {
            $sharecode .= chr(mt_rand(65, 90));
        }
        $code->code = $sharecode;
        $code->save();

        $res["status"] = "ok";
        $res["user_id"] = $user->id;
        $res["link_id"] = $link_id;
        $res["code"] = $sharecode;

        return response($res)
            ->header('Content-Type', 'application/json');
    }

    /**
     * -1: 参数错误
     * 1: code 不存在
     * 2: code 过期
     * 3: code 属于本人
     */
    public function accept() {
        $user = Auth::user();
        $user_id = $user->id;

        $codeJson = file_get_contents("php://input");
        $codeData = json_decode($codeJson);

        if (empty($codeData->code)) {
            $res["status"] = "error";
            $res["err_code"] = -1;
            return response($res)
                ->header('Content-Type', 'application/json');
        }

        
        if ($sharecode = Sharecode::where("code", $codeData->code)
                                ->orderBy("id", "desc")
                                ->first()) {
            //
            $current = date('Y-m-d H:i:s');
            if ($current > $sharecode->expire_at) {
                // code expired
                $res["status"] = "error";
                $res["err_code"] = 2;

                return response($res)
                    ->header('Content-Type', 'application/json');
            } else {
                // $link = Link:find($sharecode->link_id);
                if ($sharecode->user_id == $user_id) {
                    // code from himself
                    $res["status"] = "error";
                    $res["err_code"] = 3;

                    return response($res)
                        ->header('Content-Type', 'application/json');
                }

                $user_from = User::find($sharecode->user_id);
                $share = Linkshare::firstOrNew([
                    "link_id" => $sharecode->link_id,
                    "shared_to" => $user_id
                ]);
                $share->user_id = $sharecode->user_id;
                $share->save();

                $res["status"] = "ok";
                $res["id"] = $share->id;
                $res["link_id"] = $sharecode->link_id;
                $res['share_at'] = $share->created_at->format('Y-m-d H:i:s');
                $res["user_from_id"] = $user_from->id;
                $res["user_from_name"] = $user_from->name;
                $res["user_from_email"] = $user_from->email;
                
                return response($res)
                    ->header('Content-Type', 'application/json');
            }
        } else {
            // code not exist
            $res["status"] = "error";
            $res["err_code"] = 1;

            return response($res)
                ->header('Content-Type', 'application/json');
        }
    }

    public function deleteShare($id) {
        $user = Auth::user();
        $user_id = $user->id;

        $share = Linkshare::find($id);
        if (empty($share)) {
            $res["status"] = "error";
            $res["err_code"] = -1;
            return response($res)
                ->header('Content-Type', 'application/json');
        }

        $share->forceDelete();
        $res["status"] = "ok";
        return response($res)
            ->header('Content-Type', 'application/json');
    }
}