<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart URL Shortener</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container px-4 mx-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="w-full max-w-2xl">
                <div class="p-8 bg-white rounded-lg shadow-md">
                    <h1 class="mb-2 text-3xl font-bold text-center text-gray-800">Smart URL Shortener</h1>
                    <p class="mb-8 text-center text-gray-500">ระบบย่อลิงก์อัจฉริยะ ใช้งานง่ายและรวดเร็ว</p>

                    <form action="{{ route('links.store') }}" method="POST">
                        @csrf
                        <div class="flex items-center py-2 border-b-2 border-teal-500">
                            <input
                                class="w-full px-2 py-1 mr-3 leading-tight text-gray-700 bg-transparent border-none appearance-none focus:outline-none"
                                type="url" name="original_url" placeholder="วาง URL ยาวๆ ของคุณที่นี่" required>
                            <button
                                class="flex-shrink-0 px-2 py-1 text-sm text-white bg-teal-500 border-4 border-teal-500 rounded hover:bg-teal-700 hover:border-teal-700"
                                type="submit">
                                ย่อลิงก์
                            </button>
                        </div>
                        @error('original_url')
                        <p class="mt-2 text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                    </form>

                    @if (session('link'))
                    <div class="p-4 mt-8 border rounded-lg bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800">ลิงก์ของคุณพร้อมแล้ว!</h3>
                        <div class="flex items-center justify-between mt-2">
                            @php
                            $shortUrl = route('links.show', ['link' => session('link')->short_code]);
                            @endphp
                            <a id="short-url" href="{{ $shortUrl }}" target="_blank"
                                class="font-mono text-teal-600 underline">{{ $shortUrl }}</a>
                            <button id="copy-btn"
                                class="px-4 py-2 text-sm font-bold text-gray-800 bg-gray-200 rounded hover:bg-gray-300">
                                คัดลอก
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript สำหรับปุ่ม Copy to Clipboard --}}
    @if (session('link'))
    <script>
        const copyBtn = document.getElementById('copy-btn');
        const shortUrlText = document.getElementById('short-url').innerText;

        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(shortUrlText).then(() => {
                copyBtn.textContent = 'คัดลอกแล้ว!';
                copyBtn.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                copyBtn.classList.add('bg-green-500', 'text-white');
                setTimeout(() => {
                    copyBtn.textContent = 'คัดลอก';
                    copyBtn.classList.remove('bg-green-500', 'text-white');
                    copyBtn.classList.add('bg-gray-200', 'hover:bg-gray-300');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        });
    </script>
    @endif
</body>

</html>