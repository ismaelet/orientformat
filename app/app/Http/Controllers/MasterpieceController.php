<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\Masterpiece;
use App\Models\User\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterpieceController extends Controller {

    /**
     * Handle the masterpiece upload
     */
    public function upload(Request $request) {
        // Validate the uploaded file
        $request->validate([
            'title' => 'required|string|max:255',
            'setting' => 'required|integer',
            'mode' => 'required|integer',
            'type' => 'required|integer',
            'skill' => 'required|integer',
            'file' => 'required|mimes:pdf|max:25600', // Max 25MB
        ]);

        $file = $request->file('file');
        $student = $request->user();

        // Create a new masterpiece record
        $masterpiece = Masterpiece::create([
            'student_id' => $student->id,
            'title' => $request->input('title'),
            'setting' => $request->input('setting'),
            'mode' => $request->input('mode'),
            'type' => $request->input('type'),
            'skill' => $request->input('skill'),
        ]);

        // Store the file
        $filePath = $masterpiece->storageFilePath();
        Storage::disk('public')->putFileAs('', $file, $filePath);

        return redirect()->back()->with('success', 'Capolavoro caricato con successo!');
    }

    /**
     * Handle the masterpiece download
     */
    public function download(Student $student, Masterpiece $masterpiece) {
        $title = str_replace(['/', '\\'], '-', $masterpiece->title);

        return FileHelper::download(
            $masterpiece->storageFilePath(),
            "{$title}.pdf"
        );
    }
}
