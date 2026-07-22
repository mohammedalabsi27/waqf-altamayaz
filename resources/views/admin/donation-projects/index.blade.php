@extends('layouts.admin')

@section('title', 'المشاريع الوقفية')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.donation-projects.create') }}" class="bg-primary hover:bg-primary-dark transition text-white font-bold px-6 py-2.5 rounded-xl">
        <i class="fa-solid fa-plus ms-1"></i> إضافة مشروع
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
    <table class="w-full text-sm text-right">
        <thead class="bg-gray-50 text-gray-500 font-semibold">
            <tr>
                <th class="px-6 py-4">الصورة</th>
                <th class="px-6 py-4">المشروع</th>
                <th class="px-6 py-4">المستهدف</th>
                <th class="px-6 py-4">المحصَّل</th>
                <th class="px-6 py-4">النسبة</th>
                <th class="px-6 py-4">الترتيب</th>
                <th class="px-6 py-4">الحالة</th>
                <th class="px-6 py-4">إجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($projects as $project)
                <tr>
                    <td class="px-6 py-4">
                        @if($project->image)
                            <img src="{{ Storage::url($project->image) }}" class="w-14 h-14 rounded-lg object-cover">
                        @else
                            <div class="w-14 h-14 rounded-lg bg-primary/10 flex items-center justify-center text-primary/40"><i class="fa-solid fa-seedling"></i></div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-semibold">{{ $project->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ number_format($project->target_amount, 0) }} ريال</td>
                    <td class="px-6 py-4 font-extrabold text-primary-dark">{{ number_format($project->raised_amount, 0) }} ريال</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-20 h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: {{ $project->progress_percent }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500 font-semibold">{{ $project->progress_percent }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $project->order }}</td>
                    <td class="px-6 py-4">
                        @if($project->is_active)
                            <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs font-semibold">مفعّل</span>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-semibold">معطّل</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            <a href="{{ route('donation-projects.show', $project) }}" target="_blank" class="text-gray-400 hover:text-primary"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.donations.index', ['project' => $project->id]) }}" title="تبرعات المشروع" class="text-accent-dark hover:text-primary"><i class="fa-solid fa-hand-holding-heart"></i></a>
                            <a href="{{ route('admin.donation-projects.edit', $project) }}" class="text-secondary hover:text-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.donation-projects.destroy', $project) }}" method="POST" onsubmit="return confirm('تأكيد الحذف؟ التبرعات المسجلة على المشروع ستبقى وتتحول إلى تبرع عام.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="px-6 py-10 text-center text-gray-400">لا توجد مشاريع بعد</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
