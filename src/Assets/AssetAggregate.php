<?php
/**
 * This file belongs to PROJECT_NAME
 *
 * @copyright 2014 Vladimir Stračkovski
 * @license   The MIT License (MIT) <http://choosealicense.com/licenses/mit/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or visit the link above.
 */
namespace nv\PROJECT_NAME\Assets;

use Assetic\AssetManager;
use Assetic\FilterManager;
use Assetic\Factory\AssetFactory;
use Assetic\AssetWriter;
use Assetic\Filter\JSMinFilter;
use Assetic\Filter\CssMinFilter;
use Assetic\Factory\Worker\CacheBustingWorker;

/**
 * Class AssetAggregate
 *
 * Aggregates assets as defined in app/config/assets.php.
 * Provides dump and write methods.
 *
 * @package nv\PROJECT_NAME\Assets\AssetAggregate
 * @author Vladimir Stračkovski <vlado@nv3.org>
 */
class AssetAggregate
{
    /** @var \Assetic\AssetManager Asset manager */
    private $am;

    /** @var \Assetic\FilterManager Asset filter manager */
    private $fm;

    /** @var string Directory to dump output to */
    private $outputDir;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->am = new AssetManager();
        $this->fm = new FilterManager();

        if (!file_exists(dirname(dirname(dirname(__FILE__))) . "/config/assets.php")) {
            throw new \Exception("Missing asset configuration file.");
        }
        require dirname(dirname(dirname(__FILE__))) . "/config/assets.php";

        if (!isset($config)) {
            throw new \Exception("Invalid asset configuration file.");
        }

        if (is_array($config) and array_key_exists('assets_output_dir', $config)) {
            $this->outputDir = dirname(dirname(dirname(__FILE__))) .
                '/' . $config['assets_output_dir'];
        }
    }

    /**
     * Collect files, set filters
     */
    public function aggregate()
    {
        $this->fm->set('js_min', new JSMinFilter());
        $this->fm->set('css_min', new CssMinFilter());

        $factory = new AssetFactory(
            dirname(dirname(dirname(__FILE__))) . '/src/Assets/'
        );
        $factory->setAssetManager($this->am);
        $factory->setFilterManager($this->fm);
        $factory->addWorker(new CacheBustingWorker());
        $factory->setDebug(true);

        $js = $factory->createAsset(array(
            'js/*.js',
            dirname(dirname(dirname(__FILE__))) .
                '/vendor/twitter/bootstrap/dist/js/bootstrap.min.js'
        ), array(
            'js_min'
        ));

        $css = $factory->createAsset(array(
            dirname(dirname(dirname(__FILE__))) .
                '/vendor/twitter/bootstrap/dist/css/bootstrap.css',
            'css/*.css'
        ), array(
            'css_min'
        ));

        $css->setTargetPath('styles.css');
        $js->setTargetPath('scripts.js');

        $this->am->set('scripts', $js);
        $this->am->set('styles', $css);

        return $this;
    }

    /**
     *  Write aggregated assets to files
     */
    public function write()
    {
        $w = new AssetWriter($this->outputDir);
        try {
            $w->writeManagerAssets($this->am);
            return $this;
        } catch (\RuntimeException $e) {
            trigger_error($e->getMessage());
            return false;
        }
    }

    /**
     * Dump aggregated assets by collection type
     *
     * @param string $type Type of asset collection (scripts, styles, images)
     *
     * @return bool|string
     */
    public function dump($type)
    {
        if (in_array($type, $types = array('scripts', 'styles', 'images'))) {
            return $this->am->get($type)->dump();
        }
        trigger_error(
            "Trying to dump a non-existent type {$type}. ".
                "Expected ". implode(' or ', $types) . "."
        );
        return false;
    }
}
