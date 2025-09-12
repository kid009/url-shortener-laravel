<?php

namespace App\Livewire;

use App\Models\Link;
use Livewire\Component;
use Livewire\WithPagination;

class LinkManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';

    public function sortBy(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $field;
        $this->resetPage();
    }

    public function delete(Link $link)
    {
        // ตรวจสอบว่าเป็นเจ้าของลิงก์จริง
        if ($link->user_id !== auth()->id()) {
            abort(403);
        }
        $link->delete();
    }

    public function render()
    {
        $links = Link::where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where('original_url', 'like', "%{$this->search}%")
                      ->orWhere('short_code', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
        
        return view('livewire.link-manager', [
            'links' => $links
        ]);
    }
}
