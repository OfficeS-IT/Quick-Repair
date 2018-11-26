<?php namespace Sagenda\Tests\HelpersTests;
use Sagenda\Helpers\PickadateHelper;
use PHPUnit_Framework_TestCase;
require_once(dirname(dirname(__DIR__)) . '/helpers/PickadateHelper.php');

class PickadateHelperTest extends PHPUnit_Framework_TestCase
{
    public function testconvertWPtoJSDateDayD()
    {
        $dateFormatInput = "d/m/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertContains ("dd", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateDayJ()
    {
        $dateFormatInput = "j/m/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertContains ("d", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateDayJHaveOnlyOnD()
    {
        $dateFormatInput = "j/m/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertNotContains("dd", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateDayDisDDD()
    {
        $dateFormatInput = "D/m/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertContains("ddd", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateDayDisNotDDDD()
    {
        $dateFormatInput = "D/m/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertNotContains("dddd", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateDayLisDDDD()
    {
        $dateFormatInput = "l/m/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertContains("dddd", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateMonthMisMM()
    {
        $dateFormatInput = "l/m/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertContains("mm", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateMonthNisM()
    {
        $dateFormatInput = "l/n/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertContains("m", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateMonthNisNotMM()
    {
        $dateFormatInput = "l/n/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertNotContains("mm", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateMonthMisMMM()
    {
        $dateFormatInput = "l/M/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertContains("mmm", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateMonthMisNotMMMM()
    {
        $dateFormatInput = "l/M/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertNotContains("mmmm", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateMonthFisMMMM()
    {
        $dateFormatInput = "l/F/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertContains("mmmm", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateYearYisYY()
    {
        $dateFormatInput = "l/F/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertContains("yy", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateYearYisNotYYY()
    {
        $dateFormatInput = "l/F/y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertNotContains("yyy", $dateFormatOutput);
    }

    public function testconvertWPtoJSDateYearYisYYYY()
    {
        $dateFormatInput = "l/F/Y";
        $dateFormatOutput = PickadateHelper::convertWPtoJSDate($dateFormatInput);
        $this->assertContains("yyyy", $dateFormatOutput);
    }

    public function testconvertWPtoPickadateCultureCodeSwissGerman()
    {
        $cultureInput = "de_CH";
        $cultureOutput = PickadateHelper::convertWPtoPickadateCultureCode($cultureInput);
        $this->assertEquals("de_DE", $cultureOutput);
    }

    public function testconvertWPtoPickadateCultureCodeContainsUnderscore()
    {
        $cultureInput = "ca";
        $cultureOutput = PickadateHelper::convertWPtoPickadateCultureCode($cultureInput);
        $this->assertContains("_", $cultureOutput);
    }

    public function testconvertWPtoPickadateCultureCodeNotContainsDash()
    {
        $cultureInput = "el";
        $cultureOutput = PickadateHelper::convertWPtoPickadateCultureCode($cultureInput);
        $this->assertNotContains("-", $cultureOutput);
    }
}
