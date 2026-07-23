@extends('layouts.app')

@section('title', 'شكراً لتبرعك - وقف التميز الأسري')

@section('content')

<section class="py-28 relative overflow-hidden">
    <div class="absolute -top-24 -start-24 w-80 h-80 bg-secondary/5 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -end-24 w-96 h-96 bg-accent/5 rounded-full blur-3xl"></div>

    <div class="relative container-x max-w-xl text-center" data-aos="fade-up">
        <div class="card p-10 md:p-14">
            <span class="w-24 h-24 mx-auto mb-6 rounded-full bg-green-50 text-green-500 grid place-items-center text-5xl">
                <i class="fa-solid fa-circle-check"></i>
            </span>
            <h1 class="text-3xl font-extrabold text-primary-dark mb-3">جزاك الله خيراً</h1>
            <p class="text-gray-500 leading-8 mb-2">
                تم استلام طلب تبرعك بمبلغ
                <span class="font-extrabold text-primary-dark">{{ number_format($donation['amount']) }} ريال</span>
                لمشروع
                <span class="font-extrabold text-primary-dark">{{ $donation['project'] }}</span>.
            </p>
            <p class="text-gray-400 text-sm leading-7 mb-8">سيتواصل معك فريق الوقف لإتمام عملية الدفع وتوثيق تبرعك.</p>

            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('donation-projects.index') }}" class="btn-primary btn-md">
                    <i class="fa-solid fa-seedling"></i> تصفح المشاريع الوقفية
                </a>
                <a href="{{ route('home') }}" class="btn inline-flex items-center gap-2 text-primary font-bold border-2 border-primary/20 hover:bg-primary/5 px-6 py-2.5 rounded-xl">
                    الرئيسية
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
