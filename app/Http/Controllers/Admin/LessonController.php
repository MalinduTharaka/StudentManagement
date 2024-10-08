<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    public function index(Course $course)
    {
        $lessons = Lesson::where('course_id', $course->id)->get();
        return view('lessons.index', compact('course', 'lessons'));
    }


    public function edit(Lesson $lesson)
    {
        return view('lessons.edit', compact('lesson'));
    }


    public function create(Course $course)
    {
        return view('lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_link' => 'nullable|url',
            'other_link' => 'nullable|url',
            'status' => 'required|boolean',
        ]);

        $lesson = new Lesson($validated);
        $lesson->course_id = $course->id;
        $lesson->save();

        return redirect()->route('courses.show', $course->id)->with('success', 'Lesson added successfully.');
    }


    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_link' => 'nullable|url',
            'other_link' => 'nullable|url',
            'status' => 'required|boolean',
        ]);

        $lesson->update($validated);

        return redirect()->route('courses.showLessons', $lesson->course_id)->with('success', 'Lesson updated successfully.');
    }


    public function destroy(Lesson $lesson)
    {
        $lesson->update(['status' => 2]); // Set status as "deleted"
        
        return redirect()->route('courses.showLessons', $lesson->course_id)->with('success', 'Lesson status updated to deleted.');
    }


    public function trash()
    {
        $deletedLessons = Lesson::where('status', 2)->get();
        return view('lessons.trash', compact('deletedLessons'));
    }

    
    public function restore(Lesson $lesson)
    {
        $lesson->update(['status' => 1]);  // Set the status back to active

        return redirect()->route('lessons.trash')->with('success', 'Lesson restored successfully.');
    }






}
