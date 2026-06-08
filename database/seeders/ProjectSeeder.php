<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Menghapus data lama agar tidak terjadi duplikasi saat seeder dijalankan
        Project::truncate();

        // 1. Proyek Remano: Audio DSP
        Project::create([
            'title' => 'Audio DSP Master',
            'creator' => 'Mochamad Remano D.',
            'category' => 'Signal Processing & Software',
            'description' => 'This project aims to build an interactive graphical user interface (GUI) in MATLAB. The application facilitates users to load audio files, apply various digital filters, and visualize real-time frequency spectrum changes.',
            'image' => 'proyek-dsp.jpg'
        ]);

        // 2. Proyek Jonathan: Subnet Calculator
        Project::create([
            'title' => 'Python Subnet Calculator',
            'creator' => 'Jonathan Christopher S. D.',
            'category' => 'Network Engineering & Scripting',
            'description' => 'A Python-based automation script that streamlines the IP Address calculation process. By inputting an IP and CIDR value, the program instantly generates the Network ID, Broadcast, Subnet Mask, and valid IP range.',
            'image' => 'proyek-subnet.jpg'
        ]);

        // 3. Proyek Remano: Microstrip Antenna
        Project::create([
            'title' => '5.8 GHz Microstrip Antenna Simulation',
            'creator' => 'Mochamad Remano D.',
            'category' => 'RF Engineering & Telecommunication',
            'description' => 'Research and design of a microstrip patch antenna optimized to operate at the 5.8 GHz frequency. The simulation process includes the analysis of critical parameters such as return loss, VSWR, and radiation pattern.',
            'image' => 'proyek-antenna.jpg'
        ]);

        // 4. Proyek Jonathan: Server Temp Sensor
        Project::create([
            'title' => 'Server Room Temperature Sensor',
            'creator' => 'Jonathan Christopher S. D.',
            'category' => 'Internet of Things & Hardware',
            'description' => 'An IT infrastructure security system prototype using Arduino and temperature sensors. This system continuously monitors server rack temperatures and triggers an alert if the temperature exceeds hardware tolerance limits.',
            'image' => 'proyek-suhu.jpg'
        ]);

        // 5. Proyek Remano: Voice Clarifier
        Project::create([
            'title' => 'Voice Clarifier Pro',
            'creator' => 'Mochamad Remano D.',
            'category' => 'Signal Processing & Software',
            'description' => 'A comprehensive MATLAB program designed to repair audio quality. Its internal algorithms can detect and suppress background noise frequencies, producing much clearer vocal output.',
            'image' => 'proyek-clarifier.jpg'
        ]);

        // 6. Proyek Jonathan: Smart Farm
        Project::create([
            'title' => 'IoT Smart Farm Monitor',
            'creator' => 'Jonathan Christopher S. D.',
            'category' => 'Internet of Things & Hardware',
            'description' => 'A smart project integrating soil moisture sensors with a WiFi module. Soil condition data is transmitted in real-time to a dashboard to optimize agricultural watering systems remotely.',
            'image' => 'proyek-tani.jpg'
        ]);
    }
}