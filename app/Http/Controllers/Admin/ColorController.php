<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ColorRequest;
use App\Models\Admin\Color;
use App\Services\ColorService;
use App\Traits\ResponseStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ColorController extends Controller
{

    use ResponseStatus;
    protected ColorService $colorService;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    public function index()
    {
        $color = Color::select(['id', 'name'])->paginate(20);
        return view('admin.color.index', compact('color'));
    }

    public function create()
    {
        return view('admin.color.add-edit');
    }

    public function store(ColorRequest $request)
    {
        try {
            $data = $this->colorService->store($request);
            return $this->success($data, 'Color created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->error('Failed to create new color', 500);
        }
    }

    public function edit(Color $color)
    {
        Log::info($color);
        return view('admin.color.add-edit', compact('color'));
    }
}
