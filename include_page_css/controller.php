<?php
namespace Concrete\Package\IncludePageCss;

use Concrete\Core\Package\Package;
use Concrete\Core\Page\Theme\Theme;
use Concrete\Core\Support\Facade\Events;
use Concrete\Core\Support\Facade\Config;
use Concrete\Core\Page\Page;
use Concrete\Core\Asset\AssetList;

class Controller extends Package
{
    protected $pkgHandle = 'include_page_css';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '0.9';

    public function getPackageName()
    {
        return t("Include Page CSS");
    }

    public function getPackageDescription()
    {
        return t("Tries to include page specific css from your theme folder.");
    }

    /**
     * Look for a CSS file that equals the current page ID.
     * If it exists, add it as an asset.
     */
    public function on_start()
    {
        Events::addListener('on_page_view', function ($e) {
            $c = Page::getCurrentPage();
            $path_to_css = Config::get('include_page_css.path_to_css');

            // Could be: application/themes/bootstrap/css/183.css
            $path_to_page_css = $path_to_css.DIRECTORY_SEPARATOR.$c->getCollectionID().'.css';

            $assetHandle = 'cID'.$c->getCollectionID();

            $theme = Theme::getSiteTheme();

            $al = AssetList::getInstance();
            $al->register('css', $assetHandle, $path_to_page_css, [], $theme->getPackageHandle());

            $asset = $al->getAsset('css', $assetHandle);

            // Only include CSS file if it exists
            if (file_exists($asset->getAssetPath())) {
                $theme->requireAsset('css', $assetHandle);
            }
        });
    }

    public function install()
    {
        $theme = Theme::getSiteTheme();

        Config::save('include_page_css.path_to_css', 'themes'.DIRECTORY_SEPARATOR.$theme->getThemeHandle().DIRECTORY_SEPARATOR.DIRNAME_CSS);

        parent::install();
    }
}
