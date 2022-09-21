<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationServiceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator =  Validator::make($request->all() ,[
                'user_id' => ['required'],
                'message' => ['required'],
                'date' =>  ['required', 'min:3'],
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors());
            }

            $notifications = Notification::create([
                'user_id' => $request->user_id,
                'message' => $request->message,
                'date' => $request->date,
            ]);

            return ResponseFormatter::success($notifications, 'Success Create Notification');
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
        
        $notification = Notification::where('id', $id)->first();
        $notification->update($data);

        return ResponseFormatter::success($notification, 'Success Update Notification');
    }

    public function getByUserId($id)
    {
        $notifications = Notification::where('user_id', $id)->get();
        if ($notifications->count() < 1) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => 'Notification Data Not Found'
            ], 'Get User Notifications Failed', 500);
        }
        return ResponseFormatter::success($notifications, 'Success Get Users Notification');
    }

    public function getById($id)
    {
        $notifications = Notification::where('id', $id)->first();
        if ($notifications->count() < 1) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => 'Notification Data Not Found'
            ], 'Get User Notifications Failed', 500);
        }
        return ResponseFormatter::success($notifications, 'Success Get Users Notification');
    }
}
