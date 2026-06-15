<div>

    {{-- Toast Notification --}}
    <div x-data="{
        show: false,
        message: '',
        type: 'success'
    }"
        x-on:notify.window="
            show = true;
            message = $event.detail[0]?.message || $event.detail.message || '';
            type = $event.detail[0]?.type || $event.detail.type || 'success';
            setTimeout(() => show = false, 3000)
        "
        x-show="show" x-transition x-cloak class="fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50"
        :class="type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'">
        <span x-text="message"></span>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form wire:submit='save'>
                        <div class="mb-6">
                            <label for="urlName" class="block mb-2.5 text-sm font-medium text-heading">
                                Enter your destination URL
                            </label>
                            <input type="text" wire:model="urlName"
                                class="@error('urlName') is-invalid @enderror bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                placeholder="https://www.example.com" />
                            @error('urlName')
                                <div class="p-4 mt-4 text-sm text-fg-danger-strong rounded-base bg-danger-soft"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none"
                            wire:loading.attr='disabled'
                            wire:loading.class='opacity-50 cursor-not-allowed'
                        >
                            <span wire:loading.remove wire:target='save'>Create Link</span>

                            <span wire:loading wire:target='save'>
                                <svg aria-hidden="true" class="inline w-4 h-4 w-8 h-8 text-neutral-tertiary animate-spin fill-brand" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                </svg>
                            </span>

                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form wire:submit="search">
                        <label for="search"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <input type="text" wire:model='query' placeholder="search..."
                                class="block w-full p-3 ps-9 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body" />
                            <div class="mt-2">
                                <button type="submit"
                                    class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none"
                                    wire:loading.attr='disabled'
                                    wire:loading.class='opacity-50 cursor-not-allowed'
                                >
                                    <span wire:loading.remove wire:target='search'>Search</span>

                                    <span wire:loading wire:target='search'>
                                        <svg aria-hidden="true" class="inline w-4 h-4 w-8 h-8 text-neutral-tertiary animate-spin fill-brand" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                        </svg>
                                    </span>
                                </button>
                                <a href="{{route('links.index')}}" wire:navigate
                                    class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none"
                                >
                                    Clear
                                </a>
                            </div>

                        </div>
                    </form>

                    @if ($urls->count() > 0)
                        <div
                            class="mt-6 relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                            <table class="w-full text-sm text-left rtl:text-right text-body">
                                <thead
                                    class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 font-medium">
                                            Origilan Url
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-medium">
                                            Short Url
                                        </th>
                                        <th scope="col" class="px-6 py-3 font-medium">
                                            Created
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($urls as $url)
                                        <tr class="bg-neutral-primary border-b border-default">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                                <a href="{{ $url->url_name }}" target="_blank">
                                                    <span class="font-medium text-brand">{{ $url->url_name }}</span>
                                                </a>
                                            </th>
                                            <td class="px-6 py-4">
                                                <a href="{{ $url->url_name }}" target="_blank">
                                                    <span
                                                        class="font-medium text-brand">{{ 'http://short-url/' . $url->short_url_name }}</span>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $url->created_at->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $urls->links() }}
                        </div>
                    @else
                        <div class="p-4 mb-4 text-sm text-fg-warning rounded-base bg-warning-soft mt-6" role="alert">
                            <span class="font-medium">Resource Not Found</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

