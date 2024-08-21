<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ImageService
{
    public function getImgs() {
        // Đường dẫn đến thư mục ảnh
        $path = public_path('imgs');
    
        // Lấy tất cả các tệp trong thư mục
        $files = File::files($path);
    
        // Sắp xếp các tệp theo tên giảm dần (từ lớn đến bé)
        usort($files, function($a, $b) {
            return basename($b) <=> basename($a);
        });
    
        // Khởi tạo mảng để lưu trữ các đường dẫn ảnh
        $imgs = [];
    
        // Duyệt qua các tệp và lấy đường dẫn đầy đủ của từng ảnh
        foreach ($files as $file) {
            // Lấy đường dẫn tương đối từ thư mục public/imgs
            $relativePath = 'imgs/' . basename($file->getRealPath());
            $fullPath = asset($relativePath);
            // Thêm vào mảng
            $imgs[] = $fullPath;
        }
    
        // Trả về mảng các đường dẫn ảnh
        return $imgs;
    }
    public function uploadImage($files){
        $imgs = [];
        foreach ($files as $file) {
            // Tạo tên file mới để tránh trùng lặp
            $filename = time() . '-' . $file->getClientOriginalName();
            // Lưu file vào thư mục public/imgs
            $file->move(public_path('imgs'), $filename);
            // Tạo đường dẫn tương đối
            $relativePath = 'imgs/' . $filename;
            // Tạo đường dẫn đầy đủ bằng asset()
            $fullPath = asset($relativePath);
            // Thêm vào mảng
            $imgs[] = $fullPath;
        }
        return response()->json(['imageNews' => $imgs]);
    }
}