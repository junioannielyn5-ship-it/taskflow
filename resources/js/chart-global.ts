import { Chart, registerables } from 'chart.js';

declare global {
    interface Window {
        Chart: typeof Chart;
    }
}

Chart.register(...registerables);
window.Chart = Chart;
