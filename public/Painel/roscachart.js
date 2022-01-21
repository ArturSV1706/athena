let ctx3 = document.getElementById('roscachart').getContext('2d');
let roscachart = new Chart(ctx3, {
    type: 'doughnut',
    data: {
        labels: ['Red', 'Blue', 'Yellow'],
        datasets: [{
            label: '# of Votes',
            backgroundColor:['Red', 'Blue', 'Yellow'],
            borderColor: 'rgba(255, 99, 132, 0)',
            data: [<?php echo $alunos ?>, <?php echo $alunos ?>, <?php echo $alunos ?>],
            fill: 'start'          
        }]
    },
    options: {
        tension: 0.3,
        maintainAspectRatio: true
    }
});