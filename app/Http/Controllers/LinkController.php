<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\ShortenerService;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * จัดการการสร้าง Short Link ใหม่
     */
    public function store(Request $request, ShortenerService $shortenerService)
    {
        // 1. ตรวจสอบข้อมูลที่ส่งเข้ามา
        $validated = $request->validate([
            'original_url' => 'required|url:http,https',
        ]);

        // 2. เรียกใช้ Service เพื่อสร้างลิงก์
        // ถ้า user login อยู่, ให้ส่ง user id ไปด้วย
        $link = $shortenerService->make($validated['original_url'], auth()->id());

        // 3. ส่งข้อมูลลิงก์ที่สร้างเสร็จกลับไปให้หน้า view
        return redirect('/')->with('link', $link);
    }

    /**
     * ทำการ Redirect ไปยัง Original URL และนับยอดคลิก
     */
    public function show(Link $link)
    {
        // 1. เพิ่มจำนวนคลิก (increment เป็น atomic operation ปลอดภัยกว่า)
        $link->increment('clicks');

        // 2. Redirect ไปยัง URL จริงด้วย HTTP Status 301
        return redirect()->to($link->original_url, 301);
    }
}
