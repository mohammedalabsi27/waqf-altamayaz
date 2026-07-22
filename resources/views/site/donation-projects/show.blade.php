@extends('layouts.app')

@section('title', $donationProject->name.' - وقف التميز الأسري')

@section('content')

@include('site.partials.page-header', [
    'badge' => 'مشروع وقفي',
    'title' => $donationProject->name,
    'breadcrumb' => ['المشاريع الوقفية' => route('donation-projects.index'), $donationProject->name => null],
    'image' => 'images/headers/donation-projects.jpg',
])

<section class="py-20">
    <div class="container-x grid lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2" data-aos="fade-up">
            <div class="rounded-3xl overflow-hidden shadow-soft aspect-video bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center mb-8">
                @if($donationProject->image)
                    <img src="{{ Storage::url($donationProject->image) }}" alt="{{ $donationProject->name }}" class="w-full h-full object-cover">
                @else
                    <i class="fa-solid fa-seedling text-6xl text-primary/30"></i>
                @endif
            </div>

            <div class="prose prose-lg max-w-none text-gray-600 leading-8">
                {!! nl2br(e($donationProject->description)) !!}
            </div>
        </div>

        <aside class="space-y-6" data-aos="fade-up" data-aos-delay="120">
            <div class="card p-6 sticky top-28">
                <h3 class="font-bold text-primary-dark mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-bullseye text-secondary"></i> تقدم المشروع
                </h3>

                {{-- شريط التقدم --}}
                <div class="mb-6">
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-gradient-to-l from-secondary to-primary rounded-full transition-all duration-700" style="width: {{ $donationProject->progress_percent }}%"></div>
                    </div>
                    <span class="block text-center text-sm font-bold text-secondary">اكتمل {{ $donationProject->progress_percent }}%</span>
                </div>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center justify-between bg-primary/5 rounded-xl px-4 py-3">
                        <span class="text-sm text-gray-500">المبلغ المحصَّل</span>
                        <span class="font-extrabold text-primary-dark">{{ number_format($donationProject->raised_amount) }} <span class="text-xs font-normal text-gray-400">ريال</span></span>
                    </div>
                    <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3">
                        <span class="text-sm text-gray-500">المبلغ المستهدف</span>
                        <span class="font-extrabold text-gray-700">{{ number_format($donationProject->target_amount) }} <span class="text-xs font-normal text-gray-400">ريال</span></span>
                    </div>
                    <div class="flex items-center justify-between bg-accent/10 rounded-xl px-4 py-3">
                        <span class="text-sm text-gray-500">المتبقي</span>
                        <span class="font-extrabold text-accent-dark">{{ number_format(max(0, $donationProject->target_amount - $donationProject->raised_amount)) }} <span class="text-xs font-normal text-gray-400">ريال</span></span>
                    </div>
                </div>

                <a href="{{ route('donate.index', ['project' => $donationProject->slug]) }}" class="btn-primary btn-lg w-full justify-center">
                    <i class="fa-solid fa-hand-holding-heart"></i> تبرع لهذا المشروع
                </a>
                <a href="{{ route('donation-projects.index') }}" class="mt-4 inline-flex items-center gap-2 text-primary font-bold text-sm hover:text-secondary hover:gap-3 transition-all">
                    <i class="fa-solid fa-arrow-right"></i> جميع المشاريع الوقفية
                </a>
            </div>
        </aside>
    </div>
</section>

@endsection
