<?php

namespace App\Services;

use App\DTOs\Telegram\ChannelDTO;
use App\DTOs\Telegram\ChannelValidatedDTO;
use App\Models\TelegramChannel;
use App\Traits\DynamicTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TelegramChannelService
{
    use DynamicTableTrait;

    /**
     * @var string
     */
    protected $model = TelegramChannel::class;

    /**
     * @param Builder $query
     * @param string  $search
     * @return void
     */
    protected function applyListSearch(Builder &$query, string $search)
    {
        $query->where('title', 'like', "%{$search}%");
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        TelegramChannel::where('id', $id)->delete();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getChannels(): \Illuminate\Support\Collection
    {
        $channels = collect();
        $results = TelegramChannel::all();

        if ($results->isNotEmpty()) {
            $channels = $results->map(fn ($i) => (new ChannelDTO())->transform($i));
        }

        return $channels;
    }

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new ChannelDTO())->transform($i));
    }

    /**
     * @param ChannelValidatedDTO $dto
     * @return void
     * @throws \Throwable
     */
    public function save(ChannelValidatedDTO $dto): void
    {
        \DB::transaction(function () use ($dto) {
            TelegramChannel::updateOrCreate(['id' => $dto->id], [
                'title' => $dto->title,
                'url' => $dto->url,
                'channel_id' => $dto->channel_id
            ]);
        });
    }
}
