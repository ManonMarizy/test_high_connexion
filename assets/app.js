// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);



const barChart = document.getElementById('barChart');
const barChartDonations = barChart.dataset.donationsAmount;
const barChartNbOfPeople = barChart.dataset.nbofPeopleDonations;
console.log(barChart.dataset.donationsAmount)
console.log(barChart.dataset.nbofpeopleDonations)
new Chart(barChart.getContext('2d'), {
    type: 'bar',
    data: {
        labels: barChartDonations,
        datasets: [{
            label: 'Dons',
            data: barChartNbOfPeople,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


const pieChart = document.getElementById('pieChart');
const pieChartTenDepartmentCountPeople = pieChart.dataset.tenDepartmentsCountPeople;
const pieChartTenDepartmentNumber = pieChart.dataset.tenDepartmentsNumbers;
console.log(pieChartTenDepartmentNumber)
console.log(pieChartTenDepartmentCountPeople)

new Chart(pieChart.getContext('2d'), {
    type: 'pie',
    data: {
        labels: pieChartTenDepartmentNumber,
        datasets: [{
            label: 'Répartition par départements',
            data: pieChartTenDepartmentCountPeople,
        }]
    },
});



