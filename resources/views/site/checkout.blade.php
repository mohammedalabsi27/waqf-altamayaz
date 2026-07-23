@extends('layouts.app')

@section('title', 'إتمام التبرع - وقف التميز الأسري')

@section('content')

@include('site.partials.page-header', [
    'badge' => 'خطوة أخيرة',
    'title' => 'إتمام التبرع',
    'breadcrumb' => ['المشاريع الوقفية' => route('donation-projects.index'), 'إتمام التبرع' => null],
])

<section class="py-20 relative overflow-hidden">
    <div class="absolute -top-24 -start-24 w-80 h-80 bg-secondary/5 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -end-24 w-96 h-96 bg-accent/5 rounded-full blur-3xl"></div>

    <div class="relative container-x max-w-5xl">
        <form action="{{ route('checkout.store') }}" method="POST"
              x-data="{
                  card: '',
                  mm: '',
                  yy: '',
                  cvv: '',
                  formatCard() {
                      this.card = this.card.replace(/\D/g, '').slice(0, 16).replace(/(.{4})/g, '$1 ').trim();
                  },
              }"
              class="grid lg:grid-cols-5 gap-10 items-start">
            @csrf
            <input type="hidden" name="donation_project_id" value="{{ $project->id }}">

            {{-- نموذج بيانات الدفع --}}
            <div class="lg:col-span-3 card p-8 md:p-10" data-aos="fade-up">
                <div class="flex items-center justify-between flex-wrap gap-4 mb-8 pb-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <span class="w-11 h-11 rounded-xl bg-primary text-white grid place-items-center text-lg"><i class="fa-solid fa-credit-card"></i></span>
                        <h2 class="text-xl font-extrabold text-primary-dark">بيانات الدفع</h2>
                    </div>
                    <div class="flex items-center gap-2 text-3xl text-gray-300">
                        <span class="text-xs font-extrabold text-primary bg-primary/5 border border-primary/15 rounded-lg px-2.5 py-1.5">مدى</span>
                        <i class="fa-brands fa-cc-visa"></i>
                        <i class="fa-brands fa-cc-mastercard"></i>
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl px-5 py-4 mb-6 text-sm">
                        <i class="fa-solid fa-circle-exclamation ms-1"></i> {{ $errors->first() }}
                    </div>
                @endif

                <div class="space-y-5">
                    {{-- حقول البطاقة بدون name حتى لا تُرسل أو تُخزّن في السيرفر --}}
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2 text-sm">رقم البطاقة</label>
                        <div class="relative">
                            <input type="text" x-model="card" @input="formatCard()" inputmode="numeric" autocomplete="cc-number"
                                   required pattern="(\d{4} ){3}\d{4}" placeholder="0000 0000 0000 0000" dir="ltr"
                                   class="w-full rounded-xl border-gray-300 focus:border-secondary focus:ring-secondary px-4 py-3 tracking-widest text-left">
                            <i class="fa-regular fa-credit-card absolute end-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        </div>
                        <p class="text-gray-400 text-xs mt-1.5">الـ 16 رقمًا المدونة على بطاقتك</p>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2 text-sm">الاسم على البطاقة</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autocomplete="cc-name" placeholder="اسمك المدون على البطاقة"
                               class="w-full rounded-xl border-gray-300 focus:border-secondary focus:ring-secondary px-4 py-3">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2 text-sm">رقم الهاتف</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required inputmode="tel" placeholder="05xxxxxxxx" dir="ltr"
                               class="w-full rounded-xl border-gray-300 focus:border-secondary focus:ring-secondary px-4 py-3 text-left">
                        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2 text-sm">تاريخ الانتهاء</label>
                            <div class="flex gap-2" dir="ltr">
                                <input type="text" x-model="mm" @input="mm = mm.replace(/\D/g,'').slice(0,2)" required pattern="(0[1-9]|1[0-2])"
                                       placeholder="MM" inputmode="numeric" autocomplete="cc-exp-month"
                                       class="w-full rounded-xl border-gray-300 focus:border-secondary focus:ring-secondary px-4 py-3 text-center">
                                <input type="text" x-model="yy" @input="yy = yy.replace(/\D/g,'').slice(0,2)" required pattern="\d{2}"
                                       placeholder="YY" inputmode="numeric" autocomplete="cc-exp-year"
                                       class="w-full rounded-xl border-gray-300 focus:border-secondary focus:ring-secondary px-4 py-3 text-center">
                            </div>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2 text-sm">رمز الأمان</label>
                            <input type="password" x-model="cvv" @input="cvv = cvv.replace(/\D/g,'').slice(0,3)" required pattern="\d{3}"
                                   placeholder="CVV" inputmode="numeric" autocomplete="cc-csc" dir="ltr"
                                   class="w-full rounded-xl border-gray-300 focus:border-secondary focus:ring-secondary px-4 py-3 text-center">
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs leading-5">يتكون رمز الأمان من ثلاثة أرقام مطبوعة في نهاية شريط التوقيع خلف البطاقة.</p>

                    <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-4 py-3 text-xs text-gray-500">
                        <i class="fa-solid fa-lock text-secondary"></i>
                        جميع عمليات الدفع مشفّرة وآمنة، ولا يتم حفظ بيانات بطاقتك.
                    </div>
                </div>
            </div>

            {{-- ملخص التبرع --}}
            <div class="lg:col-span-2" data-aos="fade-up" data-aos-delay="120">
                <div class="card p-7 sticky top-28">
                    <h3 class="font-extrabold text-primary-dark mb-5 flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice text-secondary"></i> ملخص التبرع
                    </h3>

                    <div class="flex items-center gap-3 mb-5 pb-5 border-b border-gray-100">
                        <div class="w-16 h-16 shrink-0 rounded-xl overflow-hidden bg-gradient-to-br from-primary/10 to-secondary/10 grid place-items-center">
                            @if($project->image)
                                <img src="{{ Storage::url($project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-seedling text-2xl text-primary/30"></i>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs text-gray-400 mb-0.5">التبرع لمشروع</span>
                            <h4 class="font-bold text-primary-dark leading-6">{{ $project->name }}</h4>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block font-semibold text-gray-700 mb-2 text-sm">مبلغ التبرع (ريال)</label>
                        <input type="number" name="amount" value="{{ old('amount', $amount) }}" min="1" step="any" required
                               class="w-full rounded-xl border-gray-300 focus:border-secondary focus:ring-secondary px-4 py-3 font-extrabold text-primary-dark text-lg">
                        @error('amount') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-primary btn-lg w-full justify-center">
                        <i class="fa-solid fa-hand-holding-heart"></i> تبرع الآن
                    </button>

                    <a href="{{ route('donation-projects.show', $project) }}" class="mt-4 inline-flex items-center gap-2 text-gray-400 font-semibold text-sm hover:text-primary transition">
                        <i class="fa-solid fa-arrow-right"></i> العودة للمشروع
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection
