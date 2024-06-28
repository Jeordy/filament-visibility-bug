<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    protected $model = Permission::class;
    private static $combinations = null;
    private static $index = 0;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (is_null(self::$combinations)) {
            self::$combinations = $this->generateUniqueCombinations();
            self::$index = 0;
        }

        $combination = self::$combinations[self::$index++];

        $description = ucwords(str_replace('.', ' ', $combination));

        return [
            'name' => $combination,
            'description' => $description,
        ];
    }

    private function generateUniqueCombinations()
    {
        // Define the base names and actions
        $entities = ['users', 'posts', 'comments', 'products', 'permissions', 'pages', 'media', 'images'];
        $actions = ['view', 'create', 'update', 'delete'];

        $combinations = [];
        foreach ($entities as $entity) {
            foreach ($actions as $action) {
                $combinations[] = "$entity.$action";
            }
        }

        shuffle($combinations); // Randomize the order to ensure variety
        return $combinations;
    }
}
