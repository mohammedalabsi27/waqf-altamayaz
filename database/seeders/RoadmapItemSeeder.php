<?php

namespace Database\Seeders;

use App\Models\RoadmapItem;
use Illuminate\Database\Seeder;

class RoadmapItemSeeder extends Seeder
{
    public function run(): void
    {
        // ⚠️ الموقع الأصلي ما كان فيه محتوى فعلي لهذا القسم (كان شبه فارغ).
        // هذي بيانات مبدئية (Placeholder) لازم تُستبدل ببيانات حقيقية من الوقف.
        $items = [
            ['year_label' => 'السنة الأولى', 'title' => 'التأسيس وبناء الفريق'],
            ['year_label' => 'السنة الثانية', 'title' => 'إطلاق البرامج الأساسية'],
            ['year_label' => 'السنة الثالثة', 'title' => 'التوسع وزيادة الشراكات'],
            ['year_label' => 'السنة الرابعة', 'title' => 'تعزيز الأثر المجتمعي'],
            ['year_label' => 'السنة الخامسة', 'title' => 'الاستدامة والتقييم الشامل'],
        ];

        foreach ($items as $index => $item) {
            RoadmapItem::updateOrCreate(
                ['year_label' => $item['year_label']],
                [
                    'title' => $item['title'],
                    'order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
