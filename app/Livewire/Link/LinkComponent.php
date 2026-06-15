<?php

namespace App\Livewire\Link;

use App\Actions\CreateLinkAction;
use App\DTOs\LinkDTO;
use App\Models\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\WithPagination;

class LinkComponent extends Component
{
    use WithPagination;

    public string $urlName = '';
    public string $shortUrlName = '';
    public int $userId;
    public string $search_url = '';
    public string $search_created_date = '';
    public string $search_created_by = '';

    public function save(CreateLinkAction $action)
    {
        $this->validate([
            'urlName' => 'required|url',
        ]);

        try {

            $dto = new LinkDTO(
                urlName: $this->urlName,
                shortUrlName: Str::random(5),
                userId: Auth::id(),
            );

            $action->execute($dto);

            $this->reset(['urlName']);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Created Success'
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Link save failed: ' . $e->getMessage());

            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Error'
            ]);
        }
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $isAdmin = Auth::user()->role === 'admin';

        $urls = Url::query()
            ->when($this->search_url, function ($query) {
                $query->where('url_name', 'like', '%' . $this->search_url . '%');
            })
            ->when($this->search_created_date, function ($query) {
                $query->whereDate('created_at', $this->search_created_date);
            })
            ->when($this->search_created_by, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search_created_by . '%');
                });
            })
            ->when(!$isAdmin, function($q){
                $q->where('user_id', Auth::id());
            })
            ->simplePaginate(10);

        return view('livewire.link.link-component', [
            'urls' => $urls,
            'isAdmin' => $isAdmin,
        ]);
    }
}
