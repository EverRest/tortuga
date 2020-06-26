<?php

namespace App\Http\Controllers\Song;

use App\Http\Controllers\Controller;
use App\Http\Requests\Song\CreateRequest;
use App\Http\Requests\Song\UpdateRequest;
use App\Http\Requests\Song\UploadRequest;
use Illuminate\Http\JsonResponse;
use App\Song;
use Illuminate\Http\Response;
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(CreateRequest $request)
    {
        if (!Storage::disk('public')->exists(config('songs.paths.tmp') . $request->fileName ))
        {
            dd(config('songs.paths.tmp') . $request->fileName);
            response()->json([
                'data' => [
                    'message' => 'Can\'t find uploaded file.',
                ]], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            dd(1);
            $file = Storage::disk('public')->get(config('songs.paths.tmp') . $request->fileName );
            dd($file);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function upload(UploadRequest $request)
    {
        $file = $request->file;
        $fileName = Str::random(10).'_'.time().'.'.$file->extension();
        $file->move(config('songs.paths.tmp'), $fileName);

        return response()->json([
                'data' => [
                    'message' => 'File uploaded.',
                    'fileName' => $fileName,
                ]], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param                 $id
     * @param  UpdateRequest  $request
     */
    public function update($id, UpdateRequest $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
