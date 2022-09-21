<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\CampaignNewsComments;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignNewsCommentsServiceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator =  Validator::make($request->all() ,[
                'campaign_news_id' => ['required'],
                'user_id' => ['required'],
                'comment' =>  ['required'],
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors());
            }

            $comment = CampaignNewsComments::create([
                'campaign_news_id' => $request->campaign_news_id,
                'user_id' => $request->user_id,
                'comment' => $request->comment,
                'total_likes' => 0,
            ]);

            return ResponseFormatter::success($comment, 'Create News Comments Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Create News Comments Failed', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $newscomments = CampaignNewsComments::where('id', $id)->first();
        $newscomments->update($data);

        return ResponseFormatter::success($newscomments, 'Campaign News Comments Updated');
    }

    public function delete($id)
    {
        try {
            $news = CampaignNewsComments::where('id', $id)->first();
            if (!$news) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign News Comments Not Found'
            ], 'Delete Campaign News Comments Failed', 500);
            }
            $news->delete();
            return ResponseFormatter::success($news, 'Campaign News Comments Deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Delete Campaign News Comments Failed', 500);
        }
    }

    public function getByCampaignNewsId($id)
    {
        try {
            $news = CampaignNewsComments::with(['user', 'campaign_news_comments_reply.user'])->where('campaign_news_id', $id)->get();
            if (!$news) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign News Comments Not Found'
            ], 'Get Campaign News Comments Failed', 500);
            }
            return ResponseFormatter::success($news, 'Get Campaign News Comments Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Campaign News Comments Failed', 500);
        }
    }

    public function getById($id)
    {
        try {
            $news = CampaignNewsComments::with(['user', 'campaign_news_comments_reply.user'])->where('id', $id)->first();
            if (!$news) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign News Comments Not Found'
            ], 'Get Campaign News Comments Failed', 500);
            }
            return ResponseFormatter::success($news, 'Get Campaign News Comments Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Campaign News Comments Failed', 500);
        }
    }
}
