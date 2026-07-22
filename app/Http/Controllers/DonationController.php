<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Donation;
use App\Models\DonationProject;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $accounts = BankAccount::active()->ordered()->get();
        $projects = DonationProject::active()->ordered()->get(['id', 'name', 'slug']);

        // تحديد المشروع مسبقاً عند القدوم من زر «تبرع لهذا المشروع» (?project=slug)
        $selectedProjectId = null;
        if ($slug = $request->query('project')) {
            $selectedProjectId = $projects->firstWhere('slug', $slug)?->id;
        }

        return view('site.donate', compact('accounts', 'projects', 'selectedProjectId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999999'],
            'bank_account_id' => ['nullable', 'exists:bank_accounts,id'],
            'donation_project_id' => ['nullable', Rule::exists('donation_projects', 'id')->where('is_active', true)],
            'transfer_reference' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:2000'],
        ]);

        Donation::create($validated);

        return back()->with('success', 'تم استلام بيانات تبرعك بنجاح، جزاك الله خيراً وبارك في مالك.');
    }
}
