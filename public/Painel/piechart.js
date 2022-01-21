let ctx2 = document.getElementById('piechart').getContext('2d');
let piechart = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            backgroundColor: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            borderColor: 'rgb(255, 99, 132)',
            data: [12, 19, 3, 5, 2, 3],
            fill: 'start'          
        }]
    },
    options: {
        tension: 0.3,
        maintainAspectRatio: true
    }
});