<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryServiceController extends Controller
{
    public function getAll()
    {
        try {
            $category = Category::all();
            return ResponseFormatter::success($category, 'Success Create Collab Campaign');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Reply Failed', 500);
        }
    }
}
