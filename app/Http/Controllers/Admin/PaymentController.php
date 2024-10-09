<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Show the payment form for a particular course
    public function show($courseId)
    {
        // Retrieve the course information by ID
        $course = Course::findOrFail($courseId);

        // Return the view with the course details
        return view('enroll', compact('course'));
    }

    // Process the payment
    // Process the payment
    public function process(Request $request, $courseId)
    {
        // Validate the form data
        $request->validate([
            'payment_slip' => 'required|mimes:jpeg,jpg,png|max:2048',
            'installment' => 'required',
            'installment_amount' => 'nullable|numeric|min:0',
            'installment_date' => 'nullable|date',
        ]);

        // Handle the uploaded payment slip
        if ($request->hasFile('payment_slip')) {
            $paymentSlip = $request->file('payment_slip')->store('payment_slips', 'public');
        }

        // Save the payment information
        Payment::create([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
            'payment_slip' => $paymentSlip,
            'installment' => $request->installment === 'yes',
            'installment_amount' => $request->installment_amount,
            'installment_date' => $request->installment_date,
            'status' => 'pending',
        ]);

        // Redirect to a success or confirmation page
        return redirect()->route('courses.available')->with('success', 'Payment submitted successfully. Your enrollment is pending approval.');
    }

    public function index()
    {
        $payments = Payment::with(['course', 'user'])->get();
        return view('admin.enrollrequests', compact('payments'));
    }

    // Add methods for approve and deny actions
    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        // Logic to approve the payment
        $payment->status = 'approved'; // Example status update
        $payment->save();

        return redirect()->route('enroll.requests')->with('success', 'Enrollment approved.');
    }

    public function deny($id)
    {
        $payment = Payment::findOrFail($id);
        // Logic to deny the payment
        $payment->status = 'failed'; // Example status update
        $payment->save();

        return redirect()->route('enroll.requests')->with('error', 'Enrollment denied.');
    }
}
