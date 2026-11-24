<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\FileTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FileTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'file_id' => File::factory()->create()->id,
            'tag_id' => Tag::factory()->create()->id
        ];
    }
}
