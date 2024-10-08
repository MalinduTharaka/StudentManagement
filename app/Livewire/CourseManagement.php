<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Course;

class CourseManagement extends Component
{
    use WithPagination;

    public $course_id, $name, $description, $original_price, $discount_price, $allow_installment = false, $installments = [], $start_date, $duration, $status = 'waiting', $active = true;
    public $updateMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'original_price' => 'required|numeric',
        'discount_price' => 'nullable|numeric',
        'allow_installment' => 'boolean',
        'installments.*' => 'nullable|numeric',
        'start_date' => 'required|date',
        'duration' => 'required|integer',
        'status' => 'required|in:waiting,ongoing,completed',
        'active' => 'boolean',
    ];

    public function render()
    {
        return view('livewire.course-management', [
            'courses' => Course::paginate(10),
        ]);
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->original_price = '';
        $this->discount_price = '';
        $this->allow_installment = false;
        $this->installments = [];
        $this->start_date = '';
        $this->duration = '';
        $this->status = 'waiting';
        $this->active = true;
    }

    public function store()
    {
        $this->validate();
        Course::create([
            'name' => $this->name,
            'description' => $this->description,
            'original_price' => $this->original_price,
            'discount_price' => $this->discount_price,
            'allow_installment' => $this->allow_installment,
            'installments' => json_encode($this->installments),
            'start_date' => $this->start_date,
            'duration' => $this->duration,
            'status' => $this->status,
            'active' => $this->active,
        ]);
        session()->flash('message', 'Course Added Successfully.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->course_id = $id;
        $this->name = $course->name;
        $this->description = $course->description;
        $this->original_price = $course->original_price;
        $this->discount_price = $course->discount_price;
        $this->allow_installment = $course->allow_installment;
        $this->installments = json_decode($course->installments, true);
        $this->start_date = $course->start_date;
        $this->duration = $course->duration;
        $this->status = $course->status;
        $this->active = $course->active;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();
        $course = Course::find($this->course_id);
        $course->update([
            'name' => $this->name,
            'description' => $this->description,
            'original_price' => $this->original_price,
            'discount_price' => $this->discount_price,
            'allow_installment' => $this->allow_installment,
            'installments' => json_encode($this->installments),
            'start_date' => $this->start_date,
            'duration' => $this->duration,
            'status' => $this->status,
            'active' => $this->active,
        ]);
        session()->flash('message', 'Course Updated Successfully.');
        $this->resetInputFields();
        $this->updateMode = false;
    }

    public function delete($id)
    {
        Course::find($id)->delete();
        session()->flash('message', 'Course Deleted Successfully.');
    }
}
