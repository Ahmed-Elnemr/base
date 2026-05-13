<?php

namespace Modules\Setting\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Setting\app\Models\Setting;
use Modules\Setting\Transformers\SettingResource;

class SettingController extends Controller
{
    use ResponseTrait;

    public function all(): JsonResponse
    {
        $settings = Setting::query()->get();

        return self::successResponse(
            message: __('Settings loaded successfully'),
            data: SettingResource::collection($settings)
        );
    }

    public function showByKey(string $key): JsonResponse
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting) {
            return self::failResponse(404, __('Setting not found'));
        }

        return self::successResponse(
            message: __('Setting loaded successfully'),
            data: new SettingResource($setting)
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('setting::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('setting::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
