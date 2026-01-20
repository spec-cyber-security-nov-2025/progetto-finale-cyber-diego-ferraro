<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\HttpService;

class LatestNews extends Component
{
    public $selectedApi;
    public $news;
    protected $httpService;

    public function __construct()
    {
        $this->httpService = app(HttpService::class);
    }

    public function fetchNews()
    {
        // Mappa fissa delle fonti consentite
        $allowedSources = [
            'newsapi-it' => 'https://newsapi.org/v2/top-headlines?country=it&apiKey=' . env('NEWSAPI_KEY'),
            'newsapi-us' => 'https://newsapi.org/v2/top-headlines?country=us&apiKey=' . env('NEWSAPI_KEY'),
        ];

        if (!isset($allowedSources[$this->selectedApi])) {
            $this->news = 'Fonte non autorizzata';
            return;
        }

        $url = $allowedSources[$this->selectedApi];
        $response = $this->httpService->getRequest($url);

        $decoded = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $this->news = $decoded;
        } else {
            $this->news = 'Errore nella risposta della API';
        }
    }

    public function render()
    {
        return <<<'BLADE'
<div>
    <label for="source">Scegli una fonte per ispirarti:</label>
    <select wire:model.live="selectedApi" class="form-control">
        <option value="">-- Scegli --</option>
        <option value="newsapi-it">NewsAPI - IT</option>
        <option value="newsapi-us">NewsAPI - US</option>
    </select>

    <button wire:click="fetchNews" class="btn btn-primary mt-2">Carica ultime notizie</button>

    @if($news)
        <div class="mt-3">
            @if(is_string($news))
                <p class="text-danger">{{ $news }}</p>
            @else
                <pre>{{ json_encode($news, JSON_PRETTY_PRINT) }}</pre>
            @endif
        </div>
    @endif
</div>
BLADE;
    }
}