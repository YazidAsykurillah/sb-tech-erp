<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now_date = Carbon::now();
        $from = $now_date->toDateString();
        $next_week = $now_date->addDays(7)->toDateString();
        $last_week = $now_date->subWeek(2)->toDateString();
        //echo $last_week;exit();
        //Block get overdue invoice customers (within this week)
        $invoice_customer_over_due_in_week = \DB::table('invoice_customers')
            ->where('status', 'pending')
            ->whereBetween('due_date', [$from, $next_week])
            ->get();
        //ENDBlock get overdue invoice customers (within this week)

        //Block get overdue invoice customers over the last week
        $invoice_customer_over_due_over_last_week = \DB::table('invoice_customers')
            ->where('status', 'pending')
            ->where('due_date', '<', $from)
            ->get();
        //ENDBlock get overdue invoice customers over the last week

        //Block get overdue invoice vendors (within this week)
        $invoice_vendor_over_due_in_week = \DB::table('invoice_vendors')
            ->where('status', 'pending')
            ->whereBetween('due_date', [$from, $next_week])
            ->get();
        //ENDBlock get overdue invoice vendors (within this week)

        //Block get overdue invoice vendor over the last week
        $invoice_vendor_over_due_over_last_week = \DB::table('invoice_vendors')
            ->where('status', 'pending')
            ->where('due_date', '<=', $last_week)
            ->get();
        //ENDBlock get overdue invoice vendor over the last week

        //Block pending internal request
        $pending_internal_requests = \DB::table('internal_requests')
            ->where('status', 'pending')
            ->get();
        //ENDBlock pending internal request

        //Block checked internal request
        $checked_internal_requests = \DB::table('internal_requests')
            ->where('status', 'checked')
            ->get();
        //ENDBlock checked internal request

        //Block approved internal request
        $approved_internal_requests = \DB::table('internal_requests')
            ->where('status', 'approved')
            ->get();
        //ENDBlock approved internal request

        //Block pending settlement
        $pending_settlements = \DB::table('settlements')
            ->whereIn('status', ['pending'])
            ->get();
        //ENDBlock pending settlement

        //Block checked settlement
        $checked_settlements = \DB::table('settlements')
            ->whereIn('status', ['checked'])
            ->get();
        //ENDBlock checked settlement

        //Block approved settlement
        $approved_settlements = \DB::table('settlements')
            ->whereIn('status', ['approved'])
            ->get();
        //ENDBlock approved settlement

        //Block pending cashbonds
        $pending_cashbonds = \DB::table('cashbonds')
            ->where('status', 'pending')
            ->get();
        //ENDBlock pending cashbonds

        //Block checked cashbonds
        $checked_cashbonds = \DB::table('cashbonds')
            ->where('status', 'checked')
            ->get();
        //ENDBlock checked cashbonds

        //Block approved cashbonds
        $approved_cashbonds = \DB::table('cashbonds')
            ->where('status', 'approved')
            ->get();
        //ENDBlock approved cashbonds

        return view('home')
            ->with('invoice_customer_over_due_in_week', $invoice_customer_over_due_in_week)
            ->with('invoice_customer_over_due_over_last_week', $invoice_customer_over_due_over_last_week)
            ->with('invoice_vendor_over_due_in_week', $invoice_vendor_over_due_in_week)
            ->with('invoice_vendor_over_due_over_last_week', $invoice_vendor_over_due_over_last_week)
            ->with('pending_internal_requests', $pending_internal_requests)
            ->with('checked_internal_requests', $checked_internal_requests)
            ->with('approved_internal_requests', $approved_internal_requests)
            ->with('pending_settlements', $pending_settlements)
            ->with('checked_settlements', $checked_settlements)
            ->with('approved_settlements', $approved_settlements)
            ->with('pending_cashbonds', $pending_cashbonds)
            ->with('checked_cashbonds', $checked_cashbonds)
            ->with('approved_cashbonds', $approved_cashbonds);
    }
}
