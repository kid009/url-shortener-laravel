<?php

namespace App\Livewire\Link;

use App\Actions\CreateLinkAction;
use App\DTOs\LinkDTO;
use App\Models\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\WithPagination;

class LinkComponent extends Component
{
    use WithPagination;

    public string $urlName = '';
    public string $shortUrlName = '';
    public int $userId;
    public string $query = '';

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
        $urls = Url::where('url_name', 'like', '%' . $this->query . '%')->where('user_id', Auth::id())->simplePaginate(10);

        return view('livewire.link.link-component', [
            'urls' => $urls,
        ]);
    }
}
