<?php

use App\Http\Controllers\web;

use App\Http\Controllers\web\Controller;
use App\Actions\CreateSubscription;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubscriptionsController extends Controller
{
    public function store(Request $request , CreateSubscription $create)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => ['required' , 'int'],
            'period' => ['required' , 'int' , 'min:1'],
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return redirect()->back();
        }
        $plan = Plan::findOrFail($request->post('plan_id'));
        $months = $request->post('period');

        try{
        $subscription = $create->create([
            'plan_id' => $request->post('plan_id'),
            'user_id' => $request->user()->id,
            'price' => $plan->price * $months,
            'expires_at' => now()->addMonths($months),
        ]);

        return redirect()->route('checkout' , $subscription->id);
    } catch (Throwable $e) {
        return back()->with('error' , $e->getMessage());
    }
    }
}
