<div class="space-y-6">
    <div>
        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Detail Pengaduan / Kronologi</label>
        <div class="p-4 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white min-h-[150px] whitespace-pre-line">
            {{ $ticket->detailPengaduan->detail_pengaduan ?? 'Tidak ada detail deskripsi.' }}
        </div>
    </div>

    <div>
        <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Lampiran Screenshot Kejadian</label>
        @if(!empty($ticket->detailPengaduan->lampiran_screenshot))
            <div>
                <div class="mt-2">
                    <button type="button" id="btn-open-image-modal" class="group relative block max-w-md overflow-hidden rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm hover:shadow-md transition-shadow">
                        <img src="{{ Storage::disk('s3')->url($ticket->detailPengaduan->lampiran_screenshot, now()->addMinutes(60)) }}" 
                             alt="Screenshot Pengaduan" 
                             class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-white text-sm font-medium flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                Perbesar Gambar
                            </span>
                        </div>
                    </button>
                </div>

                <div id="image-modal-container" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80">
                    
                    <button type="button" id="btn-close-image-modal" class="absolute top-5 right-5 text-white hover:text-gray-300 z-[110]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <div class="relative max-w-5xl w-full flex justify-center">
                        <img src="{{ Storage::disk('s3')->url($ticket->detailPengaduan->lampiran_screenshot, now()->addMinutes(60)) }}" 
                             class="max-h-[90vh] rounded-lg shadow-2xl object-contain relative z-[105]">
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center p-4 text-sm text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Tidak ada lampiran.
            </div>
        @endif
    </div>
</div>