<?php

namespace App\Http\Controllers\Playlist;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Playlist\CreateRequest;
use App\Http\Requests\Playlist\UpdateRequest;
use App\Services\Playlist\IPlaylistService;

/**
 * Class PlaylistController
 *
 * @package App\Http\Controllers\Playlist
 */
class PlaylistController extends BaseController
{
    const LIST = "List of playlists.";
    const NOT_CREATED = "Can't create playlist.";
    const NOT_UPDATED = "Can't update playlist.";
    const UPDATED = "Playlist was updated.";
    const CREATED = "Playlist successfully created.";
    const NOT_FOUND = "Playlist not found.";
    const ITEM = "Playlist.";
    const DELETED = "Playlist was deleted.";
    const NOT_DELETED = "Error while deleting.";
    /**
     * @var IPlaylistService
     */
    private $playlistService;

    /**
     * PlaylistController constructor.
     *
     * @param  IPlaylistService  $playlistService
     */
    public function __construct(IPlaylistService $playlistService)
    {
        $this->playlistService = $playlistService;
    }
    /**
     * Return a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->response($this->playlistService->paginated(),self::LIST, Response::HTTP_OK);
    }

    /**
     * Add new resource.
     *
     * @return JsonResponse
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        $message = self::NOT_CREATED;
        $data = null;

        if ($data = $this->playlistService->create($request->all())) {
            $code = Response::HTTP_CREATED;
            $message = self::CREATED;
        }

        return $this->response($data, $message, $code);
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
        return $this->response($this->playlistService->find($id), self::ITEM, Response::HTTP_OK);
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
        $message = self::NOT_UPDATED;
        $data = null;

        if ($this->playlistService->update($id, $request->all())) {
            $code = Response::HTTP_OK;
            $message = self::UPDATED;
            $data = $this->playlistService->find($id);
        }

        return $this->response($data, $message, $code);
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $code = Response::HTTP_OK;
        $message = self::NOT_DELETED;
        $data = null;

        if ($this->playlistService->delete($id)) {
           $message = self::DELETED;
           $code = Response::HTTP_ACCEPTED;
        }

        return $this->response($data, $message, $code);
    }
}
