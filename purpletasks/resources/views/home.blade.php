@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $placeholderImage = 'https://via.placeholder.com/800x500/FFE8C9/1B1B18?text=ELMO5AFED';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $dir }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'ELMO5AFED') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
        @php
            $hasViteAssets = file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'));
        @endphp
        @if ($hasViteAssets)
            @vite(['resources/css/home.css', 'resources/js/home.js'])
        @else
            @php
                $fallbackCss = resource_path('css/home.css');
                $fallbackJs = resource_path('js/home.js');
            @endphp
            @if (file_exists($fallbackCss))
                <style>{!! file_get_contents($fallbackCss) !!}</style>
            @endif
            @if (file_exists($fallbackJs))
                <script>{!! file_get_contents($fallbackJs) !!}</script>
            @endif
        @endif
    </head>
    <body class="{{ $dir === 'rtl' ? 'rtl' : 'ltr' }}">
        <header class="site-header">
            <div class="container header-inner">
                <div class="brand">
                    <span class="brand__logo">EL</span>
                    <span class="brand__text">{{ config('app.name', 'ELMO5AFED') }}</span>
                </div>
                <nav class="main-nav">
                    <a href="#about">{{ __('home.nav.about') }}</a>
                    <a href="#sections">{{ __('home.nav.sections') }}</a>
                    <a href="#services">{{ __('home.nav.services') }}</a>
                    <a href="#service-flow">{{ __('home.nav.steps') }}</a>
                    <a href="#faqs">{{ __('home.nav.faq') }}</a>
                    <a href="#support">{{ __('home.nav.support') }}</a>
                </nav>
                <div class="cta-group">
                    <a class="btn ghost" href="{{ url('/admin') }}">{{ __('home.nav.dashboard') }}</a>
                </div>
            </div>
        </header>

        <main>
            <section class="hero" data-hero-slider>
                <div class="hero__media">
                    @forelse($sliders as $slide)
                        @php
                            $image = $slide->getFirstMediaUrl('slider_cover') ?: $placeholderImage;
                            $title = strip_tags($slide->getTranslation('title', $locale));
                            $description = $slide->getTranslation('description', $locale);
                        @endphp
                        <article class="hero-slide {{ $loop->first ? 'is-active' : '' }}" style="--slide-image: url('{{ $image }}')">
                            <div class="hero-slide__overlay"></div>
                            <div class="hero-slide__content">
                                <p class="eyebrow">{{ __('home.hero.slide') }} {{ $loop->iteration }}</p>
                                <h1>{!! $title !!}</h1>
                                <p class="lead">{!! $description !!}</p>
                                <div class="hero-actions">
                                    <a class="btn primary" href="#support">{{ __('home.hero.cta') }}</a>
                                    <a class="btn ghost" href="#about">{{ __('home.read.more') }}</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="hero-empty">
                            <p>{{ __('home.hero.empty') }}</p>
                        </div>
                    @endforelse
                </div>
                <div class="hero__indicator">
                    <div class="dots">
                        @foreach($sliders as $slide)
                            <button type="button" class="dot {{ $loop->first ? 'is-active' : '' }}" data-hero-dot></button>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="about" class="section about">
                <div class="container about__grid">
                    <div class="about__media">
                        <img src="{{ $about?->getFirstMediaUrl('about_image') ?: $placeholderImage }}" alt="About" loading="lazy">
                    </div>
                    <div class="about__content">
                        <p class="eyebrow">{{ __('home.about.title') }}</p>
                        <h2>{!! $about?->getTranslation('intro', $locale) !!}</h2>
                        <div class="richtext">{!! $about?->getTranslation('content', $locale) !!}</div>
                    </div>
                </div>
            </section>

            <section id="sections" class="section sections">
                <div class="container">
                    <header class="section__head">
                        <p class="eyebrow">{{ __('home.sections.title') }}</p>
                        <h2>{{ __('home.sections.subtitle') }}</h2>
                    </header>
                    <div class="sections__grid">
                        @forelse($sections as $section)
                            <article class="section-card">
                                <div class="section-card__thumb">
                                    <img src="{{ $section->getFirstMediaUrl('category_image') ?: $placeholderImage }}" alt="{{ $section->getTranslation('name', $locale) }}" loading="lazy">
                                </div>
                                <h3>{{ $section->getTranslation('name', $locale) }}</h3>
                                <p>{{ strip_tags($section->getTranslation('description', $locale)) }}</p>
                            </article>
                        @empty
                            <p class="muted">{{ __('home.sections.empty') }}</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="services" class="section services">
                <div class="container">
                    <header class="section__head">
                        <p class="eyebrow">{{ __('home.services.title') }}</p>
                        <h2>{{ __('home.services.subtitle') }}</h2>
                    </header>
                    <div class="services__grid">
                        @forelse($services as $service)
                            @php
                                $serviceImage = $service->getFirstMediaUrl('service_gallery') ?: $placeholderImage;
                                $categoryName = $service->category?->getTranslation('name', $locale);
                                $featureList = collect($service->features)
                                    ->map(fn ($feature) => is_array($feature) ? ($feature['value'] ?? null) : $feature)
                                    ->filter()
                                    ->take(3);
                            @endphp
                            <article class="service-card">
                                <div class="service-card__image">
                                    <img src="{{ $serviceImage }}" alt="{{ $service->getTranslation('title', $locale) }}" loading="lazy">
                                    @if($categoryName)
                                        <span class="service-card__category">{{ $categoryName }}</span>
                                    @endif
                                </div>
                                <div class="service-card__body">
                                    <p class="service-card__date">{{ optional($service->updated_at)->translatedFormat('d/m/Y') }}</p>
                                    <h3>{!! $service->getTranslation('title', $locale) !!}</h3>
                                    <p class="service-card__excerpt">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($service->getTranslation('content', $locale)), 140) !!}
                                    </p>
                                    @if($featureList->isNotEmpty())
                                        <ul class="service-card__features">
                                            @foreach($featureList as $feature)
                                                <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <div class="service-card__meta">
                                        @if($service->price)
                                            <span>{{ __('home.services.price', ['price' => number_format($service->price, 2)]) }}</span>
                                        @endif
                                        @if($service->phone)
                                            <span>{{ __('home.services.phone', ['phone' => $service->phone]) }}</span>
                                        @endif
                                    </div>
                                    <div class="service-card__actions">
                                        <a class="btn primary full" href="{{ $service->phone ? 'tel:' . $service->phone : '#support' }}">
                                            {{ __('home.services.book') }}
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="muted">{{ __('home.services.empty') }}</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="service-flow" class="section steps">
                <div class="container">
                    <header class="section__head">
                        <p class="eyebrow">{{ __('home.steps.title') }}</p>
                        <h2>{{ __('home.steps.subtitle') }}</h2>
                        <p class="lead">{{ __('home.steps.description') }}</p>
                    </header>
                    <div class="steps__grid">
                        @if($serviceSteps->isNotEmpty())
                            @foreach($serviceSteps as $step)
                                <article class="step-card">
                                    <div class="step-card__number">{{ __('home.steps.step', ['number' => $step->step_number]) }}</div>
                                    <img src="{{ $step->getFirstMediaUrl('step_image') ?: $placeholderImage }}" alt="Step image" loading="lazy">
                                    <h3>{!! $step->getTranslation('title', $locale) !!}</h3>
                                    <p>{!! $step->getTranslation('description', $locale) !!}</p>
                                </article>
                            @endforeach
                        @else
                            <p class="muted">{{ __('home.steps.empty') }}</p>
                        @endif
                    </div>
                </div>
            </section>

            <section id="faqs" class="section faq">
                <div class="container">
                    <header class="section__head">
                        <p class="eyebrow">{{ $faqIntro?->getTranslation('title', $locale) ?? __('home.faqs.title') }}</p>
                        <h2>{{ $faqIntro?->getTranslation('description', $locale) ?? __('home.faqs.subtitle') }}</h2>
                    </header>
                    <div class="faq__items">
                        @forelse($faqItems as $item)
                            <div class="faq-item" data-faq-item>
                                <button class="faq-question" type="button" data-faq-toggle>
                                    <span>{{ $item->getTranslation('question', $locale) }}</span>
                                    <span class="icon">+</span>
                                </button>
                                <div class="faq-answer">
                                    <p>{!! $item->getTranslation('answer', $locale) !!}</p>
                                </div>
                            </div>
                        @empty
                            <p class="muted">{{ __('home.faqs.empty') }}</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="support" class="section support">
                <div class="container support__grid">
                    <div class="support__content">
                        <p class="eyebrow">{{ __('home.support.title') }}</p>
                        <h2>{!! $supportPage?->getTranslation('title', $locale) !!}</h2>
                        <div class="richtext">{!! $supportPage?->getTranslation('description', $locale) !!}</div>
                        <div class="support__image">
                            <img src="{{ $supportPage?->getFirstMediaUrl('support_image') ?: $placeholderImage }}" alt="Support illustration" loading="lazy">
                        </div>
                    </div>
                    <div class="support__form">
                        @if (session('support_submitted'))
                            <div class="alert success">
                                {{ __('home.support.success', ['ref' => session('support_receipt')]) }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('support.message.store') }}">
                            @csrf
                            <label>
                                <span>{{ __('home.support.name') }}</span>
                                <input type="text" name="full_name" required value="{{ old('full_name') }}">
                            </label>
                            <label>
                                <span>{{ __('home.support.phone') }}</span>
                                <input type="text" name="phone" value="{{ old('phone') }}">
                            </label>
                            <label>
                                <span>{{ __('home.support.email') }}</span>
                                <input type="email" name="email" value="{{ old('email') }}">
                            </label>
                            <label>
                                <span>{{ __('home.support.type') }}</span>
                                <select name="message_type" required>
                                    <option value="">{{ __('home.support.type_placeholder') }}</option>
                                    @foreach($supportTypes as $type)
                                        <option value="{{ $type['value'] }}" @selected(old('message_type') === $type['value'])>
                                            {{ $type['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label>
                                <span>{{ __('home.support.message') }}</span>
                                <textarea name="message" rows="4" required>{{ old('message') }}</textarea>
                            </label>
                            <button type="submit" class="btn primary full">{{ __('home.support.submit') }}</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container footer-inner">
                <p>© {{ date('Y') }} {{ config('app.name', 'ELMO5AFED') }} · {{ __('home.footer.rights') }}</p>
                <a href="{{ url('/admin') }}">{{ __('home.nav.dashboard') }}</a>
            </div>
        </footer>
    </body>
</html>

