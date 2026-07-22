<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationProject;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DonationProjectController extends Controller
{
    public function index()
    {
        $projects = DonationProject::ordered()
            ->withSum('confirmedDonations as confirmed_donations_sum_amount', 'amount')
            ->get();

        return view('admin.donation-projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.donation-projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('donation-projects', 'public');
        }

        DonationProject::create($validated);

        return redirect()->route('admin.donation-projects.index')->with('success', 'تمت الإضافة بنجاح');
    }

    public function edit(DonationProject $donationProject)
    {
        return view('admin.donation-projects.edit', ['project' => $donationProject]);
    }

    public function update(Request $request, DonationProject $donationProject): RedirectResponse
    {
        $validated = $this->validated($request, $donationProject->id);

        if ($request->hasFile('image')) {
            if ($donationProject->image) {
                Storage::disk('public')->delete($donationProject->image);
            }
            $validated['image'] = $request->file('image')->store('donation-projects', 'public');
        }

        $donationProject->update($validated);

        return redirect()->route('admin.donation-projects.index')->with('success', 'تم التحديث بنجاح');
    }

    public function destroy(DonationProject $donationProject): RedirectResponse
    {
        if ($donationProject->image) {
            Storage::disk('public')->delete($donationProject->image);
        }

        $donationProject->delete();

        return back()->with('success', 'تم الحذف بنجاح');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:donation_projects,slug'.($ignoreId ? ",{$ignoreId}" : '')],
            'image' => ['nullable', 'image', 'max:2048'],
            'description' => ['nullable', 'string'],
            'target_amount' => ['required', 'numeric', 'min:1', 'max:999999999'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ]);
    }
}
