<?php

namespace App\Http\Controllers\Song;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Song\CreateRequest;
use App\Http\Requests\Song\UpdateRequest;
use App\Http\Requests\Song\UploadRequest;
use App\Services\Song\ISongService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * Class SongController
 *
 * @package App\Http\Controllers\Song
 */
class SongController extends BaseController
{
    const SONGS = "List Of Songs.";
    const SONG = "Song.";
    const SONG_CREATED = "Song successfully created.";
    const FILE_NOT_FOUND = "Can't find uploaded file.";
    const FILE_NOT_UPLOADED = "Can't upload file.";
    const FILE_UPLOADED = "File uploaded.";
    const SONG_NOT_UPDATED = "Can\'t update song.";
    const SONG_UPDATED = "File uploaded.";
    const SONG_NOT_DELETED = "Error while deleting.";
    const SONG_DELETED = "Song was deleted.";
    /**
     * @var ISongService
     */
    private $songService;

    /**
     * SongController constructor.
     *
     * @param  ISongService  $songService
     */
    public function __construct(ISongService $songService)
    {
        $this->songService = $songService;
    }
    /**
     * Return a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->response($this->songService->paginated(), self::SONGS, Response::HTTP_OK);
    }

    /**
     * Add new resource.
     *
     * @param  CreateRequest  $request
     *
     * @return JsonResponse
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $file_name = $request->fileName;
        $tmp_path = config('songs.paths.tmp'). $file_name;
        $stbl_path = config('songs.paths.stbl'). $file_name;

        $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        $message = self::FILE_NOT_FOUND;
        $data = null;

        if (Storage::disk('public')->exists($tmp_path)) {
            if (!Storage::disk('public')->exists($stbl_path))
                Storage::disk('public')->move($tmp_path ,  $stbl_path);

                $song = $this->songService->create([
                        'user_id' => Auth::user()->id,
                        'title' => $request->title,
                        'artist' => $request->artist,
                        'filename' => $file_name
                    ]);

                $code = Response::HTTP_CREATED;
                $message = self::SONG_CREATED;
                $data = $song;
        }

        return $this->response($data, $message, $code);
    }

    /**
     * Upload file
     *
     * @param  UploadRequest  $request
     *
     * @return JsonResponse
     */
    public function upload(UploadRequest $request)
    {
        $file = $request->file;
        $fileName = Str::random(10).'_'.time().'.'.$file->extension();

        $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        $message = self::FILE_NOT_UPLOADED;
        $data = null;

        if ($file->move(storage_path(config('songs.paths.tmp')), $fileName))
        {
            $data = ['fileName' => $fileName];
            $message = self::FILE_UPLOADED;
            $code = Response::HTTP_OK;
        }

        return $this->response($data, $message, $code);
    }

    /**
     * Return the specified resource.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function item(int $id): JsonResponse
    {
        return $this->response($this->songService->find($id), self::SONG, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int            $id
     * @param  UpdateRequest  $request
     *
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request)
    {
        $code = Response::HTTP_NOT_ACCEPTABLE;
        $message = self::SONG_NOT_UPDATED;
        $data = $this->songService->update($id, $request->all());

        if (!!$data) {
            $code = Response::HTTP_ACCEPTED;
            $message = self::SONG_UPDATED;
        }

        return $this->response($this->songService->find($id), $message, $code);
    }

    /**
     * Delete resource by id
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $code = Response::HTTP_BAD_REQUEST;
        $message = self::SONG_NOT_DELETED;
        $data = null;

        if($this->songService->delete($id)){
            $code = Response::HTTP_OK;
            $message = self::SONG_DELETED;
            $data = $this->songService->find($id);
        }

        return $this->response($data, $message, $code);
    }
}
