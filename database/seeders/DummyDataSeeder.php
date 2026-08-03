<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;
use App\Models\Project;
use App\Models\Experience;
use App\Models\SkillCategory;
use App\Models\Skill;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Skill Categories
        $frontendCat = SkillCategory::create([
            'title_id' => 'Pengembangan Frontend',
            'title_en' => 'Frontend Development'
        ]);

        $backendCat = SkillCategory::create([
            'title_id' => 'Pengembangan Backend',
            'title_en' => 'Backend Development'
        ]);

        // 2. Skills
        Skill::create([
            'skill_category_id' => $frontendCat->id,
            'title_id' => 'React & Next.js',
            'title_en' => 'React & Next.js',
            'percentage' => 90,
            'icon' => '<svg class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>'
        ]);
        
        Skill::create([
            'skill_category_id' => $frontendCat->id,
            'title_id' => 'Tailwind CSS',
            'title_en' => 'Tailwind CSS',
            'percentage' => 95,
            'icon' => '<svg class="w-8 h-8 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'
        ]);

        Skill::create([
            'skill_category_id' => $backendCat->id,
            'title_id' => 'Laravel (PHP)',
            'title_en' => 'Laravel (PHP)',
            'percentage' => 85,
            'icon' => '<svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>'
        ]);

        Skill::create([
            'skill_category_id' => $backendCat->id,
            'title_id' => 'MySQL & PostgreSQL',
            'title_en' => 'MySQL & PostgreSQL',
            'percentage' => 80,
            'icon' => '<svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>'
        ]);

        // 3. Experience
        Experience::create([
            'title_id' => 'Senior Full Stack Developer',
            'title_en' => 'Senior Full Stack Developer',
            'company' => 'TechCorp Indonesia',
            'start_date' => '2023-01-01',
            'end_date' => null, // Present
            'description_id' => 'Memimpin tim pengembang dalam membangun sistem ERP perusahaan menggunakan Laravel dan React. Berhasil meningkatkan efisiensi sistem sebesar 40%.',
            'description_en' => 'Led a team of developers in building an enterprise ERP system using Laravel and React. Successfully improved system efficiency by 40%.'
        ]);

        Experience::create([
            'title_id' => 'Web Developer',
            'title_en' => 'Web Developer',
            'company' => 'Creative Agency',
            'start_date' => '2020-05-01',
            'end_date' => '2022-12-31',
            'description_id' => 'Mengembangkan lebih dari 20 website klien berkinerja tinggi menggunakan berbagai framework modern.',
            'description_en' => 'Developed over 20 high-performance client websites using various modern frameworks.'
        ]);

        // 4. Project Categories
        $webCat = ProjectCategory::create([
            'title_id' => 'Aplikasi Web',
            'title_en' => 'Web Application'
        ]);

        // 5. Projects
        Project::create([
            'project_category_id' => $webCat->id,
            'title_id' => 'Sistem Manajemen Klinik',
            'title_en' => 'Clinic Management System',
            'description_id' => 'Aplikasi web komprehensif untuk mengelola data pasien, jadwal dokter, dan apotek.',
            'description_en' => 'Comprehensive web application for managing patient data, doctor schedules, and pharmacy.',
            'url' => 'https://example.com/clinic',
            'repo_url' => 'https://github.com/danang/clinic-system'
        ]);

        Project::create([
            'project_category_id' => $webCat->id,
            'title_id' => 'Platform E-Commerce B2B',
            'title_en' => 'B2B E-Commerce Platform',
            'description_id' => 'Platform grosir yang mendukung transaksi dalam jumlah besar, integrasi API logistik, dan laporan keuangan.',
            'description_en' => 'Wholesale platform supporting bulk transactions, logistics API integrations, and financial reporting.',
            'url' => 'https://example.com/b2b',
            'repo_url' => 'https://github.com/danang/b2b-ecommerce'
        ]);
        
        Project::create([
            'project_category_id' => $webCat->id,
            'title_id' => 'Portofolio Interaktif (OS Mode)',
            'title_en' => 'Interactive Portfolio (OS Mode)',
            'description_id' => 'Website portofolio yang dirancang menyerupai sistem operasi desktop dengan fitur AI dan Command Line Interface.',
            'description_en' => 'Portfolio website designed to resemble a desktop operating system with AI capabilities and Command Line Interface.',
            'url' => 'https://danang.com',
            'repo_url' => 'https://github.com/danang/portfolio-os'
        ]);
    }
}
