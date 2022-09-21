<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\CollabCampaign;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollabCampaignServiceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator =  Validator::make($request->all() ,[
                'campaign_id' => ['required'],
                'user_id' => ['required'],
            ]);
            
            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors());
            }

            $collab_campaign = CollabCampaign::create([
                'campaign_id' => $request->campaign_id,
                'user_id' => $request->user_id,
            ]);

            $collab_campaign = CollabCampaign::where('id', $collab_campaign->id)->with(['user', 'campaign'])->first();

            return ResponseFormatter::success($collab_campaign, 'Success Create Collab Campaign');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Reply Failed', 500);
        }
    }

    public function delete($id)
    {
        try {
            $collab_campaign = CollabCampaign::where('id', $id)->first();
            if (!$collab_campaign) {
                return ResponseFormatter::error([
                    'message' => 'Something Went Wrong',
                    'error' => 'Collab Campaign Not Found'
                ], 'Reply Failed', 500);
            }
            $collab_campaign->delete();
            return ResponseFormatter::success($collab_campaign, 'Success Delete Collab Campaign');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Reply Failed', 500);
        }
    }

    public function getById($id)
    {
        try {
            $collab_campaign = CollabCampaign::where('id', $id)->with(['user', 'campaign'])->first();
            if (!$collab_campaign) {
                return ResponseFormatter::error([
                    'message' => 'Something Went Wrong',
                    'error' => 'Collab Campaign Not Found'
                ], 'Reply Failed', 500);
            }
            return ResponseFormatter::success($collab_campaign, 'Success Delete Collab Campaign');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Reply Failed', 500);
        }
    }

    public function getByUserId($id)
    {
        try {
            $collab_campaign = CollabCampaign::where('user_id', $id)->with(['user', 'campaign'])->get();
            if ($collab_campaign->count() < 1) {
                return ResponseFormatter::error([
                    'message' => 'Something Went Wrong',
                    'error' => 'Collab Campaign Not Found'
                ], 'Reply Failed', 500);
            }
            return ResponseFormatter::success($collab_campaign, 'Success Delete Collab Campaign');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Reply Failed', 500);
        }
    }

    public function getByCampaignId($id)
    {
        try {
            $collab_campaign = CollabCampaign::where('campaign_id', $id)->with(['user', 'campaign'])->get();
            if ($collab_campaign->count() < 1) {
                return ResponseFormatter::error([
                    'message' => 'Something Went Wrong',
                    'error' => 'Collab Campaign Not Found'
                ], 'Reply Failed', 500);
            }
            return ResponseFormatter::success($collab_campaign, 'Success Delete Collab Campaign');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Reply Failed', 500);
        }
    }
}
