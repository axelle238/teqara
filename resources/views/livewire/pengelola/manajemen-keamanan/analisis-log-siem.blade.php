<div class="space-y-8 animate-in fade-in zoom-in duration-500 pb-20">
    
    <!-- Header -->
    <div class="bg-slate-900 rounded-[3rem] p-10 overflow-hidden shadow-2xl border border-slate-800 flex flex-col md:flex-row justify-between items-center gap-8 relative">
        <div class="relative z-10 space-y-2">
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase leading-none">SIEM <span class="text-indigo-500">DASHBOARD</span></h1>
            <p class="text-slate-400 font-medium text-lg">Security Information and Event Management terpusat.</p>
        </div>
        <div class="flex gap-4">
            <div class="text-center px-6 py-3 bg-slate-800 rounded-2xl border border-slate-700">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Event / Detik</p>
                <p class="text-2xl font-black text-white">450</p>
            </div>
            <div class="text-center px-6 py-3 bg-slate-800 rounded-2xl border border-slate-700">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Ancaman Aktif</p>
                <p class="text-2xl font-black text-rose-500 animate-pulse">3</p>
            </div>
        </div>
    </div>

    <!-- Visualization (Simulated Graph) -->
    <div class="bg-slate-900 rounded-[40px] p-8 border border-slate-800 shadow-xl overflow-hidden relative">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 mix-blend-overlay"></div>
        <div class="flex justify-between items-center mb-6 relative z-10">
            <h3 class="font-black text-white text-lg uppercase tracking-tight">Korelasi Event Keamanan</h3>
            <select class="bg-slate-800 border-none text-slate-300 text-xs font-bold rounded-lg py-2 px-4 focus:ring-0 cursor-pointer">
                <option>1 Jam Terakhir</option>
                <option>24 Jam Terakhir</option>
                <option>7 Hari Terakhir</option>
            </select>
        </div>
        
        <!-- Bars Simulation -->
        <div class="h-64 flex items-end gap-2 relative z-10 px-4">
            @for($i = 0; $i < 40; $i++)
                @php $h = rand(10, 100); $color = $h > 80 ? 'bg-rose-500' : ($h > 50 ? 'bg-indigo-500' : 'bg-slate-700'); @endphp
                <div class="flex-1 {{ $color }} rounded-t-sm hover:opacity-80 transition-opacity cursor-crosshair group relative" style="height: {{ $h }}%">
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 bg-black text-white text-[9px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-20">
                        {{ $h * 12 }} Events
                    </div>
                </div>
            @endfor
        </div>
        <div class="mt-4 flex justify-between text-[10px] font-black text-slate-500 uppercase tracking-widest">
            <span>00:00</span>
            <span>06:00</span>
            <span>12:00</span>
            <span>18:00</span>
            <span>23:59</span>
        </div>
    </div>

    <!-- Log Stream -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <h3 class="font-black text-slate-800 text-lg uppercase">Stream Log Langsung</h3>
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Filter regex..." class="bg-slate-50 border-none rounded-xl text-xs font-bold px-4 py-2.5 w-full md:w-64 focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-900 text-slate-400">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest">Timestamp</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest">Sumber</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest">Event</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest">Detail</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-right">IP Asal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono text-xs">
                    @foreach($logs as $log)
                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                        <td class="px-6 py-4 text-slate-500">{{ $log['waktu']->format('H:i:s.u') }}</td>
                        <td class="px-6 py-4 font-bold text-slate-700">{{ $log['sumber'] }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-2 px-2 py-1 rounded border {{ $log['level'] == 'kritis' ? 'bg-rose-100 text-rose-700 border-rose-200' : ($log['level'] == 'tinggi' ? 'bg-orange-100 text-orange-700 border-orange-200' : 'bg-slate-100 text-slate-600 border-slate-200') }}">
                                @if($log['level'] == 'kritis') <i class="fa-solid fa-bomb"></i> @endif
                                {{ $log['event'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 break-all max-w-md">{{ $log['detail'] }}</td>
                        <td class="px-6 py-4 text-right font-bold text-indigo-600">{{ $log['ip'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
