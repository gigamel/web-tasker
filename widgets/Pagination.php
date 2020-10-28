<?php
namespace widgets;

use abstractions\Base;

class Pagination extends Base
{
    /**
     * @const int DEFAULT_LIMIT
     */
    const DEFAULT_LIMIT = 10;

    /**
     * @var int $limit
     */
    public $limit;

    /**
     * @var int $max
     */
    public $max;

    /**
     * @var int $offset
     */
    public $offset;

    /**
     * @var int $page
     */
    public $page;

    /**
     * @var int $total
     */
    public $total;

    /**
     * @var string $query
     */
    public $query = 'page';

    /**
     * @var string $html
     */
    private $html;

    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        $params = is_array($params) ? $params : [];
        
        if (isset($params['query'])) {
            $this->query = empty($params['query']) ? $this->query
                : $params['query'];
        }

        $this->total = isset($params['total']) ? (int) $params['total'] : 0;

        $this->limit = isset($params['limit']) ? (int) $params['limit']
            : static::DEFAULT_LIMIT;
        
        $this->max = ceil($this->total / $this->limit);

        $this->page = isset($_GET[$this->query]) ? (int) $_GET[$this->query]
            : 1;
        if ($this->page > $this->max) {
            $this->page = $this->max;
        }
        if ($this->page < 1) {
            $this->page = 1;
        }

        $this->offset = ($this->page - 1) * $this->limit;
    }

    /**
     * @return string
     */
    public function widget()
    {
        if (is_null($this->html)) {
            $this->html = '';

            if ($this->max > 1) {
                $uriPart = parse_url(getenv('REQUEST_URI'));

                $this->html = '<ul class="pagination">';
                for ($page = 1; $page <= $this->max; $page++) {
                    $this->html .= '<li class="page-item';

                    if ($page == $this->page) {
                        $this->html .= ' active"><span class="page-link">'
                            . $page . '</span>';
                    } else {
                        $this->html .= '"><a href="' . $this->getLink($page)
                            . '" class="page-link">' . $page . '</a>';
                    }

                    $this->html .= '</li>';
                }
                $this->html .= '</ul>';
            }
        }
        
        return $this->html;
    }

    /**
     * @param int $number
     * @return string
     */
    protected function getLink($number = 1)
    {
        $uri = getenv('REQUEST_URI');
        
        $number = (int) $number;
        if ($number > 1) {
            if (empty($_GET) && empty(\Application::$app->route)) {
                $uri .= '?' . $this->query . '=' . $number;
            } else {
                if (isset($_GET[$this->query])) {
                    $uri = str_replace(
                        $this->query . '=' . $_GET[$this->query],
                        $this->query . '=' . $number,
                        $uri
                    );
                } else {
                    $uri .= '&' . $this->query . '=' . $number;
                }
            }
        } else {
            if (isset($_GET[$this->query])) {
                $prefixes = ['&', '?'];
                $search = $this->query . '=' . $_GET[$this->query];
                foreach ($prefixes as $prefix) {
                    $uri = str_replace($prefix . $search, '', $uri);
                }
            }
        }
        
        return $uri;
    }
}