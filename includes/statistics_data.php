<?php
/**
 * Statistics Data
 * 
 * This file provides mock data for the statistics page.
 * In a real application, this would be fetched from a database.
 */

// Mock visitor data
$visitorData = [
    ['month' => 'Jan', 'visitors' => 2500],
    ['month' => 'Feb', 'visitors' => 3000],
    ['month' => 'Mar', 'visitors' => 4000],
    ['month' => 'Apr', 'visitors' => 3800],
    ['month' => 'May', 'visitors' => 5000],
    ['month' => 'Jun', 'visitors' => 6000],
    ['month' => 'Jul', 'visitors' => 7500],
];

// Mock region distribution data
$regionData = [
    ['name' => 'Île-de-France', 'value' => 35, 'color' => 'rgb(54, 162, 235)'],
    ['name' => 'Auvergne-Rhône-Alpes', 'value' => 20, 'color' => 'rgb(255, 99, 132)'],
    ['name' => 'Nouvelle-Aquitaine', 'value' => 15, 'color' => 'rgb(255, 205, 86)'],
    ['name' => 'Occitanie', 'value' => 12, 'color' => 'rgb(75, 192, 192)'],
    ['name' => 'Autres', 'value' => 18, 'color' => 'rgb(153, 102, 255)'],
];

// Mock search data
$searchData = [
    ['name' => 'Paris', 'searches' => 1200],
    ['name' => 'Lyon', 'searches' => 800],
    ['name' => 'Marseille', 'searches' => 750],
    ['name' => 'Bordeaux', 'searches' => 600],
    ['name' => 'Toulouse', 'searches' => 550],
];

// Filter data based on request parameters
$timeRange = $_GET['time_range'] ?? 'month';
$region = $_GET['region'] ?? 'all';

// In a real application, you would modify the data based on filters
// For this example, we'll just return the mock data
?>