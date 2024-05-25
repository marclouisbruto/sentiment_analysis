<?php

include './vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;
use Sentiment\Analyzer;

class LanguageTranslator {
    protected $translator;

    public function convert($text, $sourceLanguage = null) {
        $this->translator = new GoogleTranslate('en');
        $this->setSourceLanguage($sourceLanguage);
        return $this->translator->translate($text);
    }
    
    public function setSourceLanguage($sourceLanguage) {
        $this->translator->setSource($sourceLanguage);
    }

    
}

class SentimentAnalyzerWrapper extends LanguageTranslator {
    private $analyzer;

    public function analyzeText($text) {
        $this->analyzer = new Analyzer();
        return $this->analyzer->getSentiment($text);
    }
}


?>
