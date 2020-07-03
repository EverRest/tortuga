<?php

namespace App\Http\Controllers\Playlist;

use App\Http\Controllers\Controller;
use App\Playlist;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Song\CreateRequest;
use App\Http\Requests\Song\UpdateRequest;

/**
 * Class PlaylistController
 *
 * @package App\Http\Controllers\Playlist
 */
class PlaylistController extends Controller
{
    /**
     * Return a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Playlist::all()], Response::HTTP_OK);
    }

    /**
     * Add new resource.
     *
     * @return JsonResponse
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $file_name = $request->fileName;
        $tmp_path = config('playlists.paths.tmp'). $file_name;
        $stbl_path = config('playlists.paths.stbl'). $file_name;

        if (Storage::disk('public')->exists($tmp_path)) {
            if (!Storage::disk('public')->exists($stbl_path))
                Storage::disk('public')->move($tmp_path ,  $stbl_path);

            playlist::firstOrCreate([
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'artist' => $request->artist,
                'filename' => $file_name
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Playlist successfully created.',
                ]], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'data' => [
                    'message' => 'Can\'t create playlist.',
                ]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
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
        if (playlist::where('id', $id)->exists()) {
            return response()->json([
                'data' => Playlist::where('id', $id)->get()
                    ->toJson(JSON_PRETTY_PRINT)], Response::HTTP_OK);
        } else {
            return response()->json([
                "message" => "Playlist not found"
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
        $playlist = playlist::findOrFail($id);

        $playlist->title = $request->title;
        $playlist->artist = $request->artist;

        if ($playlist->save()) {
            return response()->json([
                'data' => [
                    "message" => "playlist was updated."
                ]], Response::HTTP_OK);
        } else {
            return response()->json([
                "message" => "Can\'t update playlist.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         "
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
        $playlist = playlist::findOrfail($id);

        if($playlist->delete()){
            return response()->json([
                'data' => [
                    "message" => "playlist was deleted."
                ]], Response::HTTP_OK);
        } else {
            return response()->json([
                'data' => [
                    "message" => "Error while deleting."
                ]], Response::HTTP_BAD_REQUEST);
        }
    }
}
