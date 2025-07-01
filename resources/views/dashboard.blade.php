@extends('layouts.app')
@push('styles')
<style>
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-thumb {
        background-color: #4a5568;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-track {
        background-color: #2d3748;
    }
</style>
@endpush
@section('content')
@if (session('success') === 'rest-updated')
    <div x-data="{ show: true }" x-show="show"
        class="relative bg-green-500 text-white px-4 py-2 rounded text-sm flex items-center justify-between mt-4 mb-4">
        <span>🎉 Great! All your activities have been updated successfully!</span>
        <button type="button" @click="show = false" class="ml-4 text-white hover:text-gray-100 focus:outline-none">
            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </button>
    </div>
@endif


<header class="flex items-center justify-between h-16 px-6 bg-gray-800 border-b border-gray-700 rounded-lg">
    <div class="flex items-center space-x-4">
        <span class="text-white text-xl font-bold">Dashboard Statistics</span>
    </div>
    <x-danger-button x-data x-on:click.prevent="$dispatch('open-modal', 'confirm-reset-activity')" class="px-3 py-1.5 text-sm bg-pink-700 hover:bg-pink-800">🔁 Reset Activity</x-danger-button>
    <x-modal name="confirm-reset-activity" :show="$errors->resetActivity->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('reset.analysis') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Are you sure you want to clear Activity?</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">This will permanently delete all your Analyst Login and Security Log Data.</p>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-danger-button class="ml-3 px-4 py-2 text-sm">Yes, Reset</x-danger-button>
            </div>
        </form>
    </x-modal>
</header>


<main class="flex-1 overflow-x-hidden overflow-y-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-3 gap-6 mb-6 mt-6">
        <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-start">
            <div class="text-gray-400 text-sm font-semibold mb-2">ANALYST LOGIN</div>
            <div class="flex items-center justify-between w-full">
                <span id="analystLogin" class="text-3xl font-bold text-white">{{ $user->analyze_logins_count }}</span>
                <div class="p-2 bg-blue-600 rounded-full">
                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-start">
            <div class="text-gray-400 text-sm font-semibold mb-2">SECURITY ANALYST</div>
            <div class="flex items-center justify-between w-full">
                <span id="analyzSecurity" class="text-3xl font-bold text-white">{{ $user->analyzesecurity_count }}</span>
                <div class="p-2 bg-red-600 rounded-full">
                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 003 14v1a1 1 0 001 1h12a1 1 0 001-1v-1a1 1 0 00-.293-.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 110-6 3 3 0 010 6z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-start">
            <div class="text-gray-400 text-sm font-semibold mb-2">TOTAL REQUEST</div>
            <div class="flex items-center justify-between w-full">
                <span id="totalRequest" class="text-3xl font-bold text-white">{{ $totalActivityCount }}</span>
                <div class="p-2 bg-green-600 rounded-full">
                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12H7V8h2v4zm5-4h-2v4h2V8z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-gray-800 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-white mb-4">All Visitor (Last 7 days)</h2>
            <div class="text-gray-400 text-sm mb-4">STATISTICS <span class="font-bold">Indonesia Timezone</span></div>
            <div class="relative h-64">
                <canvas id="visitorChart"></canvas>
            </div>
            <div class="flex justify-center items-center mt-4 space-x-6">
                <div class="flex items-center">
                    <span class="block w-3 h-3 rounded-full bg-purple-500 mr-2"></span>
                    <span class="text-sm text-gray-400">ANALYST LOGIN</span>
                </div>
                <div class="flex items-center">
                    <span class="block w-3 h-3 rounded-full bg-pink-500 mr-2"></span>
                    <span class="text-sm text-gray-400">SECURITY ANALYST</span>
                </div>
                <div class="flex items-center">
                    <span class="block w-3 h-3 rounded-full bg-indigo-500 mr-2"></span>
                    <span class="text-sm text-gray-400">TOTAL REQUEST</span>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 flex flex-col space-y-4">
            <h2 class="text-xl font-semibold text-white mb-2">Summary</h2>
            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-md">
                <span class="text-gray-300">ANALYST LOGIN</span>
                <span id="analystLogin" class="text-white text-lg font-bold">{{ $user->analyze_logins_count }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-md">
                <span class="text-gray-300">SECURITY ANALYST</span>
                <span id="analyzSecurity" class="text-white text-lg font-bold">{{ $user->analyzesecurity_count }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-md">
                <span class="text-gray-300">TOTAL REQUEST</span>
                <span id="totalRequest" class="text-white text-lg font-bold">{{ $totalActivityCount }}</span>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let visitorChart;

    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('visitorChart').getContext('2d');

        const initialLabels = @json($chartLabels);
        const initialHumanData = @json($chartHumanData);
        const initialPotentialData = @json($chartPotentialData);
        const initialTotalData = @json($chartTotalData);

        visitorChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: initialLabels,
                datasets: [
                    {
                        label: 'ANALYST LOGIN',
                        data: initialHumanData,
                        borderColor: 'rgb(168, 85, 247)',
                        backgroundColor: 'rgba(168, 85, 247, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'SECURITY ANALYST',
                        data: initialPotentialData,
                        borderColor: 'rgb(236, 72, 153)',
                        backgroundColor: 'rgba(236, 72, 153, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'TOTAL REQUEST',
                        data: initialTotalData,
                        borderColor: 'rgb(99, 102, 241)',
                        backgroundColor: 'rgba(99, 102, 241, 0.2)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(75, 85, 99, 0.5)',
                        },
                        ticks: {
                            color: '#9ca3af',
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(75, 85, 99, 0.5)',
                        },
                        ticks: {
                            color: '#9ca3af',
                        }
                    }
                }
            }
        });

        // ⏱ Update data setiap 10 detik
        setInterval(fetchLiveStats, 10000);
    });

    function fetchLiveStats() {
        fetch("{{ route('dashboard.live.stats') }}")
            .then(response => response.json())
            .then(data => {
                // Update chart
                visitorChart.data.labels = data.labels;
                visitorChart.data.datasets[0].data = data.human;
                visitorChart.data.datasets[1].data = data.potential;
                visitorChart.data.datasets[2].data = data.total;
                visitorChart.update();

                // ANALYST LOGIN (Human)
                const humanCount = data.human.reduce((a, b) => a + b, 0);
                const analystLoginEl = document.getElementById('analystLogin');
                if (analystLoginEl) {
                    analystLoginEl.textContent = humanCount;
                }

                // SECURITY ANALYST (Potential)
                const potentialCount = data.potential.reduce((a, b) => a + b, 0);
                const securityEl = document.getElementById('analyzSecurity');
                if (securityEl) {
                    securityEl.textContent = potentialCount;
                }

                // TOTAL REQUEST
                const totalCount = data.total.reduce((a, b) => a + b, 0);
                const totalEl = document.getElementById('totalRequest');
                if (totalEl) {
                    totalEl.textContent = totalCount;
                }
            })
            .catch(error => {
                console.error("Live stats fetch error:", error);
            });
    }
</script>
@endpush
