<?php

namespace App\Http\Controllers;

use App\Models\DonationProject;

class DonationProjectController extends Controller
{
    public function index()
    {
        $projects = DonationProject::active()
            ->ordered()
            ->withSum('confirmedDonations as confirmed_donations_sum_amount', 'amount')
            ->get();

        return view('site.donation-projects.index', compact('projects'));
    }

    public function show(DonationProject $donationProject)
    {
        abort_unless($donationProject->is_active, 404);

        $donationProject->loadSum('confirmedDonations as confirmed_donations_sum_amount', 'amount');

        return view('site.donation-projects.show', compact('donationProject'));
    }
}
