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

    public function get(int $id): Auction
    {
        $relationsToLoad = ['medias' => function ($q) {
            $q->select('path');
        }, 'owner' => function ($q) {
            $q->select('first_name', 'last_name', 'username', 'contact_no', 'email', 'image');
        }];

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
            $data['owner'] = $dto->owner;
            $data['status'] = $dto->status;

            $auction = $this->repository->update($data, $id);

            if (is_array($dto->medias) && $dto->medias !== []) {
                $this->uploadMedias($dto->medias, $auction);
            }

            return $auction;
        });

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
