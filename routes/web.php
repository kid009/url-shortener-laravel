<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route สำหรับรับฟอร์มการย่อลิงก์
Route::post('/store', [LinkController::class, 'store'])->name('links.store');

Route::get('/dashboard', function () {

    $user = auth()->user();

    // 1. ดึงข้อมูล Cards สรุป
    $totalLinks = $user->links()->count();
    $totalClicks = $user->links()->sum('clicks');

    // 2. เตรียมข้อมูลสำหรับ Chart ย้อนหลัง 7 วัน
    $clicksData = $user->links()
        ->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(clicks) as total_clicks')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get()
        ->pluck('total_clicks', 'date');

    // สร้าง Labels และ Data สำหรับ 7 วัน (เผื่อบางวันไม่มีข้อมูล)
    $chartLabels = [];
    $chartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i)->format('Y-m-d');
        $chartLabels[] = Carbon::parse($date)->format('M d'); // Format 'Sep 12'
        $chartData[] = $clicksData[$date] ?? 0;
    }

    return view('dashboard', [
        'totalLinks' => $totalLinks,
        'totalClicks' => $totalClicks,
        'chartLabels' => $chartLabels,
        'chartData' => $chartData,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Route สำหรับการ Redirect (ต้องอยู่นอกสุด และท้ายสุด)
// เราใช้ `s` เป็น prefix เพื่อให้ไม่ชนกับ route อื่นๆ
// {link:short_code} คือการทำ Route Model Binding ด้วยคอลัมน์ short_code
Route::get('/s/{link:short_code}', [LinkController::class, 'show'])->name('links.show');
