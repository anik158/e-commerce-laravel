<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SizeRequest;
use App\Models\Admin\Size;
use App\Services\SizeService;
use App\Traits\ResponseStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SizeController extends Controller
{
    use ResponseStatus;
    protected SizeService $sizeService;

    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $sizes = Size::select(['id', 'name'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(20);

        $sizes->appends(['search' => $search]);

        return view('admin.size.index', compact('sizes', 'search'));
    }

    public function create()
    {
        return view('admin.size.add-edit', ['size' => null]);
    }

    public function store(SizeRequest $request)
    {
        try {
            $data = $this->sizeService->store($request);
            return $this->success($data, 'Size created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->error('Failed to create new size', 500);
        }
    }

    public function edit(Size $size)
    {
        return view('admin.size.add-edit', compact('size'));
    }

    public function update(SizeRequest $request, Size $size)
    {
        try {
            $data = $this->sizeService->update($request, $size);
            return $this->success($data, 'Size updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->error('Failed to update size', 500);
        }
    }

    public function destroy(Size $size)
    {
        try {
            $this->sizeService->destroy($size);
            return $this->success(null, 'Size deleted successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->error('Failed to delete size', 500);
        }
    }
}
