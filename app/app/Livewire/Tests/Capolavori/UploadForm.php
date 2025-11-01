<?php

namespace App\Livewire\Tests\Capolavori;

use App\Models\Masterpiece;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UploadForm extends Component {

    use WithFileUploads;

    /**
     * Property: The title of the masterpiece
     */
    public string $title = '';

    /**
     * Property: The possible settings
     */
    public array $settings = [];

    /**
     * Property: The possible modes
     */
    public array $modes = [];

    /**
     * Property: The possible types
     */
    public array $types = [];

    /**
     * Property: The possible skills
     */
    public array $skills = [];

    /**
     * Property: The area of the masterpiece
     */
    public int $setting = 0;

    /**
     * Property: The mode of the masterpiece
     */
    public int $mode = 0;

    /**
     * Property: The type of the masterpiece
     */
    public int $type = 0;

    /**
     * Property: The skill of the masterpiece
     */
    public int $skill = 0;

    /**
     * Property: The uploaded file
     */
    // #[Validate('file', 'required|file|max:25600|mimes:pdf')]
    // public $file;

    /**
     * Property: The number of masterpieces uploaded by the student
     */
    public int $masterpieceCount = 0;

    /**
     * Property: Indicates if the masterpiece has been uploaded
     */
    public bool $uploaded = false;

    /**
     * Lifecycle method: Mount the component
     */
    public function mount() {
        $this->settings = Masterpiece::SETTINGS;
        $this->modes = Masterpiece::MODES;
        $this->types = Masterpiece::TYPES;
        $this->skills = Masterpiece::SKILLS;
        $this->masterpieceCount = student()->masterpieces()->count();
    }

    /**
     * Lifecycle method: Render the component view
     */
    public function render() {
        return view('livewire.tests.capolavori.upload-form');
    }

    /**
     * Action: Upload a masterpiece
     */
    public function save() {
        // // Validate the input data
        // $this->validate([
        //     'title' => 'required|string|max:255',
        //     'setting' => 'required|integer',
        //     'mode' => 'required|integer',
        //     'type' => 'required|integer',
        //     'skill' => 'required|integer',
        //     'file' => 'required|file|max:25600|mimes:pdf',
        // ]);

        // // Create a new masterpiece record
        // $masterPiece = Masterpiece::create([
        //     'student_id' => student()->id,
        //     'title' => $this->title,
        //     'setting' => $this->setting,
        //     'mode' => $this->mode,
        //     'type' => $this->type,
        //     'skill' => $this->skill,
        // ]);

        // // Handle file upload
        // $this->file->storeAs('masterpieces', $masterPiece->storageFilePath(), 'public');

        // // Reset the form fields
        // $this->reset(['title', 'setting', 'mode', 'type', 'skill']);

        // // Indicate that the masterpiece has been uploaded
        // $this->uploaded = true;

        // // Flash a success message
        // session()->flash('success', 'Capolavoro caricato con successo!');

        // // Update the masterpiece count
        // $this->masterpieceCount = student()->load('masterpieces')->masterpieces->count();
    }

    /**
     * Event handler: Update masterpiece count after deletion
     */
    #[On('masterpieceDeleted')]
    public function masterpieceDeleted() {
        $this->masterpieceCount = student()->load('masterpieces')->masterpieces->count();
    }
}
