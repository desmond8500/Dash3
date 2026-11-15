<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModelController extends Controller
{
    static function factory_type(string $type) {
        switch ($type) {
            case 'int':
                return '$this->faker->numberBetween(1,20)';
            case 'string':
                return '$this->faker->text(25)';
            case 'date':
                return '$this->faker->date()';
            case 'boolean':
                return '$this->faker->boolean()';
            case 'text':
                return '$this->faker->text(12)';
            case 'select':
                return '$this->faker->numberBetween(1, 25)';
            case 'img':
                $id = random_int(0, 99);
                $image = random_int(0, 99);
                return "DashController::store_url_image(\"https://avatar.iran.liara.run/public/$id\", \"demo/stock/$image/avatar\")";
            default:
                return '$this->faker->text(25)';
        }
    }
}
