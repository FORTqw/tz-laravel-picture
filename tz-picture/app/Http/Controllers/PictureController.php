<?php

namespace App\Http\Controllers;
use App\Models\Picture;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use ZipArchive;


class PictureController extends Controller
{
    public function create()
    {
        return view('pictures.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'pictures' => 'required|array|max:5',
            'pictures.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pictures = $request->file('pictures');

        foreach ($pictures as $picture) {
            $name = Str::lower(Str::ascii(pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME)));
            $filename = $name . '-' . time() . '.' . $picture->extension();

            $picture->move(public_path('uploads'), $filename);

            Picture::create([
                'name' => $filename,
                'uploaded_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Изображения успешно загружены');
    }

    public function index(Request $request)
    {
        $pictures = Picture::all();

        if ($request->has('sort') && $request->get('sort') === 'date') {
            $pictures = $pictures->sortByDesc('created_at');
        } elseif ($request->has('sort') && $request->get('sort') === 'name') {
            $pictures = $pictures->sortBy('name');
        }

        return view('pictures.index', compact('pictures'));
    }

    public function downloadZip($filename)
    {
        $picture = Picture::where('name', $filename)->firstOrFail();

        $zip = new \ZipArchive();
        $zipFileName = $picture->name . '.zip';
        $zip->open($zipFileName, \ZipArchive::CREATE);
        $zip->addFile(public_path('uploads/' . $picture->name), $picture->name);
        $zip->close();

        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zipFileName);
        header('Content-Length: ' . filesize($zipFileName));
        readfile($zipFileName);
        unlink($zipFileName);
    }

    public function getAllPictures()
    {
        $pictures = Picture::all();
        return response()->json($pictures);
    }

    public function getPicture($id)
    {
        $picture = Picture::find($id);
        if (!$picture) {
            return response()->json(['message' => 'File not found'], 404);
        }
        return response()->json($picture);
    }
}
