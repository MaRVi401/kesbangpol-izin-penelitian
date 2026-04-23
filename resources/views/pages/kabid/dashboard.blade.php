@extends('layouts.master')

@section('title', 'Dashboard Monitoring Kabid')

@section('content')
    <div class="p-4 mt-14">
        <div class="mb-8 border-b border-gray-200 pb-6 dark:border-gray-700">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="text-center md:text-left">
                    <h2 class="text-xl md:text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        @php
                            $hour = date('H');
                            $sapaan = $hour < 12 ? 'Pagi' : ($hour < 15 ? 'Siang' : ($hour < 18 ? 'Sore' : 'Malam'));
                        @endphp
                        Selamat <span id="sapaan-teks">{{ $sapaan }}</span>,
                        <span class="block md:inline text-transparent bg-clip-text bg-linear-to-r from-blue-600 to-cyan-500 uppercase font-black">
                            {{ auth()->user()->nama }}
                        </span>
                    </h2>
                    <p class="mt-1 text-xs md:text-sm text-gray-500 dark:text-gray-400 tracking-wider">
                        Dashboard Monitoring Services KOMINFO Subang
                    </p>
                </div>
                
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <div class="flex items-center justify-center md:justify-end space-x-3 md:space-x-4 bg-white dark:bg-gray-800 px-4 py-2 md:px-5 md:py-2.5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:shadow-md">
                        <div class="flex flex-col items-center md:items-end border-r border-gray-200 dark:border-gray-600 pr-3 md:pr-4">
                            <span id="realtime-clock" class="text-lg md:text-xl font-black font-mono text-blue-600 dark:text-blue-400 leading-none">00:00:00</span>
                            <span class="text-[9px] md:text-[10px] uppercase tracking-widest font-bold text-gray-400 mt-1">Waktu Server</span>
                        </div>
                        <div class="flex flex-col text-left">
                            <span class="text-xs md:text-sm font-bold text-gray-700 dark:text-gray-200 leading-none">
                                {{ \Carbon\Carbon::now()->translatedFormat('l') }}
                            </span>
                            <span class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-gray-400 tracking-wider">Total Layanan</p>
                    <i class="ti ti-apps text-blue-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-gray-900 dark:text-white">{{ $layananAktif }}</h5>
            </div>

            <div class="p-5 bg-yellow-50/50 border border-yellow-100 rounded-xl shadow-sm dark:bg-yellow-900/10 dark:border-yellow-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-yellow-600 dark:text-yellow-400 tracking-wider">Penyelesaian</p>
                    <i class="ti ti-chart-bar text-yellow-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-yellow-700 dark:text-yellow-100">{{ $tingkatPenyelesaian }}%</h5>
            </div>

            <div class="p-5 bg-green-50/50 border border-green-100 rounded-xl shadow-sm dark:bg-green-900/10 dark:border-green-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-green-600 dark:text-green-400 tracking-wider">Tiket Selesai</p>
                    <i class="ti ti-circle-check text-green-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-green-700 dark:text-green-100">{{ $stats['selesai'] }}</h5>
            </div>

            <div class="p-5 bg-orange-50/50 border border-orange-100 rounded-xl shadow-sm dark:bg-orange-900/10 dark:border-orange-900/20">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold uppercase text-orange-600 dark:text-orange-400 tracking-wider">Diproses</p>
                    <i class="ti ti-loader text-orange-500 text-xl"></i>
                </div>
                <h5 class="text-3xl font-black text-orange-700 dark:text-orange-100">{{ $stats['proses'] }}</h5>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div id="table-container" class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden flex flex-col min-h-112.5">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30 flex justify-between items-center text-heading font-bold italic">
                    <h3 class="flex items-center text-gray-900 dark:text-white">
                        <i class="ti ti-users text-blue-600 me-2 text-xl"></i> Produktivitas Operator
                    </h3>
                </div>

                <div id="ajax-table-content" class="h-full">
                    @include('pages.kabid._operator_table')
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700 p-6 flex flex-col items-center">
                <h3 class="w-full font-bold text-gray-900 dark:text-white mb-8 border-b border-gray-50 dark:border-gray-700 pb-3 flex items-center italic">
                    <i class="ti ti-chart-pie text-orange-500 me-2 text-xl"></i> Status Layanan Masuk
                </h3>

                <div class="w-full max-w-55 aspect-square mb-8 relative">
                    <canvas id="ticketDonutChart"></canvas>
                </div>

                <div class="w-full space-y-3 mt-auto">
                    @foreach($chartData['labels'] as $index => $label)
                    <div class="flex items-center justify-between text-xs font-bold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-3 py-2.5 rounded-xl border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full shadow-sm" style="background-color: {{ ['#3b82f6', '#f59e0b', '#10b981', '#ef4444'][$index] }}"></span>
                            {{ $label }}
                        </div>
                        <span class="text-gray-900 dark:text-white font-mono text-sm">{{ $chartData['data'][$index] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="mt-8 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30 flex justify-between items-center text-heading font-bold italic">
                <h3 class="flex items-center text-gray-900 dark:text-white">
                    <i class="ti ti-send text-blue-600 me-2 text-xl"></i> Riwayat Usulan Prioritas Terbaru
                </h3>
            </div>

            <div class="relative overflow-x-auto bg-white dark:bg-[#1e293b]">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-white dark:bg-[#1e293b] border-b border-gray-100 dark:border-gray-700/50">
                        <tr>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">No. Tiket</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">Prioritas</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">Catatan Kabid</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">Status</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">Catatan Kadis</th>
                            <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400 text-center">Aksi</th>
                            <th class="px-6 py-5 text-right font-black tracking-widest text-blue-900 dark:text-blue-400">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                        @forelse($usulanTerkirim as $usulan)
                            <tr class="hover:bg-blue-50/30 dark:hover:bg-slate-700/40 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2.5 py-1 text-xs font-black rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 tracking-wider">
                                        {{ $usulan->tiket->no_tiket ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $colorPrio = $usulan->level_prioritas == 'tinggi' ? 'red' : ($usulan->level_prioritas == 'sedang' ? 'yellow' : 'green');
                                    @endphp
                                    <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-{{$colorPrio}}-700 bg-{{$colorPrio}}-100 rounded-lg dark:bg-{{$colorPrio}}-900/30 dark:text-{{$colorPrio}}-400 border border-{{$colorPrio}}-200 dark:border-{{$colorPrio}}-800">
                                        {{ $usulan->level_prioritas }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    <div class="truncate max-w-xs" title="{{ $usulan->catatan_kabid }}">
                                        {{ \Illuminate\Support\Str::limit($usulan->catatan_kabid, 45) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusIcon = 'ti-clock';
                                        $statusColor = 'orange';
                                        
                                        if ($usulan->status_persetujuan == 'disetujui') {
                                            $statusIcon = 'ti-check';
                                            $statusColor = 'green';
                                        } elseif ($usulan->status_persetujuan == 'ditolak') {
                                            $statusIcon = 'ti-x';
                                            $statusColor = 'red';
                                        }
                                    @endphp
                                    <span class="flex items-center gap-1.5 text-xs font-bold text-{{$statusColor}}-600 dark:text-{{$statusColor}}-400">
                                        <i class="ti {{ $statusIcon }} text-base"></i>
                                        {{ ucfirst($usulan->status_persetujuan) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    @if($usulan->catatan_kadis)
                                        <div class="truncate max-w-xs" title="{{ $usulan->catatan_kadis }}">
                                            {{ \Illuminate\Support\Str::limit($usulan->catatan_kadis, 45) }}
                                        </div>
                                    @else
                                        <span class="text-xs italic text-gray-400 dark:text-gray-500">Menunggu balasan...</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" 
                                                onclick="bukaDetailUsulan(this)" 
                                                data-usulan="{{ $usulan }}"
                                                class="inline-flex items-center justify-center p-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800 transition-all shadow-sm"
                                                title="Lihat Detail">
                                            <i class="ti ti-eye text-lg"></i>
                                        </button>

                                        @if($usulan->status_persetujuan == 'pending')
                                            <button type="button" 
                                                    onclick="confirmHapusUsulan('{{ $usulan->uuid }}')" 
                                                    class="inline-flex items-center justify-center p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900 transition-all shadow-sm"
                                                    title="Batalkan Usulan">
                                                <i class="ti ti-trash text-lg"></i>
                                            </button>
                                        @else
                                            <span class="inline-flex items-center justify-center p-2 text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400" title="Sudah diproses">
                                                <i class="ti ti-lock text-lg"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400">
                                    {{ $usulan->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center italic text-gray-400 dark:text-gray-500 bg-white dark:bg-[#1e293b]">
                                    Belum ada tiket yang diusulkan ke Kadis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-5 py-4 bg-gray-50 dark:bg-[#1e293b] border-t border-gray-100 dark:border-gray-700 rounded-b-xl">
                {{ $usulanTerkirim->links() }}
            </div>
        </div>
    </div>

    <div id="modalUsulanKadis" 
        data-tiket="{{ json_encode($tiketEligible) }}"
        class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-6 md:p-8 border border-gray-100 dark:border-gray-700 flex flex-col max-h-[90vh]">
            
            <div class="flex justify-between items-center mb-6 shrink-0">
                <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                    <i class="ti ti-file-star text-blue-600 text-2xl"></i> Form Usulan Prioritas
                </h3>
                <button onclick="toggleModalUsulan()" type="button" class="text-gray-400 hover:text-red-500 transition-colors">
                    <i class="ti ti-x text-2xl"></i>
                </button>
            </div>

            <form id="formUsulanKadis" data-url="{{ route('kabid.usulan.store') }}" class="flex flex-col overflow-hidden">
                @csrf
                <input type="hidden" name="penerima_id" value="{{ $kadis->uuid ?? '' }}">

                <div class="flex flex-col md:flex-row gap-6">
                    
                    <div class="w-full md:w-7/12 flex flex-col">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-3 tracking-widest shrink-0">
                            Pilih Tiket <span id="label-nama-operator" class="text-blue-600 font-black"></span>
                        </label>
                        
                        <div id="container-list-tiket" class="max-h-[50vh] overflow-y-auto space-y-3 pr-2 scrollbar-thin scrollbar-thumb-gray-200 dark:scrollbar-thumb-gray-600 pb-2">
                        </div>
                    </div>

                    <div class="w-full md:w-5/12 flex flex-col gap-6 pt-6 md:pt-0 border-t md:border-t-0 md:border-l border-gray-100 dark:border-gray-700 md:pl-6">
                        
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-3 tracking-widest">Level Prioritas</label>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach(['rendah', 'sedang', 'tinggi'] as $lv)
                                    @php
                                        $colorClasses = '';
                                        if ($lv == 'rendah') {
                                            $colorClasses = 'peer-checked:bg-green-600 peer-checked:border-green-600 hover:border-green-300 dark:hover:border-green-600/50';
                                        } elseif ($lv == 'sedang') {
                                            $colorClasses = 'peer-checked:bg-yellow-500 peer-checked:border-yellow-500 hover:border-yellow-300 dark:hover:border-yellow-600/50';
                                        } else { 
                                            $colorClasses = 'peer-checked:bg-red-600 peer-checked:border-red-600 hover:border-red-300 dark:hover:border-red-600/50';
                                        }
                                    @endphp
                                    <label class="cursor-pointer">
                                        <input type="radio" name="level_prioritas" value="{{ $lv }}" class="peer hidden" {{ $lv == 'sedang' ? 'checked' : '' }}>
                                        <div class="text-center p-3 text-xs font-bold uppercase tracking-wide rounded-xl border-2 border-gray-100 dark:border-gray-700 text-black dark:text-white peer-checked:text-black dark:peer-checked:text-white transition-all {{ $colorClasses }}">
                                            {{ $lv }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-3 tracking-widest">Catatan Untuk Kadis</label>
                            <textarea name="catatan_kabid" required class="flex-1 w-full min-h-[150px] bg-gray-50 dark:bg-gray-700/50 border-2 border-gray-100 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-2xl p-4 focus:ring-0 focus:border-blue-500 outline-none resize-none transition-colors" placeholder="Jelaskan secara spesifik mengapa tiket ini butuh perhatian atau persetujuan khusus..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-5 mt-5 border-t border-gray-100 dark:border-gray-700 shrink-0">
                    <button type="button" onclick="toggleModalUsulan()" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition flex items-center gap-2">
                        <i class="ti ti-send"></i> Kirim Usulan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalAlertCustom" class="fixed inset-0 z-[60] hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center p-4">
        <div class="relative w-full max-w-sm bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-6 md:p-8 text-center border border-gray-100 dark:border-gray-700 flex flex-col items-center">
            
            <div id="alertIcon" class="mb-4"></div>
            
            <h3 id="alertTitle" class="text-xl font-black text-gray-900 dark:text-white mb-2"></h3>
            <p id="alertMessage" class="text-sm text-gray-500 dark:text-gray-400 mb-8"></p>
            
            <button type="button" onclick="tutupAlertDanKembali()" class="w-full px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition">
                Kembali ke Dashboard
            </button>
        </div>
    </div>

    <div id="modalDetailUsulan" class="fixed inset-0 z-[70] hidden bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center p-4">
        <div class="relative w-full max-w-2xl bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-6 md:p-8 border border-gray-100 dark:border-gray-700 flex flex-col max-h-[90vh]">
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-gray-700 pb-4 shrink-0">
                <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                    <i class="ti ti-file-info text-blue-600 text-2xl"></i> Detail Usulan Prioritas
                </h3>
                <button onclick="tutupModalDetailUsulan()" type="button" class="text-gray-400 hover:text-red-500 transition-colors">
                    <i class="ti ti-x text-2xl"></i>
                </button>
            </div>
            <div id="detailUsulanContent" class="overflow-y-auto pr-2 space-y-4">
            </div>
            <div class="flex justify-end pt-5 mt-5 border-t border-gray-100 dark:border-gray-700 shrink-0">
                <button type="button" onclick="tutupModalDetailUsulan()" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">Tutup</button>
            </div>
        </div>
    </div>

    <span id="dashboard-data-bridge" 
        data-labels='@json($chartData["labels"])'
        data-data='@json($chartData["data"])'>
    </span>
@endsection

@push('scripts')
    @vite(['resources/js/dashboard-kabid.js'])
@endpush