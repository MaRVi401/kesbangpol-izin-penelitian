@extends('layouts.main')

@section('title', 'AI DocScanner - Final Version')

@push('styles')
    <style>
        .viewport-container {
            width: 100%;
            background: #0f172a;
            border-radius: 0.75rem;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 500px;
            padding: 1rem;
        }

        #image-wrapper {
            position: relative;
            display: inline-block;
        }

        #test-image {
            max-width: 100%;
            max-height: 70vh;
            display: block;
            width: auto;
            height: auto;
        }

        #overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: crosshair;
            z-index: 10;
            touch-action: none;
        }
    </style>
@endpush

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-14">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">AI DocScanner Pro</h2>
                <p class="text-sm text-slate-500">Deteksi otomatis dengan opsi koreksi manual.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-7 space-y-4">
                {{-- Modern Drag & Drop Upload --}}
                <div class="flex items-center justify-center w-full">
                    <label for="image-upload"
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-white dark:bg-slate-800 hover:bg-slate-50 transition-all">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm text-slate-500 font-bold">Klik atau seret gambar ke sini</p>
                        </div>
                        <input id="image-upload" type="file" class="hidden" accept="image/*" />
                    </label>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="viewport-container relative flex items-center justify-center">

                        <div id="image-wrapper" class="relative inline-block w-fit h-fit mx-auto shadow-lg group">
                            
                            <div id="image-placeholder" class="flex flex-col items-center justify-center p-12 text-slate-400">
                                <div class="p-4 rounded-full bg-slate-100 dark:bg-slate-700/50 mb-3 border border-slate-200 dark:border-slate-600">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-slate-500">Pratinjau dokumen</p>
                                <p class="text-xs text-slate-400">Pilih file untuk memulai deteksi AI</p>
                            </div>

                            <img id="test-image" class="hidden max-w-full max-h-[70vh] w-auto h-auto rounded-lg" alt="Scanned Document" />
                            
                            <canvas id="overlay" class="absolute top-0 left-0 w-full h-full z-10 touch-none cursor-crosshair rounded-lg"></canvas>
                        </div>

                    </div>

                    <div class="p-4 flex items-center justify-between bg-slate-50 dark:bg-slate-800/50">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-500 uppercase">
                            <div id="ai-status-dot" class="w-2 h-2 rounded-full bg-slate-400"></div>
                            <span id="ai-status-text">Menunggu File...</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button id="manual-btn" class="hidden px-4 py-2.5 rounded-full bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-sm shadow-sm transition-all">
                                Atur Manual
                            </button>
                            <button id="capture-btn" disabled class="px-6 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-lg disabled:opacity-50 transition-all">
                                Proses & Luruskan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div id="result-area" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-emerald-500/30 shadow-sm p-6">
                        <h3 class="text-lg font-bold text-emerald-600 mb-4 text-center">Hasil Scan Dokumen</h3>
                        <canvas id="output-canvas" class="w-full h-auto rounded-lg border shadow-inner bg-white"></canvas>
                        <div class="mt-6 flex gap-2">
                            <button onclick="location.reload()"
                                class="w-1/3 py-2 bg-slate-100 text-slate-600 font-bold rounded-lg text-sm hover:bg-slate-200">Ulangi</button>
                            <button id="download-btn"
                                class="w-2/3 py-2 bg-emerald-500 text-white font-bold rounded-lg text-sm hover:bg-emerald-600 shadow-md">Simpan
                                JPG</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script id="opencv-script" async src="{{ asset('assets/images/models/doc-scanner/opencv.js') }}"
        onload="document.dispatchEvent(new Event('opencv-ready'))"></script>
    @vite('resources/js/doc-scanner.js')
@endpush
