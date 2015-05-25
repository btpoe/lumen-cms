<?php

use App\CMS\Models\Entry;
use App\CMS\Models\TemplateEntry;

class EntryServiceTest extends TestCase {

    public function testSetEntryTable()
    {
        $entryModel = new \App\CMS\Models\Entry([], 'test');
        $this->assertEquals(Entry::PREFIX.'test', $entryModel->getTable());
    }
    public function testSetExtendedEntryTable()
    {
        $entryModel = new TemplateEntry([], 'test');
        $this->assertEquals(TemplateEntry::PREFIX.'test', $entryModel->getTable());
    }

}
