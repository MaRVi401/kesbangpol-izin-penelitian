<div class="relative overflow-x-auto bg-white dark:bg-[#1e293b] rounded-b-xl transition-colors duration-300">
    <table class="w-full text-sm text-left">
        <thead class="text-xs uppercase bg-white dark:bg-[#1e293b] border-b border-gray-100 dark:border-gray-700/50">
            <tr>
                <th class="px-6 py-5 font-black tracking-widest text-blue-900 dark:text-blue-400">NAMA OPERATOR</th>
                <th class="px-6 py-5 text-center font-black tracking-widest text-blue-900 dark:text-blue-400">TIKET DITANGANI</th>
                <th class="px-6 py-5 text-right font-black tracking-widest text-blue-900 dark:text-blue-400">PROGRESS</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
            @forelse($operatorPerformance as $op)
                <tr class="hover:bg-blue-50/30 dark:hover:bg-slate-700/40 transition-all duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="shrink-0 w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                                {{ strtoupper(substr($op->nama, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-gray-900 dark:text-gray-100 font-bold">{{ $op->nama }}</div>
                                <div class="text-[10px] text-gray-400 dark:text-gray-500">{{ $op->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button type="button" 
                                onclick="lihatDetailTiketOperator('{{ $op->uuid }}', '{{ $op->nama }}')" 
                                class="inline-block min-w-20 font-bold text-blue-600 dark:text-blue-400 bg-blue-50/50 dark:bg-blue-900/20 px-4 py-1.5 rounded-full border border-blue-300 dark:border-blue-500/50 text-xs hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500 dark:hover:text-white transition-all duration-200 cursor-pointer transform hover:scale-105 hover:shadow-md">
                            {{ $op->total_eligible }} Tiket
                        </button>
                    </td>
                    <td class="px-6 py-4 text-right">
                        {{-- RUMUS: (Selesai Individu / Total Handle Individu) * 100 --}}
                        @php
                            $percent = $op->total_handle > 0 ? ($op->total_selesai / $op->total_handle) * 100 : 0;
                        @endphp
                        <div class="flex items-center justify-end gap-3">
                            <span class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ round($percent) }}%</span>
                            <div class="w-24 bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                                <div class="bg-blue-500 dark:bg-blue-400 h-1.5 rounded-full shadow-sm" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-10 text-center italic text-gray-400 dark:text-gray-500 bg-white dark:bg-[#1e293b]">
                        Tidak ada data operator.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="px-5 py-4 bg-white dark:bg-[#1e293b] border-t border-gray-100 dark:border-gray-700 rounded-b-xl">
    {{ $operatorPerformance->links() }}
</div>
