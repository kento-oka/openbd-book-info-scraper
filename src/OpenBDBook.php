<?php
/**
 * kentoka/openbd-book-info-scraper
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Kento Oka <kento-oka@kentoka.com>
 * @copyright   (c) Kento Oka
 * @license     MIT
 * @since       1.0.0
 */
namespace Kentoka\BookScraper\OpenBD;

use Kentoka\BookInfoScraper\Information\Book;

/**
 *
 */
class OpenBDBook extends Book{

    public const ONIX       = "onix";
    public const HANMOTO    = "hanmoto";
    public const SUMMARY    = "summary";

    /**
     * @var mixed[]
     */
    private $data;

    /**
     * Constructor.
     *
     * @param   mixed[] $data
     */
    public function __construct(array $data){
        $this->data = $data;

        parent::__construct(
            $this->get("RecordReference"),
            $this->get("DescriptiveDetail.TitleElement.TitleText.content")
        );
    }

    /**
     * Get raw data.
     *
     * @param string $accessKey
     * @param string $source
     *
     * @return mixed|null
     */
    public function get(string $accessKey, string $source = self::ONIX){
        $data   = $this->data[$source] ?? null;

        foreach(explode(".", $accessKey) as $key){
            if(!is_array($data) || !isset($data[$key])){
                return null;
            }

            $data   = $data[$key];
        }

        if("" === $data){
            return null;
        }

        return $data;
    }
}