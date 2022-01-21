// Setup block
var currentDate = new Date();
var segunda = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 1)).toISOString().substring(0, 10);
var terça = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 2)).toISOString().substring(0, 10);
var quarta = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 3)).toISOString().substring(0, 10);
var quinta = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 4)).toISOString().substring(0, 10);
var sexta = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 5)).toISOString().substring(0, 10);
console.log(segunda, terça, quarta, quinta, sexta);

const data = {
  datasets: [
    {
      label: "Livros emprestados nestea semana",
      backgroundColor: "rgba(117, 104, 240, 0.4)",
      borderColor: "rgb(117, 104, 240)",
      data: [
       {x: segunda, y: 20}, 
       {x: terça, y: 34}, 
       {x: quarta, y: 5}, 
       {x: quinta, y: 12}, 
       {x: sexta, y: 22}, 
      ],
      fill: "start",
    },
  ],
};
// config block
const config = {
  type: "line",
  data,
  options: {
    scales: {
      x:{
        type: 'time',
        time:{
          unit: 'day'
        }
      },
      y: {
        beingAtZero: true,
      },
    },
    tension: 0.3,
    maintainAspectRatio: false
  },
};

// render / init
const linechart = new Chart(
  document.getElementById('linechart'),
  config
);


