<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Enrollment;
use App\Models\Payment;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::paginate(10);
        return view('courses.index', compact('courses'));
    }


      public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }


    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'installment' => 'nullable|boolean',
            'installment_1' => 'nullable|numeric',
            'installment_2' => 'nullable|numeric',
            'installment_3' => 'nullable|numeric',
            'installment_4' => 'nullable|numeric',
            'installment_5' => 'nullable|numeric',
            'installment_6' => 'nullable|numeric',
            'start_date' => 'required|date',
            'duration' => 'required|string',
            'image' => 'nullable|image|max:1024', // Image validation
        ]);

        // Auto-generate a course ID
        $course = new Course($validated);
        $course->course_id = Str::random(10);

        // Handle image upload
        if ($request->hasFile('image')) {
            $course->image = $request->file('image')->store('courses', 'public'); // Store image in 'public/courses'
        }

        $course->save();  // Save course to the database

        return redirect()->route('courses.index')->with('success', 'Course added successfully.');
    }





    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }


    public function update(Request $request, Course $course)
{
    // Validate the request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'original_price' => 'required|numeric',
        'discount_price' => 'nullable|numeric',
        'installment' => 'nullable|boolean',
        'installment_1' => 'nullable|numeric',
        'installment_2' => 'nullable|numeric',
        'installment_3' => 'nullable|numeric',
        'installment_4' => 'nullable|numeric',
        'installment_5' => 'nullable|numeric',
        'installment_6' => 'nullable|numeric',
        'start_date' => 'required|date',
        'duration' => 'required|string',
        'image' => 'nullable|image|max:1024', // Ensure image validation
    ]);

    // Check if a new image was uploaded
    if ($request->hasFile('image')) {
        // Store the new image in the 'public/courses' directory
        $filePath = $request->file('image')->store('courses', 'public');
        $course->image = $filePath; // Update the image path
        $validated['image'] = $course->image;
    } else {
        // If no new image is uploaded, keep the old image path
        $validated['image'] = $course->image;
    }


    // Update the course with the validated data
    $course->update($validated);

    return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
}




    public function destroy(Course $course)
    {
        $course->update(['status' => 'deleted']);

        return redirect()->route('courses.index')->with('success', 'Course status updated to deleted.');
    }




    public function available()
    {
        $courses = Course::whereIn('status', ['ongoing', 'waiting'])->get(); // Fetch courses with specific status
    return view('courses.available', compact('courses')); // Pass the courses to the view
    }

    public function enroll($id)
    {
        $course = Course::findOrFail($id);
    $user = auth()->user(); // Fetch the authenticated user

    return view('courses.enroll', compact('course', 'user'));
        // $course = Course::findOrFail($id);
        // return view('courses.enroll', compact('course'));
    }



    public function storePayment(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'payment_option' => 'required',
            'payment_method' => 'required_if:payment_option,full_payment',
            'installment_payment_method' => 'required_if:payment_option,installment',
            'payment_slip' => 'nullable|file|image|max:2048',
            'installment_payment_slip' => 'nullable|file|image|max:2048',
        ]);

        $course = Course::findOrFail($id);

        $payment = new Payment();
        $payment->course_id = $course->id;
        $payment->user_id = auth()->id();

        // Set the payment amount based on option
        if ($request->payment_option == 'full_payment') {
            $payment->amount = $course->original_price-$course->discount_price ?? $course->original_price; // Ensure a valid amount
            $payment->payment_method = $request->payment_method; // Set payment method
            if ($request->payment_method == 'bank_draft') {
                if ($request->hasFile('payment_slip')) {
                    $payment->payment_slip = $request->file('payment_slip')->store('payment_slips');
                }
            }
        } elseif ($request->payment_option == 'installment') {
            $installmentAmount = ($course->discount_price ?? $course->original_price) / ($course->installment_count ?? 1); // Ensure valid count
            $payment->amount = $installmentAmount;
            $payment->payment_method = $request->installment_payment_method; // Set payment method for installment
            if ($request->installment_payment_method == 'bank_draft') {
                if ($request->hasFile('installment_payment_slip')) {
                    $payment->payment_slip = $request->file('installment_payment_slip')->store('installment_payment_slips');
                }
            }
        }

        // Check if amount and payment_method are valid
        if (is_null($payment->amount) || is_null($payment->payment_method)) {
            return back()->withErrors('Payment amount or method cannot be null.');
        }

        // Save the payment record
        $payment->save();

        return redirect()->route('courses.show', $course->id)->with('success', 'Payment successfully submitted!');
    }




}

