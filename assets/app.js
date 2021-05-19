// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
require('bootstrap');

import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);



const barChart = document.getElementById('barChart');
const barChartDonations = barChart.dataset.donationsAmount;
const barChartNbOfPeople = barChart.dataset.nbofpeopleDonations;
console.log(barChartDonations)
console.log(barChartNbOfPeople)
new Chart(barChart.getContext('2d'), {
    type: 'bar',
    data: {
        labels: JSON.parse(barChartDonations),
        datasets: [{
            label: 'Dons',
            data: JSON.parse(barChartNbOfPeople),
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
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Répartition des dons par montants'
            }
        }
    }
});



const pieChart = document.getElementById('pieChart');
const pieChartTenDepartmentCountPeople = JSON.parse(pieChart.dataset.tenDepartmentsCountPeople);
const pieChartTenDepartmentNumber = JSON.parse(pieChart.dataset.tenDepartmentsNumbers);

new Chart(pieChart.getContext('2d'), {
    type: 'pie',
    data: {
        labels: pieChartTenDepartmentNumber,
        datasets: [{
            label: 'Répartition par départements',
            data: pieChartTenDepartmentCountPeople,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 50, 86, 0.2)',
                'rgba(75, 100, 192, 0.2)',
                'rgba(160, 10, 150, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(128, 128, 128, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 50, 86, 1)',
                'rgba(75, 100, 192, 1)',
                'rgba(160, 10, 150, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(128, 128, 128, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Répartition des donateurs '
            }
        }
    }
});



