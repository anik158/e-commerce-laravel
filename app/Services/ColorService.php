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

    public function update($request, $color){
        $color->update($request->all());
        return $color;
    }

    public function destroy($color){
        $color->delete();
    }
}
