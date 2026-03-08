<?php

namespace App\Livewire\Student\Settings;

use App\Models\Class\StudentJoinRequest;
use App\Models\Schools\School;
use App\Models\User;
use App\Models\User\Student;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Data extends Component {

    /**
     * Property: The student whose settings are being managed
     */
    public Student $student;

    /**
     * Property: The first name of the student
     */
    public string $firtsName;

    /**
     * Property: The last name of the student
     */
    public string $lastName;

    /**
     * Property: The email of the student
     */
    public string $email;

    /**
     * Property: The ID of the class the student
     */
    public ?int $classId = null;

    /**
     * Property: The school associated with the student
     */
    public ?int $schoolId;

    /**
     * Property: List of classes that belong to the selected school
     */
    public ?Collection $classes;

    /**
     * Property: List of schools to display in the settings
     */
    public Collection $schools;

    /**
     * Property: List of pending join requests for the student
     */
    public Collection $joinRequests;

    /**
     * Lifecycle hook: Initialize component state with student data and related schools and classes
     */
    public function mount() {
        $this->firtsName = $this->student?->user?->first_name;
        $this->lastName = $this->student?->user?->last_name;
        $this->email = $this->student?->user?->email;
        $this->classId = $this->student?->schoolClassId;
        $this->schools = School::where('status', true)
            ->whereHas('classes', function ($query) {
                $query->where('ended', false);
            })
            ->orderBy('name')
            ->get();

        $this->joinRequests = $this->getJoinRequests();
    }

    /**
     * Lifecycle hook: Load the initial list of classes based on the selected school when the component is mounted
     */
    public function boot() {
        $this->schoolId = $this->student->class?->schoolId;
        $this->classes = $this->getClasses();
    }

    /**
     * Lifecycle hook: Render the component view
     */
    public function render() {
        return view('livewire.student.settings.data');
    }

    /**
     * Event handler: Update the list of classes when the selected school changes
     */
    public function updatedSchoolId() {
        $this->classes = $this->getClasses();
    }

    /**
     * Event handler: Validate and save the updated student data, including name, email, and class association
     */
    public function save() {
        $this->validate([
            'firtsName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'classId' => 'nullable|exists:school_classes,id',
        ]);

        if (User::where('email', $this->email)->whereNot('id', $this->student->userId)->exists()) {
            $this->addError('email', 'L\'email è già in uso da un altro utente.');
            return;
        }

        $this->student->user->update([
            'first_name' => $this->firtsName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ]);

        if ($this->classId != $this->student->schoolClassId) {
            StudentJoinRequest::where('requesting_student_id', $this->student->id)->delete();

            StudentJoinRequest::firstOrCreate([
                'requesting_student_id' => $this->student->id,
                'class_id' => $this->classId,
            ]);

            $this->joinRequests = $this->getJoinRequests();
            $this->classId = $this->student->schoolClassId;
        }

        session()->flash('success', 'Dati aggiornati con successo.');
    }

    /**
     * Get the list of classes that belong to the selected school
     */
    public function getClasses(): ?Collection {
        return $this->schoolId ? School::find($this->schoolId)?->classes()->with('tutor', 'tutor.user')
            ->orderByDesc('name')
            ->where('ended', false)
            ->get() : null;
    }

    /**
     * Get the list of pending join requests for the student
     */
    public function getJoinRequests(): Collection {
        return StudentJoinRequest::where('requesting_student_id', $this->student->id)->get();
    }
}
