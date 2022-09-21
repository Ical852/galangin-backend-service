<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\CampaignNews;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignNewsServiceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator =  Validator::make($request->all() ,[
                'campaign_id' => ['required'],
                'user_id' => ['required'],
                'message' =>  ['required'],
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors());
            }

            $news = CampaignNews::create([
                'campaign_id' => $request->campaign_id,
                'user_id' => $request->user_id,
                'message' => $request->message,
                'total_likes' => 0,
            ]);

            return ResponseFormatter::success($news, 'Create News Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Create News Failed', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $news = CampaignNews::where('id', $id)->first();
        $news->update($data);

        return ResponseFormatter::success($news, 'Campaign News Updated');
    }

    public function delete($id)
    {
        try {
            $news = CampaignNews::where('id', $id)->first();
            if (!$news) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign News Not Found'
            ], 'Delete Campaign News Failed', 500);
            }
            $news->delete();
            return ResponseFormatter::success($news, 'Campaign News Deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Delete Campaign News Failed', 500);
        }
    }

    public function getByCampaignId($id)
    {
        try {
            $news = CampaignNews::with(['user', 'campaign_news_comments.user', 'campaign_news_comments.campaign_news_comments_reply.user'])->where('campaign_id', $id)->get();
            if ($news->count() < 1) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign News Not Found'
            ], 'Get Campaign News Failed', 500);
            }
            return ResponseFormatter::success($news, 'Campaign News Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Campaign News Failed', 500);
        }
    }

    public function getById($id)
    {
        try {
            $news = CampaignNews::with(['user', 'campaign_news_comments.user', 'campaign_news_comments.campaign_news_comments_reply.user'])->where('id', $id)->first();
            if (!$news) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign News Not Found'
            ], 'Get Campaign News Failed', 500);
            }
            return ResponseFormatter::success($news, 'Campaign News Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Campaign News Failed', 500);
        }
    }
}
