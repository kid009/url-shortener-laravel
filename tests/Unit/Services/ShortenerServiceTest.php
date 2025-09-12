<?php

namespace Tests\Unit\Services;

use App\Services\ShortenerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ShortenerServiceTest extends TestCase
{
    use RefreshDatabase;

    public function it_create_a_link_record_in_the_database()
    {
        // 1. Arrange: เตรียมข้อมูลและ Service
        $service = new ShortenerService();
        $originalUrl = 'https://www.google.com';

        // 2. Act: เรียกใช้งาน method ที่ต้องการทดสอบ
        $link = $service->make($originalUrl);

        // 3. Assert: ตรวจสอบผลลัพธ์ที่ได้
        $this->assertDatabaseHas('links', [
            'original_url' => $originalUrl,
        ]);

        $this->assertEquals($originalUrl, $link->original_url);
        $this->assertNotNull($link->short_code);
        $this->assertEquals(6, strlen($link->short_code)); // ตรวจสอบว่า short_code มี 6 ตัวอักษร
    }
}
