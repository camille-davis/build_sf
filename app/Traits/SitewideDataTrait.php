<?php

namespace App\Traits;

use App\Models\Block;
use App\Models\Page;
use App\Models\Section;
use App\Models\Settings;

// Deals with sitewide data including global settings, nav links, and footer blocks.
trait SitewideDataTrait
{
    // Get an array of sitewide data to display.
    public function getSitewideData()
    {
        // Get nav links.
        // If nav is set to 'pages', get all pages for nav links.
        $settings = Settings::find(1);
        if ($settings && $settings->nav_type == 'pages') {
            $navLinks = Page::getAll();

        // Otherwise, if there's a homepage, default to homepage section links.
        } else {
            $homepage = Page::where('homepage', 1)->first();
            if ($homepage !== null) {
                $navLinks = Section::getAllRaw($homepage->id);
            }
        }

        // Get footer blocks.
        $footerBlocks = Block::getAllInLocation('footer');

        return [
            'settings' => $settings,
            'navLinks' => $navLinks,
            'footerBlocks' => $footerBlocks,
        ];
    }
}
