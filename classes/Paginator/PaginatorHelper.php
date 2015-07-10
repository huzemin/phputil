<?

class PaginatorHelper {

    // 每页显示的条数
    var $pageSize;
    // 当前的页码
    var $page;
    // 总条数
    var $totalnum;
    // URL的组织模式
    var $urlPattern;

    // 分页显示的页码偏移
    var $offset = 4;

    // \Slim\Slim\App实例
    var $app;

    // Slim\Slim\Route的路由名称
    var $route_name;

    // Url的query模块
    var $query;

    // Slim\Slim\Route的路由参数
    var $route_params;

    public function __construct($app, $route_name, $page, $totalnum, $urlPattern = '', $pageSize = PAGE_SIZE) {
        $this->urlPattern = $urlPattern;
        $this->pageSize = $pageSize;
        $this->page = $page;
        $this->totalnum = $totalnum;
        $this->app = $app;
        $this->route_name = $route_name;
    }

    public function setQuery($query) {
        if(is_array($query)) {
            $this->query = http_build_query($query);
        } else {
            $this->query = $query;
        }

    }

    public function setPageSize($pageSize) {
        $this->pageSize = $pageSize;
    }

    public function setRouteParams(Array $params) {
        $this->route_params = $params;
    }

    public function getLink($app, $name, $opt) {
        $url = $app->urlfor($name, $opt);

        if(isset($this->query)) {
            $url = $url . '?' . $this->query;
        }
        return $url;
    }

    public function getTotalPage() {
        return ceil($this->totalnum / $this->pageSize);
    }

    public function getPaginate() {

        $totalpage = $this->getTotalPage();

        // 形成完整的URL
        if($this->urlPattern == ''){
            if(is_array($this->route_params)) {
                $params = array_merge($this->route_params, array('page'=>'@page'));
            } else {
                $params = array('page'=>'@page');
            }
            $url = $this->getLink($this->app, $this->route_name, $params);
        } else {
            $url = $this->urlPattern;
        }

        if($this->page < 1) {
            $this->page = 1;
        }

        if($this->page > $totalpage) {
            $this->page = $totalpage;
        }

        // 生成分页的HTML
        $html = '<div class="text-center"><ul class="pagination pagination-sm">';
            if($this->page > 1) {
                $html .= '<li><a href="'.str_replace("@page",1, $url).
                    '" title="第一页"><i class="glyphicon glyphicon glyphicon-backward"></i></a></li>';
                $html .= '<li><a href="'.str_replace("@page", $this->page - 1, $url).
                    '" aria-label="上一页" title="上一页"><span aria-hidden="true">&laquo;</span></a></li>';
            } else {
                $html .= '<li class="disabled"><a aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
            }
            if($this->page > $this->offset) {
                for($i = ($this->page - $this->offset); $i <= $this->page ; $i++) {
                    if($this->page == $i)
                        $html .= '<li class="disabled"><a>'.$i.'</a></li>';
                    else
                        $html .= '<li><a href="'.str_replace("@page",$i, $url).'">'.$i.'</a></li>';
                }

            } else {
                for($i = 1; $i <= $this->page ; $i++) {

                    if($this->page == $i)
                        $html .= '<li class="disabled"><a>'.$i.'</a></li>';
                    else
                        $html .= '<li><a href="'.str_replace("@page",$i, $url).'">'.$i.'</a></li>';
                }

            }

            if($this->page > ($totalpage - $this->offset)) {
                for($i = $this->page + 1; $i <= $totalpage ; $i++) {
                    $html .= '<li><a href="'.str_replace("@page",$i, $url).'">'.$i.'</a></li>';
                }
            } else {
                for($i = $this->page + 1; $i <= ($this->page+$this->offset) ; $i++) {
                    $html .= '<li><a href="'.str_replace("@page",$i, $url).'">'.$i.'</a></li>';
                }
            }

            if($this->page < $totalpage) {
                $html .= '<li><a href="'.str_replace("@page",$this->page + 1, $url).
                    '" aria-label="下一页" title="下一页"><span aria-hidden="true">&raquo;</span></a></li>';
                $html .= '<li><a href="'.str_replace("@page",$totalpage, $url).
                    '" title="最后一页"><i class="glyphicon glyphicon-forward"></i></a></li>';
            } else {
                $html .= '<li  class="disabled"><a aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
            }
        $html .='<li  class="disabled"><a>'.$totalpage.'页/'.$this->totalnum.'条</a></li>';
        $html.="</ul></div>";
        return $html;
    }
}
?>
