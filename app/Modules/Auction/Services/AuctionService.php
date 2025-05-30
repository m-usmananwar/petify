<?php

namespace App\Modules\Auction\Services;

use App\Models\Auction;
use App\Helpers\FileHandler;
use Illuminate\Support\Facades\DB;
use App\Modules\Auction\DTO\CreateAuctionDTO;
use App\Modules\Auction\DTO\UpdateAuctionDTO;
use App\Modules\Auction\Repositories\Interfaces\IAuctionRepository;

final class AuctionService
{
    public function __construct(private readonly IAuctionRepository $repository) {}

    public function getRepository(): IAuctionRepository
    {
        return $this->repository;
    }

    public function index(array $filters)
    {
        $auctions = $this->repository->getPaginatedWith($filters);

        return $auctions;
    }

    public function store(CreateAuctionDTO $dto): Auction
    {
        return DB::transaction(function () use ($dto) {
            $data['name'] = $dto->name;
            $data['color'] = $dto->color;
            $data['age'] = $dto->age;
            $data['type'] = $dto->type;
            $data['tag_line'] = $dto->tagLine;
            $data['description'] = $dto->description;
            $data['initial_price'] = $dto->initialPrice;
            $data['start_time'] = $dto->startTime;
            $data['expiry_time'] = $dto->expiryTime;
            $data['owner'] = $dto->owner;
            $data['status'] = $dto->status;

            $auction = $this->repository->save($data);

            if (is_array($dto->medias) && $dto->medias !== []) {
                $this->uploadMedias($dto->medias, $auction);
            }

            return $auction;
        });
    }

    public function get(int|string $id): Auction
    {
        $relationsToLoad = ['owner'];

        return $this->repository->getWith($id, $relationsToLoad);
    }

    public function update(UpdateAuctionDTO $dto, $id): Auction
    {
        return DB::transaction(function () use ($dto, $id) {
            $data['name'] = $dto->name;
            $data['color'] = $dto->color;
            $data['age'] = $dto->age;
            $data['type'] = $dto->type;
            $data['tag_line'] = $dto->tagLine;
            $data['description'] = $dto->description;
            $data['initial_price'] = $dto->initialPrice;
            $data['start_time'] = $dto->startTime;
            $data['expiry_time'] = $dto->expiryTime;
            $data['owner_id'] = $dto->owner_id;
            $data['status'] = $dto->status;

            $auction = $this->repository->update($data, $id);

            if (is_array($dto->medias) && $dto->medias !== []) {
                $this->uploadMedias($dto->medias, $auction);
            }

            return $auction;
        });
    }

    public function delete($id): void
    {
        $this->repository->delete($id);
    }

    private function uploadMedias(array $medias, Auction $auction): void
    {
        $folder = FileHandler::generateUserSpecificPath(currentUserId(), config('general.filePaths.auctionMedias'));

        $paths = FileHandler::uploadMany($medias, $folder);

        $medias = array_map(function ($path) {
            return [
                'path' => $path
            ];
        }, $paths);

        $auction->medias()->createMany($medias);
    }
}
