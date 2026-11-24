<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\FileComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FileComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->text,
            'user_id' => User::factory()->create()->id,
            'file_id' => File::factory()->create()->id
        ];
    }
}
