<v-charts-bar {{ $attributes }}></v-charts-bar>

@pushOnce('scripts')
    <!-- SEO Vue Component Template -->
    <script
        type="text/x-template"
        id="v-charts-bar-template"
    >
        <canvas
            :id="$.uid + '_chart'"
            class="flex w-full max-w-full items-end"
            :style="'aspect-ratio:' + aspectRatio + '/1'"
            style=""
        ></canvas>
    </script>

    <script type="module">
        app.component('v-charts-bar', {
            template: '#v-charts-bar-template',

            props: {
                labels: {
                    type: Array,
                    default: [],
                },

                datasets: {
                    type: Array,
                    default: [],
                },

                aspectRatio: {
                    type: Number,
                    default: 3.23,
                },
            },

            data() {
                return {
                    chart: undefined,
                }
            },

            mounted() {
                this.prepare();

                this.$emitter.on('change-theme', () => {
                    this.prepare();
                });
            },

            methods: {
                prepare() {
                    const isDark = document.documentElement.classList.contains('dark');
                    const tickColor = isDark ? '#94A3B8' : '#64748B';
                    const gridColor = isDark ? 'rgba(148, 163, 184, 0.14)' : 'rgba(15, 23, 42, 0.08)';
                    const barCount = this.datasets.length;
                    
                    this.datasets.forEach((dataset) => {
                        dataset.barThickness = Math.max(4, 36 / barCount);
                    });
        
                    if (this.chart) {
                        this.chart.destroy();
                    }

                    this.chart = new Chart(document.getElementById(this.$.uid + '_chart'), {
                        type: 'bar',
                        
                        data: {
                            labels: this.labels,

                            datasets: this.datasets,
                        },

                        options: {
                            aspectRatio: this.aspectRatio,
                            
                            plugins: {
                                legend: {
                                    display: false
                                },
                            },
                            
                            scales: {
                                x: {
                                    beginAtZero: true,

                                    ticks: {
                                        color: tickColor,
                                    },

                                    grid: {
                                        color: gridColor,
                                    },

                                    border: {
                                        dash: [8, 4],
                                    }
                                },

                                y: {
                                    beginAtZero: true,

                                    ticks: {
                                        color: tickColor,
                                    },

                                    grid: {
                                        color: gridColor,
                                    },

                                    border: {
                                        dash: [8, 4],
                                    }
                                }
                            }
                        }
                    });
                }
            }
        });
    </script>
@endPushOnce