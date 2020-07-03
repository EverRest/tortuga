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
        return $this->response($this->songService->all(), 'Songs', Response::HTTP_OK);
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
        $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        $message = "Can't find uploaded file.";
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
                $message = "Song successfully created.";
                $data = $song;
        }

        return $this->response($data, $message, $code);
    }

    /**
     * Upload file
     *
     * @return JsonResponse
     */
    public function upload(UploadRequest $request)
    {
        $file = $request->file;
        $fileName = Str::random(10).'_'.time().'.'.$file->extension();
        $file->move(public_path(config('songs.paths.tmp')), $fileName);

        return $this->response(['fileName' => $fileName], 'File uploaded.', Response::HTTP_OK);
    }

    /**
     * Return the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function item(int $id): JsonResponse
    {
        return $this->response($this->songService->find($id), '', Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int            $id
     * @param  UpdateRequest  $request
     */
    public function update(int $id, UpdateRequest $request)
    {
        $code = Response::HTTP_NOT_ACCEPTABLE;
        $message = "Can\'t update song.";
        $data = $this->songService->update($id, $request->all());

        if (!!$data) {
            $code = Response::HTTP_ACCEPTED;
            $message = "Song was updated.";
        }

        return $this->response($this->songService->find($id), $message, $code);
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $code = Response::HTTP_BAD_REQUEST;
        $message = "Error while deleting.";
        $data = null;

        if($this->songService->delete($id)){
            $code = Response::HTTP_OK;
            $message = "Song was deleted.";
            $data = $this->songService->find($id);
        }

        return $this->response($data, $message, $code);
    }
}
