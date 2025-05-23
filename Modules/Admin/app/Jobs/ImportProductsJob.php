<?php

namespace Modules\Admin\Jobs;

use App\Imports\ProductImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        try {
            // Use Storage facade for consistent path resolution
            $fullPath = Storage::path($this->filePath);
            
            if (!Storage::exists($this->filePath)) {
                throw new \Exception("File not found in storage: {$this->filePath}");
            }

            // Process import
            Excel::import(new ProductImport, $fullPath);
            
            // Clean up
            Storage::delete($this->filePath);
            
            \Log::info("Products imported successfully from {$this->filePath}");
            
        } catch (\Exception $e) {
            // Ensure cleanup even on failure
            if (Storage::exists($this->filePath)) {
                Storage::delete($this->filePath);
            }
            
            \Log::error("Import failed: {$e->getMessage()}");
            throw $e;
        }
    }
}
