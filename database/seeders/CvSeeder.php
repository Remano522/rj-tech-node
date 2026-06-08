<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cv;

class CvSeeder extends Seeder
{
    public function run(): void
    {
        Cv::truncate(); // Bersihkan data lama

        // Data CV Remano
        Cv::create([
            'slug' => 'remano',
            'name' => 'Mochamad Remano Darusatwiko',
            'photo' => null,
            'role' => 'Undergraduate Telecommunication Student - Network Engineering Enthusiast',
            'bio' => 'Enthusiastic and curious student with a strong interest in network engineering, system administration, and telecommunications. Passionate about continuous learning and hands-on practice in IT infrastructure, networking technologies, and system troubleshooting.',
            'education' => 'Bachelor of Applied Engineering in Electrical Engineering, Broadband Multimedia - Politeknik Negeri Jakarta (2024 - 2028)',
            'skills' => ["Network Engineering", "System Administration", "Cisco Networking", "Mikrotik Configuration", "Hardware Troubleshooting", "MATLAB", "Python"],
            'experience' => [
                "<strong>IT Support Technician</strong> - LOUSER Elevator (Jan 2023 - Mar 2023)<br>Installed, configured, and maintained LAN/WAN infrastructure. Managed Mikrotik routers and performed hardware/software troubleshooting.",
                "<strong>Onsite Engineer</strong> - Rukan Shibuya PIK 2 (Jul 2022)<br>Planned and executed structured network cabling. Installed and configured Mikrotik CCR and CRS devices for robust routing and switching systems.",
                "<strong>School Lab Assistant</strong> - SMK Budhi Warman 1 (Oct 2020 - Dec 2022)<br>Maintained network systems across four computer laboratories and supported IT education for 12th-grade students on Mikrotik and Cisco technologies."
            ],
            'certifications' => [
                "Cisco CCNA 200-301",
                "Ruijie Certified Network Associate (RCNA) - Wireless LAN",
                "SP1000 - Infrastructure Solutions for Broadband/FTTx Applications",
                "WR9100 - Introduction to Building Cabling Solutions"
            ]
        ]);

        // Data CV Jonathan
        Cv::create([
            'slug' => 'jonathan',
            'name' => 'Jonathan Christopher S. Depari',
            'photo' => null,
            'role' => 'Undergraduate Telecommunication Student - Logic & System Integration Enthusiast',
            'bio' => 'Highly motivated telecommunication engineering student focusing on system integration, Internet of Things (IoT), and automation logic. Adept at designing smart networks and implementing hardware-software solutions to solve real-world problems.',
            'education' => 'Bachelor of Applied Engineering in Electrical Engineering, Broadband Multimedia - Politeknik Negeri Jakarta (2024 - 2028)',
            'skills' => ["Python Automation", "Cisco Packet Tracer", "Network Protocols", "Internet of Things (IoT)", "Hardware Integration", "JavaScript Logic", "C++ for Arduino"],
            'experience' => [
                "<strong>Junior IoT Developer (Intern)</strong> - SmartNet Solutions (Jun 2023 - Aug 2023)<br>Assisted in developing microcontroller-based sensor systems for smart building prototypes and integrated data flow to cloud dashboards.",
                "<strong>Network Support Volunteer</strong> - Tech Community Jakarta (Jan 2022 - Dec 2022)<br>Provided technical assistance in setting up local area networks (LAN) during community tech workshops and seminars."
            ],
            'certifications' => [
                "Introduction to IoT - Cisco Networking Academy",
                "Python Core - Sololearn",
                "Basic Network Security - TechCamp"
            ]
        ]);
    }
}
