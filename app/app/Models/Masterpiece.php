<?php

namespace App\Models;

use App\Models\User\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Masterpiece extends Model {

    /**
     * Property: The attributes that are mass assignable
     */
    protected $fillable = [
        'student_id',
        'title',
        'setting',
        'mode',
        'type',
        'skill',
    ];

    /**
     * Property: The possible settings
     */
    public const array SETTINGS = ['Scolastico', 'Extra-scolastico'];

    /**
     * Property: The possible modes
     */
    public const array MODES = ['Individuale', 'Di gruppo'];

    /**
     * Property: The possible types
     */
    public const array TYPES = ['Culturale e artistica', 'Letteraria', 'Nel campo delle lingue straniere', 'Nel campo della comunicazione', 'Musicale e/o coreutica', 'In campo matematico, scientifico, tecnico, tecnologico', 'Motoria/sportiva', 'Di cittadinanza attiva e di volontariato', 'Professionale', 'Altre attività'];

    /**
     * Property: The possible skills
     */
    public const array SKILLS = ['Competenza alfabetica funzionale (Comunicazione nella lingua italiana)', 'Competenza multilinguistica (Comunicazione nelle lingue straniere)', 'Competenza digitale', 'Competenza personale, sociale e capacità di imparare a imparare', 'Competenza in materia di cittadinanza', 'Competenza imprenditoriale (Spirito di iniziativa e imprenditorialità)', 'Consapevolezza ed espressione culturale', 'Non sono in grado di indicare quale competenza ho sviluppato'];

    /**
     * Relationship: The student who created the masterpiece
     */
    public function student(): BelongsTo {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the public URL for the masterpiece PDF
     */
    public function url(): string {
        return route('masterpieces.download', ['student' => $this->student, 'masterpiece' => $this]);
    }

    /**
     * Get the storage file path for the masterpiece PDF
     */
    public function storageFilePath(): string {
        return 'masterpieces/' . $this->student_id . '-' . $this->id . '.pdf';
    }
}
