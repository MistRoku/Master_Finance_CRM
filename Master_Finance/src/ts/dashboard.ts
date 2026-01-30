import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    const chartCanvas = document.getElementById('chart') as HTMLCanvasElement;
    if (chartCanvas) {
        fetch('/api/transactions', {
            method: 'GET',
            headers: {
                'X-CSRF-Token': getCsrfToken(),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const labels = data.map((t: any) => t.date);
            const values = data.map((t: any) => t.amount);
            new Chart(chartCanvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Transaction Amounts',
                        data: values,
                        borderColor: '#DC2626',
                        backgroundColor: 'rgba(220, 38, 38, 0.2)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
        })
        .catch(error => console.error('Error loading chart:', error));
    }

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const inputs = form.querySelectorAll('input[required]');
            let valid = true;
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = '#DC2626';
                    valid = false;
                } else {
                    input.style.borderColor = '#B91C1C';
                }
            });
            if (!valid) {
                e.preventDefault();
                alert('Please fill all required fields.');
            }
        });
    });
});

function getCsrfToken(): string {
    const meta = document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement;
    return meta ? meta.content : '';
}