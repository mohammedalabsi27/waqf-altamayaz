<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationProject;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    /** صفحة إتمام التبرع (بيانات الدفع) */
    public function show(Request $request)
    {
        $project = DonationProject::active()
            ->where('slug', $request->query('project'))
            ->first();

        if (! $project) {
            return redirect()->route('donation-projects.index');
        }

        $amount = (float) $request->query('amount', 0);
        $amount = $amount >= 1 ? $amount : null;

        return view('site.checkout', compact('project', 'amount'));
    }

    /**
     * تسجيل طلب التبرع.
     * ملاحظة أمنية: حقول البطاقة في النموذج بدون name فلا تصل للسيرفر ولا تُخزّن إطلاقاً.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999999'],
            'donation_project_id' => ['required', Rule::exists('donation_projects', 'id')->where('is_active', true)],
        ], [], [
            'name' => 'الاسم على البطاقة',
            'phone' => 'رقم الهاتف',
            'amount' => 'مبلغ التبرع',
            'donation_project_id' => 'المشروع',
        ]);

        $donation = Donation::create($validated + [
            'status' => Donation::STATUS_NEW,
            'note' => 'تبرع عبر صفحة الدفع الإلكتروني',
        ]);

        return redirect()
            ->route('checkout.success')
            ->with('checkout_donation', [
                'project' => $donation->project->name,
                'amount' => $donation->amount,
            ]);
    }

    /** صفحة الشكر بعد التبرع */
    public function success()
    {
        if (! session()->has('checkout_donation')) {
            return redirect()->route('donation-projects.index');
        }

        return view('site.checkout-success', ['donation' => session('checkout_donation')]);
    }
}
