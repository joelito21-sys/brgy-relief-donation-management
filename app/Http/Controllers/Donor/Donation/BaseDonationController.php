<?php

namespace App\Http\Controllers\Donor\Donation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class BaseDonationController extends Controller
{
    protected $donationType;
    
    /**
     * Get the view for the donation form
     */
    protected function getFormView()
    {
        return "donor.donations.{$this->donationType}.index";
    }
    
    /**
     * Show the donation form
     */
    public function index()
    {
        return view($this->getFormView(), [
            'breadcrumbs' => [
                ['label' => 'Donations', 'url' => route('donor.donations.index')],
                ['label' => ucfirst($this->donationType) . ' Donation']
            ],
            'pageTitle' => ucfirst($this->donationType) . ' Donation',
            'pageSubtitle' => 'Make a ' . $this->donationType . ' donation to support our cause.'
        ]);
    }
    
    /**
     * Process the donation
     */
    abstract public function store(Request $request);
    
    /**
     * Get validation rules for the donation type
     */
    abstract protected function getValidationRules();
}
