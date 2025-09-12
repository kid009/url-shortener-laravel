<?php
// app/Services/ShortenerService.php
namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Str;

class ShortenerService
{
    /**
     * สร้าง short link จาก original URL.
     *
     * @param string $originalUrl URL ต้นฉบับ
     * @param int|null $userId ID ของผู้ใช้ (ถ้ามี)
     * @return Link Model ของลิงก์ที่สร้างขึ้นใหม่
     */
    public function make(string $originalUrl, ?int $userId = null): Link
    {
        $shortCode = $this->generateUniqueShortCode();
        
        return Link::create([
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
            'user_id' => $userId
        ]);
    }

    /**
     * สร้างรหัส short code ที่ไม่ซ้ำกันในฐานข้อมูล
     *
     * @return string
     */
    protected function generateUniqueShortCode(): string
    {
        $codeLength = 6;

        do 
        {
            $code = Str::random($codeLength);
        } 
        while (Link::where('short_code', $code)->exists()); // ตรวจสอบว่า code นี้มีใน db แล้วหรือยัง
        
        return $code;
    }
}