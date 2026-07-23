@extends('layouts.app')

@section('title', 'المشاريع الوقفية - وقف التميز الأسري')

@section('content')

@include('site.partials.page-header', [
    'badge' => 'صدقة جارية',
    'title' => 'المشاريع الوقفية',
    'breadcrumb' => ['المشاريع الوقفية' => null],
    'image' => 'images/headers/donation-projects.jpg',
])

<section class="py-20">
    <div class="container-x">

        <div class="max-w-3xl mx-auto text-center mb-14" data-aos="fade-up">
            <span class="section-eyebrow">ساهم في مشروع يمتد أثره</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-primary-dark mt-3 mb-4">اختر مشروعك الوقفي</h2>
            <p class="text-gray-500 leading-8">مشاريع وقفية متنوعة يمكنك المساهمة فيها، وكل ريال يُصرف ريعه في التنمية الأسرية والقيمية والاجتماعية.</p>
        </div>

        @if($projects->isEmpty())
            <div class="text-center py-16">
                <i class="fa-solid fa-seedling text-6xl text-gray-200 mb-4"></i>
                <p class="text-gray-500">لا توجد مشاريع وقفية متاحة حالياً.</p>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                    <div class="group card card-hover overflow-hidden flex flex-col"
                         data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 80 }}">
                        <a href="{{ route('donation-projects.show', $project) }}" class="block aspect-video bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center overflow-hidden">
                            @if($project->image)
                                <img src="{{ Storage::url($project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <i class="fa-solid fa-seedling text-5xl text-primary/30"></i>
                            @endif
                        </a>
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="font-bold text-lg text-primary-dark group-hover:text-secondary transition mb-2">
                                <a href="{{ route('donation-projects.show', $project) }}">{{ $project->name }}</a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-6 line-clamp-2 flex-1">{{ Str::limit(strip_tags($project->description), 120) }}</p>

                            {{-- شريط التقدم --}}
                            <div class="mt-5">
                                <div class="flex items-center justify-between text-sm mb-2">
                                    <span class="font-extrabold text-primary-dark">{{ number_format($project->raised_amount) }} <span class="text-xs font-normal text-gray-400">ريال</span></span>
                                    <span class="text-gray-400 text-xs">الهدف: {{ number_format($project->target_amount) }} ريال</span>
                                </div>
                                <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-l from-secondary to-primary rounded-full transition-all duration-700" style="width: {{ $project->progress_percent }}%"></div>
                                </div>
                                <span class="block text-xs text-gray-400 mt-1.5">اكتمل {{ $project->progress_percent }}%</span>
                            </div>

                            {{-- إدخال المبلغ والتبرع المباشر --}}
                            <form action="{{ route('checkout.show') }}" method="GET" class="mt-5" x-data="{ amount: '' }">
                                <input type="hidden" name="project" value="{{ $project->slug }}">
                                <div class="grid grid-cols-3 gap-2 mb-3">
                                    @foreach([50, 100, 500] as $preset)
                                        <button type="button" @click="amount = '{{ $preset }}'"
                                                class="py-1.5 rounded-lg border text-xs font-bold transition"
                                                :class="amount === '{{ $preset }}' ? 'bg-primary text-white border-primary' : 'border-gray-200 text-gray-500 hover:border-primary hover:text-primary'">
                                            {{ $preset }} ريال
                                        </button>
                                    @endforeach
                                </div>
                                <div class="flex gap-2">
                                    <input type="number" name="amount" x-model="amount" min="1" step="any" required placeholder="مبلغ التبرع"
                                           class="w-full min-w-0 rounded-xl border-gray-300 focus:border-secondary focus:ring-secondary px-3 py-2.5 text-sm">
                                    <button type="submit" class="btn-primary btn-md shrink-0">
                                        <i class="fa-solid fa-hand-holding-heart"></i> تبرع الآن
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
