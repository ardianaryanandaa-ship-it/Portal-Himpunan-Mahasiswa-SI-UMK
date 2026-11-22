<?php

use App\Libraries\LandingPageContent;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class LandingPageContentTest extends CIUnitTestCase
{
    public function testLandingPageDefaultsContainStaticRepeaterRows(): void
    {
        $defaults = LandingPageContent::defaults();

        $this->assertCount(4, LandingPageContent::parseRows($defaults['hero_highlights'], 2));
        $this->assertCount(6, LandingPageContent::parseRows($defaults['organization_bph_rows'], 2));
        $this->assertCount(5, LandingPageContent::parseRows($defaults['organization_department_rows'], 3));
        $this->assertCount(4, LandingPageContent::parseRows($defaults['program_rows'], 3));
        $this->assertCount(3, LandingPageContent::parseRows($defaults['testimonial_rows'], 4));
        $this->assertCount(5, LandingPageContent::parseRows($defaults['faq_fallback_rows'], 2));
        $this->assertCount(3, LandingPageContent::parseRows($defaults['events_fallback_rows'], 7));
        $this->assertCount(16, LandingPageContent::parseRows($defaults['gallery_fallback_rows'], 2));
        $this->assertCount(3, LandingPageContent::parseRows($defaults['news_fallback_rows'], 5));
    }

    public function testLandingPageFieldsAreSeparatedBySection(): void
    {
        $groups = LandingPageContent::fieldGroups();
        $expectedGroups = [
            'hero',
            'about',
            'vision',
            'organization',
            'programs',
            'events',
            'achievements',
            'gallery',
            'news',
            'testimonials',
            'faq',
            'footer',
        ];
        $fieldOwners = [];

        foreach ($expectedGroups as $groupKey) {
            $this->assertArrayHasKey($groupKey, $groups);
            $this->assertNotEmpty($groups[$groupKey]['fields']);

            foreach (array_keys($groups[$groupKey]['fields']) as $fieldKey) {
                $this->assertArrayNotHasKey($fieldKey, $fieldOwners);
                $fieldOwners[$fieldKey] = $groupKey;
            }
        }
    }

    public function testLandingPageRepeaterDefaultsRetainFieldShape(): void
    {
        $definitions = LandingPageContent::itemDefinitions();
        $this->assertCount(12, $definitions);
        $editableDefinitions = LandingPageContent::editableItemDefinitions();
        $itemTables = [];

        foreach ($definitions as $section => $definition) {
            $rows = LandingPageContent::defaultItemRows($section);
            $this->assertNotEmpty($rows);
            $this->assertSame(array_keys($definition['fields']), array_keys($rows[0]));
        }
        foreach ($editableDefinitions as $definition) {
            $this->assertArrayHasKey('table', $definition);
            $this->assertNotContains($definition['table'], $itemTables);
            $itemTables[] = $definition['table'];
        }

        $programs = LandingPageContent::defaultItemRows('program_rows');
        $this->assertCount(4, $programs);
        $this->assertSame('Insys Competition', $programs[0]['title']);
        $this->assertSame('UI/UX Competition', $programs[1]['title']);
    }

    public function testLandingPageValuesUseCodeDefinedContent(): void
    {
        $values = LandingPageContent::values();
        $defaults = LandingPageContent::defaults();

        $this->assertSame($defaults['hero_badge'], $values['hero_badge']);
        $this->assertSame(
            array_map('array_values', LandingPageContent::defaultItemRows('program_rows')),
            $values['program_rows_items']
        );
        $this->assertSame(
            array_map('array_values', LandingPageContent::defaultItemRows('faq_fallback_rows')),
            $values['faq_fallback_rows_items']
        );
    }

    public function testRowParserKeepsDelimiterInFinalColumn(): void
    {
        $rows = LandingPageContent::parseRows("Judul|Isi dengan | tanda", 2);

        $this->assertSame([['Judul', 'Isi dengan | tanda']], $rows);
    }
}
