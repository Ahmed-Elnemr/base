<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\CaseStudy\app\Models\CaseStudy;
use Modules\Home\app\Models\HeroSection;
use Modules\Home\app\Models\Partner;
use Modules\Portfolio\app\Models\Work;

class ScrapeSiteSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Clearing old database records and media...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete existing database records
        HeroSection::truncate();
        Partner::truncate();
        CaseStudy::truncate();
        Work::truncate();

        // Clear associated media from the media table
        DB::table('media')->whereIn('model_type', [
            HeroSection::class,
            Partner::class,
            CaseStudy::class,
            Work::class,
        ])->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Fetching homepage content from Purple Art Agency...');

        // Fetch homepage HTML
        $homeUrl = 'https://www.purpleartagency.net/';
        $homeResponse = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ])->withoutVerifying()->get($homeUrl);

        if (! $homeResponse->successful()) {
            $this->command->error('Failed to fetch the homepage content.');

            return;
        }

        $homeHtml = $homeResponse->body();

        // 1. Seed Hero Section
        $this->command->info('Seeding Hero Section...');
        $hero = HeroSection::create([
            'title' => [
                'ar' => 'وكالة تصميم العلامات التجارية والتعبئة والتغليف في سوريا',
                'en' => 'Branding & Packaging Design Agency in Syria',
            ],
            'subtitle' => [
                'ar' => 'نحن نبني العلامات التجارية',
                'en' => 'We build brands',
            ],
            'button_text_1' => [
                'ar' => 'خدماتنا',
                'en' => 'Our Services',
            ],
            'button_text_2' => [
                'ar' => 'اتصل بنا',
                'en' => 'Contact Us',
            ],
            'button_url_1' => '/services',
            'button_url_2' => '/contact',
        ]);

        // Download a few hero images
        $heroImages = [
            'https://purpleartagency.net//storage/1708/WhatsApp-Image-2024-11-23-at-3.02.55-PM.jpeg',
            'https://purpleartagency.net//storage/1716/WhatsApp-Image-2024-11-23-at-3.25.21-PM.jpeg',
            'https://purpleartagency.net//storage/1710/WhatsApp-Image-2024-11-23-at-3.15.53-PM.jpeg',
            'https://purpleartagency.net//storage/1718/WhatsApp-Image-2024-11-23-at-3.46.20-PM.jpeg',
        ];

        foreach ($heroImages as $imgUrl) {
            $this->downloadAndAttachMedia($hero, $imgUrl, 'hero_image');
        }

        // 2. Seed Partners
        $this->command->info('Scraping and seeding Partners...');
        if (preg_match('/id="client-logos"(.*?)<\/ol>/s', $homeHtml, $partnerContainer)) {
            preg_match_all('/src="([^"]+)"/i', $partnerContainer[1], $partnerImgUrls);
            $partnerLogos = array_unique($partnerImgUrls[1]);

            $sortOrder = 1;
            foreach ($partnerLogos as $logoUrl) {
                // Clean URL double slashes
                $logoUrl = str_replace('purpleartagency.net//', 'purpleartagency.net/', $logoUrl);
                if (str_starts_with($logoUrl, '//')) {
                    $logoUrl = 'https:'.$logoUrl;
                }

                $filename = basename(parse_url($logoUrl, PHP_URL_PATH));
                $name = str_replace(['.png', '.jpg', '.jpeg', '-logo', 'Logo', '-'], ' ', $filename);
                $name = trim(ucwords($name));

                $partner = Partner::create([
                    'name' => $name ?: 'Partner '.$sortOrder,
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]);

                $this->downloadAndAttachMedia($partner, $logoUrl, 'logo');
            }
        } else {
            $this->command->warn('Partners section not found on the page.');
        }

        // 3. Seed Gallery / Works
        $this->command->info('Scraping and seeding Works...');
        $workSortOrder = 1;

        // A. Packaging Works
        if (preg_match('/class="blackSection"(.*?)<\/section>/s', $homeHtml, $blackSection)) {
            preg_match_all('/<img[^>]+src="([^"]+)"[^>]+alt="([^"]*)"/i', $blackSection[1], $packImgMatches, PREG_SET_ORDER);
            foreach ($packImgMatches as $match) {
                $imgUrl = str_replace('purpleartagency.net//', 'purpleartagency.net/', $match[1]);
                $titleAr = trim($match[2]) ?: 'تصميم غلاف إبداعي';
                $titleEn = 'Creative Packaging Design';

                $work = Work::create([
                    'title' => [
                        'ar' => $titleAr,
                        'en' => $titleEn,
                    ],
                    'subtitle' => [
                        'ar' => 'تصميم التغليف والتعبئة',
                        'en' => 'Packaging Design',
                    ],
                    'type' => 'image',
                    'is_active' => true,
                    'sort_order' => $workSortOrder++,
                ]);

                $this->downloadAndAttachMedia($work, $imgUrl, 'work_thumbnail');
            }
        }

        // B. Branding/Marketing Works
        preg_match_all('/<div[^>]+class="[^"]*brandportfolio[^"]*".*?<img[^>]+src="([^"]+)"[^>]*>.*?<h3>([^<]+)<\/h3>/is', $homeHtml, $brandMatches, PREG_SET_ORDER);
        foreach ($brandMatches as $match) {
            $imgUrl = str_replace('purpleartagency.net//', 'purpleartagency.net/', $match[1]);
            $titleAr = trim($match[2]);
            $titleEn = 'Branding & Marketing Work';

            $work = Work::create([
                'title' => [
                    'ar' => $titleAr,
                    'en' => $titleEn,
                ],
                'subtitle' => [
                    'ar' => 'هوية بصرية وتسويق',
                    'en' => 'Branding & Marketing',
                ],
                'type' => 'image',
                'is_active' => true,
                'sort_order' => $workSortOrder++,
            ]);

            $this->downloadAndAttachMedia($work, $imgUrl, 'work_thumbnail');
        }

        // 4. Seed Case Studies
        $this->command->info('Scraping and seeding Case Studies...');
        $caseUrl = 'https://www.purpleartagency.net/case-studies';
        $caseResponse = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ])->withoutVerifying()->get($caseUrl);

        if ($caseResponse->successful()) {
            $caseHtml = $caseResponse->body();
            preg_match_all('/<div[^>]+class="[^"]*portfolio[^"]*".*?<img[^>]+src="([^"]+)"[^>]+alt="([^"]*)"/is', $caseHtml, $caseMatches, PREG_SET_ORDER);

            // Let's seed unique case studies up to a reasonable number
            $seededSlugs = [];
            foreach ($caseMatches as $match) {
                $imgUrl = str_replace('purpleartagency.net//', 'purpleartagency.net/', $match[1]);
                $titleAr = trim($match[2]) ?: 'دراسة حالة إبداعية';
                $slug = Str::slug($titleAr);

                if (empty($slug)) {
                    $slug = 'case-study-'.Str::random(5);
                }

                if (in_array($slug, $seededSlugs)) {
                    continue;
                }
                $seededSlugs[] = $slug;

                $caseStudy = CaseStudy::create([
                    'title' => [
                        'ar' => $titleAr,
                        'en' => 'Case Study - '.ucwords(str_replace('-', ' ', $slug)),
                    ],
                    'description' => [
                        'ar' => 'تفاصيل مشروع ودراسة حالة لـ '.$titleAr,
                        'en' => 'Detailed project study and results for '.ucwords(str_replace('-', ' ', $slug)),
                    ],
                    'slug' => $slug,
                    'is_active' => true,
                ]);

                $this->downloadAndAttachMedia($caseStudy, $imgUrl, 'case_study_image');
            }
        } else {
            $this->command->warn('Failed to fetch Case Studies page. Seeding a default record.');
            CaseStudy::create([
                'title' => [
                    'ar' => 'دراسة حالة إبداعية',
                    'en' => 'Creative Case Study',
                ],
                'description' => [
                    'ar' => 'تفاصيل مشروع ودراسة حالة إبداعية',
                    'en' => 'Detailed project study and results',
                ],
                'slug' => 'creative-case-study',
                'is_active' => true,
            ]);
        }

        $this->command->info('Scraping and database seeding completed successfully!');
    }

    /**
     * Download media from URL safely and attach it using Spatie Media Library.
     */
    private function downloadAndAttachMedia($model, string $url, string $collection): void
    {
        try {
            $url = trim($url);
            if (empty($url)) {
                return;
            }

            // Clean any double slashes in host/path
            $url = str_replace('purpleartagency.net//', 'purpleartagency.net/', $url);
            if (str_starts_with($url, '//')) {
                $url = 'https:'.$url;
            }

            $tempFile = tempnam(sys_get_temp_dir(), 'media_scrape_');

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
            $data = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($data && $httpCode === 200) {
                file_put_contents($tempFile, $data);
                $filename = basename(parse_url($url, PHP_URL_PATH));

                $model->addMedia($tempFile)
                    ->usingFileName($filename)
                    ->toMediaCollection($collection);

                $this->command->info("Successfully attached media from URL: {$url}");
            } else {
                $this->command->warn("Failed to download media from URL: {$url} (HTTP Code: {$httpCode})");
            }

            @unlink($tempFile);
        } catch (\Exception $e) {
            $this->command->error("Error seeding media from {$url}: ".$e->getMessage());
        }
    }
}
