<?php

namespace App\Service\Domain;

use App\Service\GptService;

class SummaryService
{
    private $gptService;
    private $promptSummary="Please provide me with a summary of the '{{seasonName}}' season of the series '{{serieName}}', detailing each episode. Use <h3> for the name and number of the episode, followed by a paragraph <p> with the summary. When mentioning characters, always use the tag <span class='character'> with the full name. It is crucial to include all main events, including twists and episode endings, covering significant details so that someone familiar can clearly recall. Stick strictly to the summary, avoiding detours or external suggestions. If parts are unknown, inform how far your knowledge extends, keeping the text direct and suitable for immediate publication.";

    public function __construct(GptService $gptService)
    {
        $this->gptService = $gptService;
    }

    public function getSummary($serieName, $seasonName): string
    {
        $prompt = str_replace(['{{seasonName}}', '{{serieName}}'], [$seasonName, $serieName], $this->promptSummary);
        return $this->gptService->simpleMessage($prompt);
    }

}