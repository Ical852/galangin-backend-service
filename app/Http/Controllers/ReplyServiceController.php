<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Reply;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplyServiceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator =  Validator::make($request->all() ,[
                'comment_id' => ['required'],
                'user_id' => ['required'],
                'reply' =>  ['required', 'min:3'],
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors());
            }

            $reply = Reply::create([
                'comment_id' => $request->comment_id,
                'user_id' => $request->user_id,
                'reply' => $request->reply,
                'total_likes' => 0,
            ]);

            return ResponseFormatter::success($reply, 'Success Create Reply');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Reply Failed', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $reply = Reply::where('id', $id)->first();
        $reply->update($data);

        return ResponseFormatter::success($reply, 'Reply Updated');
    }

    public function delete($id)
    {
        try {
            $reply = Reply::where('id', $id)->first();
            if (!$reply) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Reply Not Found'
            ], 'Delete Reply Failed', 500);
            }
            $reply->delete();
            return ResponseFormatter::success($reply, 'Reply Deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Delete Reply Failed', 500);
        }
    }

    public function getById($id)
    {
        try {
            $reply = Reply::where('id', $id)->with(['user'])->first();
            if (!$reply) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Reply Not Found'
            ], 'Delete Reply Failed', 500);
            }
            return ResponseFormatter::success($reply, 'Success Get Reply');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Delete Reply Failed', 500);
        }
    }
}
