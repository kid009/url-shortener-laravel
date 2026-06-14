<?php

namespace App\Actions;

use App\DTOs\LinkDTO;
use Illuminate\Support\Facades\DB;
use App\Models\Url;
use Illuminate\Support\Str;

class CreateLinkAction
{
    public function execute(LinkDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            return Url::create([
                'url_name' => $dto->urlName,
                'short_url_name' => $dto->shortUrlName,
                'user_id' => $dto->userId,
            ]);

        });
    }
}
