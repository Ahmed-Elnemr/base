<?php
// d:\nemr\base\database\seeders\scrape.php

$categories = [
    'food' => [
        'name_ar' => 'طعام',
        'name_en' => 'Food',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D8%B7%D8%B9%D8%A7%D9%85'
    ],
    'spices-nuts' => [
        'name_ar' => 'توابل ومكسرات',
        'name_en' => 'Spices & Nuts',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D8%AA%D9%88%D8%A7%D8%A8%D9%84%20%D9%88%D9%85%D9%83%D8%B3%D8%B1%D8%A7%D8%AA'
    ],
    'billboards' => [
        'name_ar' => 'لوحات إعلانية',
        'name_en' => 'Billboards',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D9%84%D9%88%D8%AD%D8%A7%D8%AA%20%D8%A5%D8%B9%D9%84%D8%A7%D9%86%D9%8A%D8%A9'
    ],
    'chemicals-detergents' => [
        'name_ar' => 'مواد كيميائية ومنظفات',
        'name_en' => 'Chemicals & Detergents',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D9%85%D9%88%D8%A7%D8%AF%20%D9%83%D9%8A%D9%85%D9%8A%D8%A7%D8%A6%D9%8A%D8%A9%20%D9%88%D9%85%D9%86%D8%B8%D9%81%D8%A7%D8%AA'
    ],
    'industrial-electrical' => [
        'name_ar' => 'مواد صناعية وكهربائية',
        'name_en' => 'Industrial & Electrical',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D9%85%D9%88%D8%A7%D8%AF%20%D8%B5%D9%86%D8%A7%D8%B9%D9%8A%D8%A9%20%20%D9%88%D9%83%D9%87%D8%B1%D8%A8%D8%A7%D8%A6%D9%8A%D8%A9'
    ],
    'pharmaceuticals-cosmetics' => [
        'name_ar' => 'أدوية ومستحضرات تجميل',
        'name_en' => 'Pharmaceuticals & Cosmetics',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D8%A3%D8%AF%D9%88%D9%8A%D8%A9%20%D9%88%D9%85%D8%B3%D8%AA%D8%AD%D8%B6%D8%B1%D8%A7%D8%AA%20%D8%AA%D8%AC%D9%85%D9%8A%D9%84'
    ],
    'frozen-foods' => [
        'name_ar' => 'الاطعمة المجمدة',
        'name_en' => 'Frozen Foods',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D8%A7%D9%84%D8%A7%D8%B7%D8%B9%D9%85%D8%A9%20%D8%A7%D9%84%D9%85%D8%AC%D9%85%D8%AF%D8%A9'
    ],
    'dairy-products' => [
        'name_ar' => 'منتجات الالبان',
        'name_en' => 'Dairy Products',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D9%85%D9%86%D8%AA%D8%AC%D8%A7%D8%AA%20%D8%A7%D9%84%D8%A7%D9%84%D8%A8%D8%A7%D9%86'
    ],
    'exhibition-stands' => [
        'name_ar' => 'ستاندات و أجنحة المعارض',
        'name_en' => 'Exhibition Stands',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D8%B3%D8%AA%D8%A7%D9%86%D8%AF%D8%A7%D8%AA%20%D9%88%20%D8%A3%D8%AC%D9%86%D8%AD%D8%A9%20%D8%A7%D9%84%D9%85%D8%B9%D8%A7%D8%B1%D8%B6'
    ],
    'chocolate-biscuits' => [
        'name_ar' => 'شوكولا و بسكويت',
        'name_en' => 'Chocolate & Biscuits',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D8%B4%D9%88%D9%83%D9%88%D9%84%D8%A7%20%D9%88%20%D8%A8%D8%B3%D9%83%D9%88%D9%8A%D8%AA'
    ],
    'consumer-goods' => [
        'name_ar' => 'سلع استهلاكية',
        'name_en' => 'Consumer Goods',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D8%B3%D9%84%D8%B9%20%D8%A7%D8%B3%D8%AA%D9%87%D9%84%D8%A7%D9%83%D9%8A%D8%A9'
    ],
    'chips' => [
        'name_ar' => 'شيبس',
        'name_en' => 'Chips',
        'url' => 'https://www.purpleartagency.net/packaging-design/%D8%B4%D9%8A%D8%A8%D8%B3'
    ],
];

$baseDir = __DIR__ . '/images';
if (!is_dir($baseDir)) {
    mkdir($baseDir, 0777, true);
}

$scrapedData = [];
$maxItemsPerCategory = 8;

foreach ($categories as $slug => $cat) {
    echo "========================================\n";
    echo "Fetching Category: {$cat['name_ar']} ({$slug})...\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $cat['url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $html = curl_exec($ch);
    curl_close($ch);

    if (!$html) {
        echo "ERROR: Failed to fetch URL {$cat['url']}\n";
        continue;
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $items = $xpath->query("//div[contains(@class, 'portfolio')]");
    
    $totalItems = $items->length;
    echo "Found {$totalItems} total items. Will limit to {$maxItemsPerCategory}.\n";

    $catDir = $baseDir . '/' . $slug;
    if (!is_dir($catDir)) {
        mkdir($catDir, 0777, true);
    }

    $categoryItems = [];
    $itemIndex = 0;

    foreach ($items as $item) {
        $itemIndex++;
        if ($itemIndex > $maxItemsPerCategory) {
            break;
        }

        $imgNode = $xpath->query(".//img", $item)->item(0);
        $imgSrc = $imgNode ? $imgNode->getAttribute('src') : '';
        
        $titleNode = $xpath->query(".//h6", $item)->item(0);
        $title = $titleNode ? trim($titleNode->nodeValue) : '';
        
        $spanNode = $xpath->query(".//span", $item)->item(0);
        $span = $spanNode ? trim($spanNode->nodeValue) : '';
        
        $pNodes = $xpath->query(".//p", $item);
        $pText = '';
        foreach ($pNodes as $p) {
            if ($p->parentNode->tagName === 'div' && $p->parentNode->getAttribute('class') === 'animated fadeInUp') {
                continue;
            }
            $pText = trim($p->nodeValue);
        }

        // Clean double slashes in img URL
        if (str_starts_with($imgSrc, '//')) {
            $imgSrc = 'https:' . $imgSrc;
        } elseif (strpos($imgSrc, 'purpleartagency.net//') !== false) {
            $imgSrc = str_replace('purpleartagency.net//', 'purpleartagency.net/', $imgSrc);
        }

        $localFilename = '';
        if ($imgSrc) {
            $pathParts = explode('/', parse_url($imgSrc, PHP_URL_PATH));
            $filename = end($pathParts);
            $parentFolder = prev($pathParts);
            if ($parentFolder && is_numeric($parentFolder)) {
                $localFilename = $parentFolder . '_' . $filename;
            } else {
                $localFilename = $itemIndex . '_' . $filename;
            }

            // Sanitize filename
            $localFilename = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $localFilename);
            $localPath = $catDir . '/' . $localFilename;

            if (file_exists($localPath)) {
                echo "  Item {$itemIndex}: Image already exists locally: {$localFilename}\n";
            } else {
                echo "  Item {$itemIndex}: Downloading image: {$imgSrc} -> {$localFilename}...\n";
                $imgCh = curl_init();
                curl_setopt($imgCh, CURLOPT_URL, $imgSrc);
                curl_setopt($imgCh, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($imgCh, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
                curl_setopt($imgCh, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($imgCh, CURLOPT_TIMEOUT, 30);
                $imgData = curl_exec($imgCh);
                curl_close($imgCh);

                if ($imgData) {
                    file_put_contents($localPath, $imgData);
                } else {
                    echo "    WARNING: Failed to download image {$imgSrc}\n";
                    $localFilename = '';
                }
            }
        }

        $categoryItems[] = [
            'title_ar' => $title ?: ('عمل رقم ' . $itemIndex),
            'subtitle_ar' => $span ?: 'تصميم إبداعي',
            'content_ar' => $pText,
            'image' => $localFilename ? ('images/' . $slug . '/' . $localFilename) : '',
        ];
    }

    $scrapedData[] = [
        'name_ar' => $cat['name_ar'],
        'name_en' => $cat['name_en'],
        'slug' => $slug,
        'items' => $categoryItems,
    ];
}

file_put_contents(__DIR__ . '/data.json', json_encode($scrapedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "\nScrape complete! data.json updated.\n";
