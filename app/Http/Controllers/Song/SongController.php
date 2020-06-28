<?php

namespace App\Http\Controllers\Song;

use App\Http\Controllers\Controller;
use App\Http\Requests\Song\CreateRequest;
use App\Http\Requests\Song\UpdateRequest;
use App\Http\Requests\Song\UploadRequest;
use Illuminate\Http\JsonResponse;
use App\Song;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * Class SongController
 *
 * @package App\Http\Controllers\Song
 */
class SongController extends Controller
{
    /**
     * Return a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Song::all()], Response::HTTP_OK);
    }

    /**
     * Add new resource.
     *
     * @return JsonResponse
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $file_name = $request->fileName;
        $tmp_path = config('songs.paths.tmp'). $file_name;
        $stbl_path = config('songs.paths.stbl'). $file_name;

        if (Storage::disk('public')->exists($tmp_path)) {
            if (!Storage::disk('public')->exists($stbl_path))
                Storage::disk('public')->move($tmp_path ,  $stbl_path);

            Song::firstOrCreate([
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'artist' => $request->artist,
                'filename' => $file_name
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Song successfully created.',
                ]], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'data' => [
                    'message' => 'Can\'t find uploaded file.',
                ]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Upload filee
     *
     * @return JsonResponse
     */
    public function upload(UploadRequest $request)
    {
        $file = $request->file;
        $fileName = Str::random(10).'_'.time().'.'.$file->extension();
        $file->move(public_path(config('songs.paths.tmp')), $fileName);

        return response()->json([
                'data' => [
                    'message' => 'File uploaded.',
                    'fileName' => $fileName,
                ]], Response::HTTP_OK);
    }

    /**
     * Return the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function item($id): JsonResponse
    {
        if (Song::where('id', $id)->exists()) {
            return response()->json([
                'data' => Song::where('id', $id)->get()
                    ->toJson(JSON_PRETTY_PRINT)], Response::HTTP_OK);
        } else {
            return response()->json([
                "message" => "Song not found"
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param                 $id
     * @param  UpdateRequest  $request
     */
    public function update($id, UpdateRequest $request)
    {
        $song = Song::findOrFail($id);

        $song->title = $request->title;
        $song->artist = $request->artist;

        if ($song->save()) {
            return response()->json([
                'data' => [
                    "message" => "Song was updated."
                ]], Response::HTTP_OK);
        } else {
            return response()->json([
                "message" => "Can\'t update song.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         "
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $song = Song::findOrfail($id);

        if($song->delete()){
            return response()->json([
                'data' => [
                    "message" => "Song was deleted."
                ]], Response::HTTP_OK);
        } else {
            return response()->json([
                'data' => [
                    "message" => "Error while deleting."
                ]], Response::HTTP_BAD_REQUEST);
        }
    }
}
