<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\CampaignDonation;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Midtrans\Config;
use Midtrans\Snap;

class CampaignDonationServiceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator =  Validator::make($request->all() ,[
                'campaign_id' => ['required'],
                'user_id' => ['required'],
                'order_id' =>  ['required'],
                'donation_amount' =>  ['required'],
                'message' =>  ['required'],
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors());
            }

            
            Config::$isProduction = false;
            Config::$isSanitized = false;
            Config::$is3ds = false;

            $user = User::where('id', $request->user_id)->first();

            if (!$user) {
                return ResponseFormatter::error([
                    'message' => 'Something Went Wrong',
                    'error' => "User Not Found"
                ], 'Donation Failed', 500);
            }
    
            $params = [
                'transaction_details' => [
                    'order_id' => $request->order_id,
                    'gross_amount' => $request->donation_amount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone_number,
                ]
            ];

            $snap = Snap::createTransaction($params)->redirect_url;

            $donation = CampaignDonation::create([
                'campaign_id' => $request->campaign_id,
                'user_id' => $request->user_id,
                'order_id' =>  $request->order_id,
                'donation_amount' =>  $request->donation_amount,
                'message' =>  $request->message,
                'payment_url' => $snap
            ]);

            return ResponseFormatter::success($donation, 'Donation Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Donation Failed', 500);
        }
    }

    public function getById($id)
    {
        try {
            $news = CampaignDonation::with(['user', 'campaign'])->where('id', $id)->first();
            if (!$news) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign Donatipon Comments Not Found'
            ], 'Get Campaign Donatipon Comments Failed', 500);
            }
            return ResponseFormatter::success($news, 'Get Campaign Donatipon Comments Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Campaign Donatipon Comments Failed', 500);
        }
    }

    public function getByUserId($id)
    {
        try {
            $news = CampaignDonation::with(['user', 'campaign'])->where('user_id', $id)->get();
            if (!$news) {
                return ResponseFormatter::error([
                'message' => 'Not Found',
                'error' => 'Campaign Donatipon Comments Not Found'
            ], 'Get Campaign Donatipon Comments Failed', 500);
            }
            return ResponseFormatter::success($news, 'Get Campaign Donatipon Comments Success');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Campaign Donatipon Comments Failed', 500);
        }
    }
}
