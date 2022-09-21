<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\CampaignComments;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignCommentsServiceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator =  Validator::make($request->all() ,[
                'campaign_id' => ['required'],
                'user_id' => ['required'],
                'comment' =>  ['required'],
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors());
            }

            $comment = CampaignComments::create([
                'campaign_id' => $request->campaign_id,
                'user_id' => $request->user_id,
                'comment' =>  $request->comment,
                'total_likes' =>  0,
            ]);

            return ResponseFormatter::success($comment, 'Create Comment Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Donation Failed', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $commetns = CampaignComments::where('id', $id)->first();
        $commetns->update($data);

        return ResponseFormatter::success($commetns, 'Campaign Comments Updated');
    }

    public function delete($id)
    {
        try {
            $news = CampaignComments::where('id', $id)->first();
            if (!$news) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign Comments Not Found'
            ], 'Delete Campaign Comments Failed', 500);
            }
            $news->delete();
            return ResponseFormatter::success($news, 'Campaign Comments Deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Delete Campaign Comments Failed', 500);
        }
    }

    public function getByCampaignId($id)
    {
        try {
            $news = CampaignComments::with(['user', 'reply.user'])->where('id', $id)->get();
            if ($news->count() < 1) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign Comments Not Found'
            ], 'Delete Campaign Comments Failed', 500);
            }
            return ResponseFormatter::success($news, 'Campaign Comments Deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Delete Campaign Comments Failed', 500);
        }
    }

    public function getById($id)
    {
        try {
            $news = CampaignComments::with(['user', 'reply.user'])->where('id', $id)->first();
            if (!$news) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign Comments Not Found'
            ], 'Delete Campaign Comments Failed', 500);
            }
            return ResponseFormatter::success($news, 'Campaign Comments Deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Delete Campaign Comments Failed', 500);
        }
    }
}
