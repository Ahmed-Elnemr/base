<?php

namespace Modules\ServiceWork\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\ServiceWork\app\Models\ServiceWorkCategory;
use Modules\ServiceWork\app\Models\ServiceWorkItem;

class ServiceWorkDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws \Exception
     */
    public function run(): void
    {
        $dataPath = database_path('seeders/data.json');
        if (! File::exists($dataPath)) {
            throw new \Exception("Data file not found at {$dataPath}. Please run the scrape script first.");
        }

        foreach (ServiceWorkItem::all() as $item) {
            $item->delete();
        }

        foreach (ServiceWorkCategory::all() as $category) {
            $category->delete();
        }

        $data = json_decode(File::get($dataPath), true);

        foreach ($data as $catData) {
            $category = ServiceWorkCategory::create([
                'name' => [
                    'ar' => $catData['name_ar'],
                    'en' => $catData['name_en'],
                ],
                'slug' => $catData['slug'],
                'is_active' => true,
            ]);

            $firstItemImage = null;
            if (! empty($catData['items'])) {
                foreach ($catData['items'] as $item) {
                    if (! empty($item['image'])) {
                        $firstItemImage = $item['image'];
                        break;
                    }
                }
            }

            if ($firstItemImage !== null) {
                $categoryImagePath = database_path('seeders/' . $firstItemImage);
                if (File::exists($categoryImagePath)) {
                    $category->addMedia($categoryImagePath)
                        ->preservingOriginal()
                        ->toMediaCollection('category_image');
                }
            }

            foreach ($catData['items'] as $itemData) {
                $item = ServiceWorkItem::create([
                    'service_work_category_id' => $category->id,
                    'title' => [
                        'ar' => $itemData['title_ar'],
                        'en' => $itemData['title_ar'],
                    ],
                    'subtitle' => [
                        'ar' => $itemData['subtitle_ar'],
                        'en' => $itemData['subtitle_ar'],
                    ],
                    'content' => [
                        'ar' => $itemData['content_ar'],
                        'en' => $itemData['content_ar'],
                    ],
                    'is_active' => true,
                ]);

                if (! empty($itemData['image'])) {
                    $itemImagePath = database_path('seeders/' . $itemData['image']);
                    if (File::exists($itemImagePath)) {
                        $item->addMedia($itemImagePath)
                            ->preservingOriginal()
                            ->toMediaCollection('work_image');
                    }
                }
            }
        }
    }
}
