<?php

namespace Database\Seeders;

use App\Models\DonationProject;
use Illuminate\Database\Seeder;

class DonationProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'name' => 'وقف تأهيل المقبلين على الزواج',
                'slug' => 'marriage-preparation-waqf',
                'description' => "مشروع وقفي يهدف إلى تأهيل المقبلين والمقبلات على الزواج ببرامج تدريبية متخصصة تُعينهم على بناء أسرة مستقرة ومتماسكة.\n\nيشمل المشروع دورات تأهيلية، واستشارات أسرية، وحقائب تدريبية معتمدة يقدمها مختصون في الإرشاد الأسري.",
                'target_amount' => 100000,
                'order' => 1,
            ],
            [
                'name' => 'وقف الحقائب التدريبية الأسرية',
                'slug' => 'family-training-waqf',
                'description' => "مشروع وقفي لتصميم وإنتاج حقائب تدريبية أسرية وتربوية متخصصة، تُتاح للمدربين والمهتمين بالشأن الأسري.\n\nريع الوقف يُصرف على تطوير محتوى الحقائب وتحكيمها وإتاحتها بجودة عالية.",
                'target_amount' => 50000,
                'order' => 2,
            ],
            [
                'name' => 'وقف برامج التربية والقيم',
                'slug' => 'values-education-waqf',
                'description' => "مشروع وقفي يدعم البرامج التربوية والقيمية الموجهة للأبناء والوالدين، لغرس القيم وتعزيز التربية الإيجابية داخل الأسرة.\n\nيشمل المشروع برامج تدريبية ولقاءات توعوية ومواد إثرائية تصل لأكبر شريحة من الأسر.",
                'target_amount' => 250000,
                'order' => 3,
            ],
        ];

        foreach ($projects as $project) {
            DonationProject::updateOrCreate(
                ['slug' => $project['slug']],
                $project + ['is_active' => true]
            );
        }
    }
}
