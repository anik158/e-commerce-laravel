<?php

namespace App\Services;

use App\Models\Admin\Color;

class ColorService
{
    public function store($request)
    {
        $data = $request->all();
        return  Color::create($data);
    }
}
