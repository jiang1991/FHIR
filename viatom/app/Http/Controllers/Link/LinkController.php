<?php

namespace App\Http\Controllers\Link;

use Illuminate\Routing\Controller;
use Auth;
use App\User;
use App\Link;
use App\Linkshare;

/**
 * error code:
 * -1 -> 数据不合法
 * 
 */

 class LinkController extends Controller {

    public function check() {
        $user = Auth::user();
        $user_id = $user->id;

        $linkJson = file_get_contents("php://input");
        $linkData = json_decode($linkJson);

        if ($link = Link::where("device_sn", $linkData->device_sn)
                        ->first()) {
            $owner = User::find($link->user_id);

            $res["status"] = "ok";
            $res["exist"] = 1;
            $res["link_id"] = $link->id;
            $res["user_id"]  = $owner->id;
            $res["user_name"] = $owner->name;
            $res["user_email"] = $owner->email;
        } else {

            $res["status"] = "ok";
            $res["exist"] = 0;
        }

        return response($res)
            ->header('Content-Type', 'application/json');
    }

    public function create() {
        $user = Auth::user();
        $user_id = $user->id;

        $linkJson = file_get_contents("php://input");
        $linkData = json_decode($linkJson);

        if (empty($linkData->device_name) || empty($linkData->device_sn)) {
            $res["status"] = "error";
            $res["err_code"] = -1;
            return response($res)
                ->header('Content-Type', 'application/json');
        }

        $link = Link::firstOrNew([
            'user_id' => $user_id,
            'device_sn' => $linkData->device_sn
        ]);

        $link->device_name = $linkData->device_name;
        $link->branch_code = $linkData->branch_code;

        $link->save();

        $res["status"] = "ok";
        $res["user_id"] = $user->id;
        $res["link_id"] = $link->id;

        return response($res)
            ->header('Content-Type', 'application/json');
    }

    public function delete($link_id) {
        $user = Auth::user();
        $user_id = $user->id;

        if ($link = Link::where("user_id", $user_id)
                        ->where("id", $link_id)
                        ->first()) {

            // todo: 确认所有权
            $link->forceDelete();

            // todo: 删除附带的分享
            Linkshare::where("link_id", $link_id)->forceDelete();

            $res["status"] = "ok";
            return response($res)
                ->header('Content-Type', 'application/json');
        } else {
            $res["status"] = "error";
            $res["err_code"] = -1;

            return response($res)
                ->header('Content-Type', 'application/json');
        }

    }

    /**
     * 获取自己的link
     * 与分享来的link
     */
    public function queryByUser() {
        $user = Auth::user();
        $user_id = $user->id;
        // my

        $res['my'] = [];
        $res['shared'] = [];
        $links = Link::where("user_id", $user_id)->get();
        foreach ($links as $link) {
            $l['id'] = $link->id;
            $l['device_name'] = $link->device_name;
            $l['device_sn'] = $link->device_sn;
            $l['branch_code'] = $link->branch_code;
            $res['my'][] = $l;
        }

        // shared
        $shares = Linkshare::where("shared_to", $user_id)->get();

        foreach ($shares as $share) {
            $user_from = User::find($share->user_id);

            $ls['id'] = $share->id;
            $ls['link_id'] = $share->link_id;
            $ls['share_at'] = $share->created_at->format('Y-m-d H:i:s');
            $ls["user_from_id"] = $user_from->id;
            $ls["user_from_name"] = $user_from->name;
            $ls["user_from_email"] = $user_from->email;

            $res['shared'][] = $ls;
        }

        return response($res)
            ->header('Content-Type', 'application/json+fhir');
    }

    /**
     * 查询link分享给了哪些用户
     */
    public function queryByLink($link_id) {
        $user = Auth::user();
        $user_id = $user->id;

        // todo: 确认link所有权

        $shares = Linkshare::where("link_id", $link_id)->get();

        if (empty($shares)) {
            $res["status"] = "error";
        } else {
            $res["status"] = "ok";
        }
        $list = [];

        foreach ($shares as $share) {
            $user_to = User::find($share->shared_to);

            $s['id'] = $share->id;
            $s['link_id'] = $share->link_id;
            $s['share_at'] = $share->created_at->format('Y-m-d H:i:s');
            $s["user_to_id"] = $user_to->id;
            $s["user_to_name"] = $user_to->name;
            $s["user_to_email"] = $user_to->email;

            $list[] = $s;
        }

        $res["list"] = $list;

        return response($res)
            ->header('Content-Type', 'application/json+fhir');
    }

    /**
     * 查询link信息
     */
    public function queryById($link_id) {
        $user = Auth::user();
        $user_id = $user->id;

        // todo: 确认link所有权

        $res = [];
        $link = Link::find($link_id);
        if (empty($link)) {
            $res["status"] = "error";
            $res["err_code"] = -1; // not found
            return response($res)
                ->header('Content-Type', 'application/json');
        }

        // if ($link->user_id != $user_id) {
        //     $res["status"] = "error";
        //     $res["err_code"] = 1; // 无权限
        //     return response($res)
        //         ->header('Content-Type', 'application/json');
        // }

        $res["status"] = "ok";
        $res["id"] = $link->id;
        $res["user_id"] = $link->user_id;
        $res["device_name"] = $link->device_name;
        $res["device_sn"] = $link->device_sn;
        $res["branch_code"] = $link->branch_code;
        $res["created_at"] = $link->created_at->format('Y-m-d H:i:s');

        return response($res)
                ->header('Content-Type', 'application/json');
    }

 }