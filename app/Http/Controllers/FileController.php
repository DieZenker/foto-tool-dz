<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\File;
use App\Models\FileComment;
use App\Models\FileLog;
use App\Models\FilePublication;
use App\Models\Platform;
use App\Models\Tag;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show(File $file)
    {
        return view('file.show')->with(compact('file'));
    }

    public function download(File $file)
    {
        return Storage::disk('uploads')->download($file->file, $file->name);
    }

    public function downloadThumbail(File $file)
    {
        return Storage::disk('uploads')->download($file->thumbnail);
    }

    public function addComment(string $comment, File $file) : void
    {
        FileComment::create([
            'comment' => $comment,
            'user_id' => Auth::user()->id,
            'file_id' => $file->id
        ]);
    }

    private function addTags(array $tags, File $file) : void
    {
        $allTagNames = $tags;

        $existingTags = Tag::whereIn('title', $allTagNames)->get();
        $existingTagNames = $existingTags->pluck('title')->toArray();

        $newTagNames = array_diff($allTagNames, $existingTagNames);
        foreach ($newTagNames as $newTagName) {
            $tag = Tag::create(['title' => $newTagName]);
            $existingTags->add($tag);
        }

        $file->tags()->attach($existingTags);

        flash('Die Tags wurden erfolgreich eingetragen.', 'success');

        try{
            $tagNames = $existingTags->pluck('title')->unique()->toArray();
            \fileLog('Tags hinzugefügt. Tags: ' . implode(', ', $tagNames), $file);
        } catch (\Exception $ex) {}
    }

    public function tagDelete(File $file, Tag $tag)
    {
        $file->tags()->detach($tag->id);
        try{
            \fileLog('Tag gelöscht. Tag: ' . $tag->title, $file);
        } catch (\Exception $ex) {}

        return redirect()->back();
    }

    public function markDelete(File $file, Person $person)
    {
        $file->people()->detach($person->id);

        try{
            \fileLog('Personenmarkierung gelöscht. Person: ' . $person->name, $file);
        } catch (\Exception $ex) {}

        return redirect()->back();
    }

    private function markPersons(array $personsNames, File $file) : void
    {
        $allPersonNames = $personsNames;
        $existingPersons = Person::whereIn('name', $allPersonNames)->get();
        $existingPersonNames = $existingPersons->pluck('name')->toArray();

        $newPersonNames = array_diff($allPersonNames, $existingPersonNames);
        foreach ($newPersonNames as $newPersonName) {
            $person = Person::create([
                'name' => $newPersonName
            ]);
            $existingPersons->add($person);
        }

        $file->persons()->attach($existingPersons);
        flash('Die Personen wurden erfolgreich markiert.', 'success');
        try{
            $personNames = $existingPersons->pluck('name')->unique()->toArray();
            \fileLog('Personen verlinkt. Personen: ' . implode(', ', $personNames), $file);
        } catch (\Exception $ex) {}
    }

    private function addPublication(string $platform, ?string $publicationDate=null, ?string $comment=null, ?string $link=null, File $file) : void
    {
        $platform = Platform::firstOrCreate(['name' => $platform]);
        if (!is_null($publicationDate)) {
            try {
                $publicationDate = Carbon::parse($publicationDate)->format('Y-m-d H:i:s');
            } catch (\Exception $ex) {
                $publicationDate = null;
            }
        }

        FilePublication::create([
            'platform_id' => $platform->id,
            'file_id' => $file->id,
            'publication_date' => $publicationDate,
            'comment' => $comment,
            'link' => $link
        ]);

        flash('Die Veröffentlichung wurde eingetragen.', 'success');
        \fileLog('Neue Veröffentlichung eingetragen. Platform: ' . $platform->name, $file);
    }

    public function update(Request $request, File $file)
    {
        if ($request->has('name') && !empty($request->name)) {
            $file->name = $request->input('name');
            $file->save();
        }

        if ($request->has('platform') && !empty($request->platform))
            $this->addPublication($request->platform, $request->publication_date, $request->publication_comment, $request->link, $file);

        if ($request->has('persons'))
            $this->markPersons($request->persons, $file);

        if ($request->has('tags') && is_array($request->tags))
            $this->addTags($request->tags, $file);

        if ($request->has('comment') && !empty($request->comment))
            $this->addComment($request->comment, $file);

        return redirect()->route('file.show', $file);
    }

    public function delete(File $file)
    {
        $album  = $file->album;
        $file->delete();

        flash('Die Datei wurde erfolgreich gelöscht.', 'success');

        return redirect()->route('album.show', $album);
    }

    public function restore($file)
    {
        $file = File::withTrashed()->find($file);
        $album = Album::withTrashed()->find($file->album_id);
        if ($album->trashed())
            $album->restore();

        $file->restore();

        flash('Die Datei wurde erfolgreich wiederhergestellt.');

        return redirect()->back();
    }

    public function publicationDelete(File $file, FilePublication $publication)
    {
        $publication->delete();
        flash('Der Veröffentlichungskanal wurde erfolgreich gelöscht.');

        return redirect()->route('file.show', $file);
    }
}
