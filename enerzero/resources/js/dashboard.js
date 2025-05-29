document.addEventListener('DOMContentLoaded', function() {
    const energyUsage = window.energyUsage;

    const labels = energyUsage.map(item => item.label);
    const values = energyUsage.map(item => item.value);
    const colors = energyUsage.map(item => item.color);

    const ctx = document.getElementById('energyPieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Energy Usage',
                data: values,
                backgroundColor: colors,
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    const button = document.getElementById('settings-button');
    const menu = document.getElementById('dropdown-menu');

    button.addEventListener('click', function(event) {
        event.stopPropagation();
        menu.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        if (!menu.contains(event.target) && !button.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    const notifButton = document.getElementById('notif-button');
    const notifDropdown = document.getElementById('notif-dropdown');

    notifButton?.addEventListener('click', function(event) {
        event.stopPropagation();
        notifDropdown?.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        if (!notifDropdown?.contains(event.target) && !notifButton?.contains(event.target)) {
            notifDropdown?.classList.add('hidden');
        }
    });

    const slider = document.getElementById('product-slider');
    const totalSlides = slider.children.length;
    let current = 0;

    function showSlide(index) {
        const percentage = -(index * 100);
        slider.style.transform = `translateX(${percentage}%)`;
    }

    setInterval(() => {
        current = (current + 1) % totalSlides;
        showSlide(current);
    }, 3000);
});
