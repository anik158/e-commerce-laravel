<?php

namespace App\Services;

use App\Models\Admin\Size;

class SizeService
{
    public function store($request)
    {
        $data = $request->all();
        return Size::create($data);
    }

    public function update($request, $size)
    {
        $size->update($request->all());
        return $size;
    }

    public function destroy($size)
    {
        $size->delete();
    }
}
