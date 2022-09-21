<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Campaign;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignServiceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator =  Validator::make($request->all() ,[
                'user_id' => ['required'],
                'category_id' => ['required'],
                'title' =>  ['required', 'min:5'],
                'target' =>  ['required'],
                'max_date' =>  ['required'],
                'desc' =>  ['required', 'min:5'],
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors());
            }

            $validator1 = Validator::make($request->all(), [
                'image' => ['required', 'image']
            ]);

            if ($validator1->fails()) {
                return ResponseFormatter::error(
                    ['error' => $validator1->errors()],
                    'Update Photo Failed',
                    401
                );
            }

            if ($request->file('image')) {
                $image = $request->image->store('assets/campaign', 'public');

                $campaign = Campaign::create([
                    'user_id' => $request->user_id,
                    'category_id' => $request->category_id,
                    'title' =>  $request->title,
                    'target' =>  $request->target,
                    'max_date' =>  $request->max_date,
                    'desc' =>  $request->desc,
                    'image' => $image
                ]);

                return ResponseFormatter::success($campaign, 'File successfully uploaded');
            } else {
                return ResponseFormatter::error([
                    'message' => 'Something Went Wrong',
                    'error' => 'Failed Create Campaign'
                ], 'Failed Create Campaign', 500);
            }

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Create Campaign Failed', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $campaign = Campaign::where('id', $id)->first();
        $campaign->update($data);

        return ResponseFormatter::success($campaign, 'Campaign Updated');
    }

    public function updatePhoto(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image']
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                ['error' => $validator->errors()],
                'Update Campaign Photo Failed',
                401
            );
        }

        $campaign = Campaign::where('id', $id)->first();

        if ($request->file('image')) {
            $file = $request->image->store('assets/campaign', 'public');

            $campaign->image = $file;
            $campaign->update();

            return ResponseFormatter::success($campaign, 'Campaign Photo successfully updated');
        } else {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => 'Failed'
            ], 'Update Campaign Photo Failed', 500);
        }
    }

    public function delete($id)
    {
        try {
            $campaign = Campaign::where('id', $id)->first();
            if (!$campaign) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign Not Found'
            ], 'Delete Campaign Failed', 500);
            }
            $campaign->delete();
            return ResponseFormatter::success($campaign, 'Campaign Deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Delete Campaign Failed', 500);
        }
    }

    public function getAll()
    {
        try {
            $campaigns = Campaign::with(['user', 'campaign_donation.user', 'campaign_news.user', 'campaign_news.campaign_news_comments.user', 'campaign_news.campaign_news_comments.campaign_news_comments_reply.user', 'category', 'collab_campaign.user','campaign_comments.user', 'campaign_comments.reply.user'])->get();
            return ResponseFormatter::success($campaigns, 'Success Get All Campaign');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Campaign Failed', 500);
        }
    }

    public function getById($id)
    {
        try {
            $campaigns = Campaign::where('id', $id)->with(['user', 'campaign_donation.user', 'campaign_news.user', 'campaign_news.campaign_news_comments.user', 'campaign_news.campaign_news_comments.campaign_news_comments_reply.user', 'category', 'collab_campaign.user','campaign_comments.user', 'campaign_comments.reply.user'])->first();
            return ResponseFormatter::success($campaigns, 'Success Get Detail Campaign');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Campaign Failed', 500);
        }
    }

    public function getByCategoryId($id)
    {
        try {
            $campaigns = Campaign::where('category_id', $id)->with(['user', 'campaign_donation.user', 'campaign_news.user', 'campaign_news.campaign_news_comments.user', 'campaign_news.campaign_news_comments.campaign_news_comments_reply.user', 'category', 'collab_campaign.user','campaign_comments.user', 'campaign_comments.reply.user'])->get();
            return ResponseFormatter::success($campaigns, 'Success Get Category Campaign');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Campaign Failed', 500);
        }
    }

    public function getByUserId($id)
    {
        try {
            $campaigns = Campaign::where('user_id', $id)->with(['user', 'campaign_donation.user', 'campaign_news.user', 'campaign_news.campaign_news_comments.user', 'campaign_news.campaign_news_comments.campaign_news_comments_reply.user', 'category', 'collab_campaign.user','campaign_comments.user', 'campaign_comments.reply.user'])->get();
            return ResponseFormatter::success($campaigns, 'Success Get Users Campaign');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Campaign Failed', 500);
        }
    }

}
