<?php 
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

final class CrawlerTest extends TestCase
{
    public function test01() {
        $html = file_get_contents('http://195.154.118.169/sofyan/pompier/start.php?c=engin&t=panelengin');
        $crawler =new Crawler($html);
    }
}